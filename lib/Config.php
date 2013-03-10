<?php
/**
 * Developer interview task (Mobile)
 *
 * @file
 * @ingroup CodeExercise
 *
 * @author Pablo Viquez <pviquez@pabloviquez.com>
 */
namespace Lib;

/**
 * Class that takes care of all configuration settings
 *
 * An instance of this class will be created automatically upon requiring the
 * file for the first time. The class is set as a singleton so there's no overhead
 */
class Config
{
    /**
     * Class instance, will be handle as a singleton
     *
     * @var Config
     */
    private static $_instance;

    /**
     * Array with all the app configurations
     *
     * @var array
     */
    private $_config;

    /**
     * Class construct, private to avoid direct instantiation
     */
    private function __construct()
    {
        // Lets now calculate where the config file is
        $configFile = realpath(dirname(__FILE__) . '/../config/config.ini');
        $this->_config = parse_ini_file($configFile);

        // Register the autoloader
        spl_autoload_register(array($this, 'autoloader'));
    }

    /**
     * Retrieves the instance of the class, if it does not exists, then create it
     *
     * @return Config
     */
    public static function getInstance()
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self;
        }

        return self::$_instance;
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
        $className = str_replace('\\', '/', $className);
        $fileToLoad = dirname(__FILE__) . DIRECTORY_SEPARATOR . $className . '.php';

        // Load the file
        require_once $fileToLoad;
    }

    /**
     * Returns the configuration for the app
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->_config;
    }
}

// Lets load the class to register the autoloader, since its singleton there are
// no extra overheads
Config::getInstance();
