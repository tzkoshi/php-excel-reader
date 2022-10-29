<?php

namespace PHPExcelReader;

class Utils
{

    /**
     * A class for reading Microsoft Excel (97/2003) Spreadsheets.
     *
     * Version 2.21
     *
     * Enhanced and maintained by Matt Kruse < http://mattkruse.com >
     * Maintained at http://code.google.com/p/php-excel-reader/
     *
     * Format parsing and MUCH more contributed by:
     *    Matt Roxburgh < http://www.roxburgh.me.uk >
     *
     * DOCUMENTATION
     * =============
     *   http://code.google.com/p/php-excel-reader/wiki/Documentation
     *
     * CHANGE LOG
     * ==========
     *   http://code.google.com/p/php-excel-reader/wiki/ChangeHistory
     *
     * DISCUSSION/SUPPORT
     * ==================
     *   http://groups.google.com/group/php-excel-reader-discuss/topics
     *
     * --------------------------------------------------------------------------
     *
     * Originally developed by Vadim Tkachenko under the name PHPExcelReader.
     * (http://sourceforge.net/projects/phpexcelreader)
     * Based on the Java version by Andy Khan (http://www.andykhan.com).  Now
     * maintained by David Sanders.  Reads only Biff 7 and Biff 8 formats.
     *
     * PHP versions 4 and 5
     *
     * LICENSE: This source file is subject to version 3.0 of the PHP license
     * that is available through the world-wide-web at the following URI:
     * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
     * the PHP License and are unable to obtain it through the web, please
     * send a note to license@php.net so we can mail you a copy immediately.
     *
     * @category   Spreadsheet
     * @package	Spreadsheet_Excel_Reader
     * @author	 Vadim Tkachenko <vt@apachephp.com>
     * @license	http://www.php.net/license/3_0.txt  PHP License 3.0
     * @version	CVS: $Id: reader.php 19 2007-03-13 12:42:41Z shangxiao $
     * @link	   http://pear.php.net/package/Spreadsheet_Excel_Reader
     * @see		OLE, Spreadsheet_Excel_Writer
     * --------------------------------------------------------------------------
     */
    public static function GetInt4d($data, $pos)
    {
        $value = ord($data[$pos]) | (ord($data[$pos + 1]) << 8) | (ord($data[$pos + 2]) << 16) | (ord($data[$pos + 3]) << 24);
        if ($value >= 4294967294) {
            $value = -2;
        }
        return $value;
    }

    public static function gmgetdate($ts = null)
    {
        $k = array('seconds', 'minutes', 'hours', 'mday', 'wday', 'mon', 'year', 'yday', 'weekday', 'month', 0);
        return (self::array_comb($k, explode(":", gmdate('s:i:G:j:w:n:Y:z:l:F:U', is_null($ts) ? time() : $ts))));
    }

    public static function array_comb($array1, $array2)
    {
        $out = array();
        foreach ($array1 as $key => $value) {
            $out[$value] = $array2[$key];
        }
        return $out;
    }

    public static function v($data, $pos)
    {
        return ord($data[$pos]) | ord($data[$pos + 1]) << 8;
    }
}
