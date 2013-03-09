<?php
/**
 * Batch handler
 *
 * @file
 * @ingroup CodeExercise
 *
 * @author Pablo Viquez <pviquez@pabloviquez.com>
 */

namespace Lib;

/**
 * Batch class, will take care of managing the batch
 *
 */
class Batch {
    /**
     * Public class constructor
     */
    public function __construct()
    {
        spl_autoload_register(array($this, 'autoloader'));
    }

    /**
     * Callback function for the autoloader
     *
     * @param string $class
     * @return void
     */
    public function autoloader($class)
    {
        // If the namespace is present, lets remove it
        $className = str_replace(__NAMESPACE__ . '\\', '', $class);
        $fileToLoad = dirname(__FILE__) . DIRECTORY_SEPARATOR . $className . '.php';

        // Load the file
        require_once $fileToLoad;
    }
}
