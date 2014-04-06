<?php

/* 
 * knt-crafty: a fork of Crafty, a php dependency injector
 * 
 * Licensed under The MIT License
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * Crafty (the original) was licensed under the 
 * GNU LESSER GENERAL PUBLIC LICENSE Version 3, 29 June 2007
 * 
 * Original project: http://sourceforge.net/projects/phpcrafty/
 * 
 * @link          http://www.kaonet-fr.net/cms
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/*
 * Crafty.php: entry point. 
 * This should be the only file included in a non-autoload context.
 * It will actualy register its own autoloader just dedicated to Crafty.
 */

namespace Knt\Crafty;

//Do we need an autoloader?
if (!class_exists('\Knt\Crafty\ComponentFactory', true)) {
    //Yes, this is a basic test, maybe the component factory has been
    //included manualy, but for now, this is enough. 
    //So yes, we need an autoloader.

    spl_autoload_register(function ($className) {

        if (strpos($className, 'Knt\Crafty') === false) {
            return false;
        }

        $fileName = 
            __DIR__
            .str_replace('\\', '/',
                str_replace('Knt\Crafty', '', $className)
            )
            .'.php'
        ;

        if (file_exists($fileName)) {
            require $fileName;
            return  true;
        }

        return false;

    });
    
}