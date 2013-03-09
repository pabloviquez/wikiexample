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
    private $_configs;

    /**
     * Class construct, private to avoid direct instantiation
     */
    private function __construct()
    {
        // Lets now calculate where the config file is
        $configFile = realpath(dirname(__FILE__) . '/../config/config.ini');
        $this->_configs = parse_ini_file($configFile);
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
     * Returns the configuration for the app
     *
     * @return array
     */
    public function getConfigs()
    {
        return $this->_configs;
    }
}
