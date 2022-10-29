<?php

namespace PHPExcelReader;

class OLERead
{
    var $data = '';

    function OLERead()
    {
    }

    function read($sFileName)
    {
        // check if file exist and is readable (Darko Miljanovic)
        if (!is_readable($sFileName)) {
            $this->error = 1;
            return false;
        }
        $this->data = @file_get_contents($sFileName);
        if (!$this->data) {
            $this->error = 1;
            return false;
        }
        if (substr($this->data, 0, 8) != Globals::getIdentifierOLE()) {
            $this->error = 1;
            return false;
        }
        $this->numBigBlockDepotBlocks = Utils::GetInt4d($this->data, Globals::getNumBigBlockDepotBlocksPos());
        $this->sbdStartBlock = Utils::GetInt4d($this->data, Globals::getSmallBlockDepotBlockPos());
        $this->rootStartBlock = Utils::GetInt4d($this->data, Globals::getRootStartBlockPos());
        $this->extensionBlock = Utils::GetInt4d($this->data, Globals::getExtensionBlockPos());
        $this->numExtensionBlocks = Utils::GetInt4d($this->data, Globals::getNumExtensionBlockPos());

        $bigBlockDepotBlocks = array();
        $pos = Globals::getBigBlockDepotBlocksPos();
        $bbdBlocks = $this->numBigBlockDepotBlocks;
        if ($this->numExtensionBlocks != 0) {
            $bbdBlocks = (Globals::getBigBlockSize() - Globals::getBigBlockDepotBlocksPos()) / 4;
        }

        for ($i = 0; $i < $bbdBlocks; $i++) {
            $bigBlockDepotBlocks[$i] = Utils::GetInt4d($this->data, $pos);
            $pos += 4;
        }

        for ($j = 0; $j < $this->numExtensionBlocks; $j++) {
            $pos = ($this->extensionBlock + 1) * Globals::getBigBlockSize();
            $blocksToRead = min($this->numBigBlockDepotBlocks - $bbdBlocks, Globals::getBigBlockSize() / 4 - 1);

            for ($i = $bbdBlocks; $i < $bbdBlocks + $blocksToRead; $i++) {
                $bigBlockDepotBlocks[$i] = Utils::GetInt4d($this->data, $pos);
                $pos += 4;
            }

            $bbdBlocks += $blocksToRead;
            if ($bbdBlocks < $this->numBigBlockDepotBlocks) {
                $this->extensionBlock = Utils::GetInt4d($this->data, $pos);
            }
        }

        // readBigBlockDepot
        $pos = 0;
        $index = 0;
        $this->bigBlockChain = array();

        for ($i = 0; $i < $this->numBigBlockDepotBlocks; $i++) {
            $pos = ($bigBlockDepotBlocks[$i] + 1) * Globals::getBigBlockSize();
            //echo "pos = $pos";
            for ($j = 0; $j < Globals::getBigBlockSize() / 4; $j++) {
                $this->bigBlockChain[$index] = Utils::GetInt4d($this->data, $pos);
                $pos += 4;
                $index++;
            }
        }

        // readSmallBlockDepot();
        $pos = 0;
        $index = 0;
        $sbdBlock = $this->sbdStartBlock;
        $this->smallBlockChain = array();

        while ($sbdBlock != -2) {
            $pos = ($sbdBlock + 1) * Globals::getBigBlockSize();
            for ($j = 0; $j < Globals::getBigBlockSize() / 4; $j++) {
                $this->smallBlockChain[$index] = Utils::GetInt4d($this->data, $pos);
                $pos += 4;
                $index++;
            }
            $sbdBlock = $this->bigBlockChain[$sbdBlock];
        }

        // readData(rootStartBlock)
        $block = $this->rootStartBlock;
        $pos = 0;
        $this->entry = $this->__readData($block);
        $this->__readPropertySets();
    }

    function __readData($bl)
    {
        $block = $bl;
        $pos = 0;
        $data = '';
        while ($block != -2) {
            $pos = ($block + 1) * Globals::getBigBlockSize();
            $data = $data . substr($this->data, $pos, Globals::getBigBlockSize());
            $block = $this->bigBlockChain[$block];
        }
        return $data;
    }

    function __readPropertySets()
    {
        $offset = 0;
        while ($offset < strlen($this->entry)) {
            $d = substr($this->entry, $offset, Globals::getPropertyStorageBlockSize());
            $nameSize = ord($d[Globals::getSizeOfNamePos()]) | (ord($d[Globals::getSizeOfNamePos() + 1]) << 8);
            $type = ord($d[Globals::getTypePos()]);
            $startBlock = Utils::GetInt4d($d, Globals::getStartBlockPos());
            $size = Utils::GetInt4d($d, Globals::getSizePos());
            $name = '';
            for ($i = 0; $i < $nameSize; $i++) {
                $name .= $d[$i];
            }
            $name = str_replace("\x00", "", $name);
            $this->props[] = array(
                'name'       => $name,
                'type'       => $type,
                'startBlock' => $startBlock,
                'size'       => $size
            );
            if ((strtolower($name) == "workbook") || (strtolower($name) == "book")) {
                $this->wrkbook = count($this->props) - 1;
            }
            if ($name == "Root Entry") {
                $this->rootentry = count($this->props) - 1;
            }
            $offset += Globals::getPropertyStorageBlockSize();
        }

    }

    function getWorkBook()
    {
        if ($this->props[$this->wrkbook]['size'] < Globals::getSmallBlockThreshold()) {
            $rootdata = $this->__readData($this->props[$this->rootentry]['startBlock']);
            $streamData = '';
            $block = $this->props[$this->wrkbook]['startBlock'];
            $pos = 0;
            while ($block != -2) {
                $pos = $block * Globals::getSmallBlockSize();
                $streamData .= substr($rootdata, $pos, Globals::getSmallBlockSize());
                $block = $this->smallBlockChain[$block];
            }
            return $streamData;
        } else {
            $numBlocks = $this->props[$this->wrkbook]['size'] / Globals::getBigBlockSize();
            if ($this->props[$this->wrkbook]['size'] % Globals::getBigBlockSize() != 0) {
                $numBlocks++;
            }

            if ($numBlocks == 0) return '';
            $streamData = '';
            $block = $this->props[$this->wrkbook]['startBlock'];
            $pos = 0;
            while ($block != -2) {
                $pos = ($block + 1) * Globals::getBigBlockSize();
                $streamData .= substr($this->data, $pos, Globals::getBigBlockSize());
                $block = $this->bigBlockChain[$block];
            }
            return $streamData;
        }
    }

}
