<?php

namespace inzh\talend\job\manager\tool;

use Exception;

/**
 * Tool for file or directory.
 *
 * @author Jean-Raffi Nazareth <jr-nazareth@inzh.fr>
 * @copyright Copyright © 2011-2022 [InZH] Studio.
 */
class FileTool
{
    public static function getList($d, $ignoreHidden = true)
    {
        if (!is_dir($d)) {
            throw new Exception("Directory not found '" . $d . "'");
        }
        $ar = scandir($d);
        $rar = array();
        $nb = count($ar);

        for ($i = 0; $i < $nb; $i++) {
            $n = $ar[$i];
            if ($n != ".." && $n != ".") {
                if ($ignoreHidden && StringTool::startsWith($n, ".")) {
                    continue;
                }

                $file = $d . DIRECTORY_SEPARATOR . $n;
                $pi = pathinfo($file);
                $pi["file"] = $file;
                $rar[] = $pi;
            }
        }
        return $rar;
    }
}
