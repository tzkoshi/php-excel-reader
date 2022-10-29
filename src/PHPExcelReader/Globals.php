<?php

namespace PHPExcelReader;

class Globals
{
    const SPREADSHEET_EXCEL_READER_DEF_NUM_FORMAT = "%s";
    const SPREADSHEET_EXCEL_READER_TYPE_STANDARDWIDTH = 0x99;
    const SPREADSHEET_EXCEL_READER_TYPE_DEFCOLWIDTH = 0x55;
    const SPREADSHEET_EXCEL_READER_TYPE_COLINFO = 0x7d;
    const SPREADSHEET_EXCEL_READER_TYPE_HYPER = 0x01b8;
    const SPREADSHEET_EXCEL_READER_MSINADAY = 86400;
    const SPREADSHEET_EXCEL_READER_UTCOFFSETDAYS1904 = 24107;
    const SPREADSHEET_EXCEL_READER_UTCOFFSETDAYS = 25569;
    const SPREADSHEET_EXCEL_READER_TYPE_MERGEDCELLS = 0xE5;
    const SPREADSHEET_EXCEL_READER_TYPE_NINETEENFOUR = 0x22;
    const SPREADSHEET_EXCEL_READER_TYPE_UNKNOWN = 0xffff;
    const SPREADSHEET_EXCEL_READER_TYPE_PALETTE = 0x0092;
    const SPREADSHEET_EXCEL_READER_TYPE_FONT = 0x0031;
    const SPREADSHEET_EXCEL_READER_TYPE_BOOLERR = 0x205;
    const SPREADSHEET_EXCEL_READER_TYPE_XF = 0xe0;
    const SPREADSHEET_EXCEL_READER_TYPE_FORMAT = 0x41e;
    const SPREADSHEET_EXCEL_READER_TYPE_FORMULA2 = 0x6;
    const SPREADSHEET_EXCEL_READER_TYPE_FORMULA = 0x406;
    const SPREADSHEET_EXCEL_READER_TYPE_STRING = 0x207;
    const SPREADSHEET_EXCEL_READER_TYPE_ARRAY = 0x221;
    const SPREADSHEET_EXCEL_READER_TYPE_NAME = 0x18;
    const SPREADSHEET_EXCEL_READER_TYPE_NUMBER = 0x203;
    const SPREADSHEET_EXCEL_READER_TYPE_LABELSST = 0xfd;
    const SPREADSHEET_EXCEL_READER_TYPE_LABEL = 0x204;
    const SPREADSHEET_EXCEL_READER_TYPE_CONTINUE = 0x3c;
    const SPREADSHEET_EXCEL_READER_TYPE_EXTSST = 0xff;
    const SPREADSHEET_EXCEL_READER_TYPE_SST = 0xfc;
    const SPREADSHEET_EXCEL_READER_TYPE_INDEX = 0x20b;
    const SPREADSHEET_EXCEL_READER_TYPE_MULBLANK = 0xbe;
    const SPREADSHEET_EXCEL_READER_TYPE_MULRK = 0xbd;
    const SPREADSHEET_EXCEL_READER_TYPE_RK2 = 0x27e;
    const SPREADSHEET_EXCEL_READER_TYPE_RK = 0x7e;
    const SPREADSHEET_EXCEL_READER_TYPE_TXO = 0x1b6;
    const SPREADSHEET_EXCEL_READER_TYPE_NOTE = 0x1c;
    const SPREADSHEET_EXCEL_READER_TYPE_FILEPASS = 0x2f;
    const SPREADSHEET_EXCEL_READER_TYPE_DBCELL = 0xd7;
    const SPREADSHEET_EXCEL_READER_TYPE_ROW = 0x208;
    const SPREADSHEET_EXCEL_READER_TYPE_DIMENSION = 0x200;
    const SPREADSHEET_EXCEL_READER_TYPE_BOUNDSHEET = 0x85;
    const SPREADSHEET_EXCEL_READER_TYPE_EOF = 0x0a;
    const SPREADSHEET_EXCEL_READER_TYPE_BOF = 0x809;
    const SPREADSHEET_EXCEL_READER_WORKSHEET = 0x10;
    const SPREADSHEET_EXCEL_READER_WORKBOOKGLOBALS = 0x5;
    const SPREADSHEET_EXCEL_READER_BIFF7 = 0x500;
    const SPREADSHEET_EXCEL_READER_BIFF8 = 0x600;

    public static function getNumBigBlockDepotBlocksPos()
    {
        return 0x2c;
    }

    public static function getSmallBlockDepotBlockPos()
    {
        return 0x3c;
    }

    public static function getRootStartBlockPos()
    {
        return 0x30;
    }

    public static function getBigBlockSize()
    {
        return 0x200;
    }

    public static function getSmallBlockSize()
    {
        return 0x40;
    }

    public static function getExtensionBlockPos()
    {
        return 0x44;
    }

    public static function getNumExtensionBlockPos()
    {
        return 0x48;
    }

    public static function getPropertyStorageBlockSize()
    {
        return 0x80;
    }

    public static function getBigBlockDepotBlocksPos()
    {
        return 0x4c;
    }

    public static function getSmallBlockThreshold()
    {
        return 0x1000;
    }

    // property storage offsets

    public static function getSizeOfNamePos()
    {
        return 0x40;
    }

    public static function getTypePos()
    {
        return 0x42;
    }

    public static function getStartBlockPos()
    {
        return 0x74;
    }

    public static function getSizePos()
    {
        return 0x78;
    }

    public static function getIdentifierOLE()
    {
        return pack("CCCCCCCC", 0xd0, 0xcf, 0x11, 0xe0, 0xa1, 0xb1, 0x1a, 0xe1);
    }
}
