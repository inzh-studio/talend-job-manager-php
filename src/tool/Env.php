<?php

namespace inzh\talend\job\manager\tool;

/**
 * Environment tool management
 *
 * @author Jean-Raffi Nazareth <jr-nazareth@inzh.fr>
 * @copyright Copyright © 2011-2022 [InZH] Studio.
 */
class Env
{
    const DOS = 1;
    const UNIX = 2;

    public static function getCurrent()
    {
        if (strpos(PHP_OS, 'WIN') === 0) {
            return Env::DOS;
        }
        return Env::UNIX;
    }
}
