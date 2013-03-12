<?php
/**
 * Batch handler
 *
 * @file
 * @ingroup CodeExercise
 *
 * @author Pablo Viquez <pviquez@pabloviquez.com>
 */

namespace Lib\Rates;

use Lib\Config;

/**
 * Batch class, will take care of reading and parsing the 3rd party service
 *
 * @category CodeExercise
 * @package Lib
 * @subpackage Rates
 */
class Batch
{
    /**
     * Service URL
     *
     * @var string
     */
    private $_serviceUrl;

    /**
     * Data from 3rd party service
     *
     * @var \SimpleXMLElement
     */
    private $_data;

    /**
     * Constructs the class and configures the batch
     */
    public function __construct()
    {
        $config = Config::getInstance()->getConfig();
        $this->setServiceUrl($config['service_url']);
    }

    /**
     * Executes the retrieval and parsing of the 3rd party service
     *
     * @return void
     */
    public function run()
    {
        // Lets get the data
        $this->_loadServiceData();

        // Now lets parse and store it
        $this->_parseAndSave();
    }

    /**
     * Queries and constructs the XML documet out of the 3rd party data
     *
     * @return void
     */
    private function _loadServiceData()
    {
        $this->_data = simplexml_load_file($this->getServiceUrl());
    }

    /**
     * Parses and saves into the DB the data
     *
     * @return void
     */
    private function _parseAndSave()
    {
        if (!$this->_data instanceof \SimpleXMLElement) {
            return false;
        }

        $rates = array();
        foreach ($this->_data as $conversion) {
            if (!is_numeric($conversion->rate)) {
                continue;
            }

            $currency = (string) $conversion->currency;
            $rates[$currency] = (string) $conversion->rate;
        }

        $dao = new Dao();
        $dao->save($rates);
    }

    /**
     * Retrieves the property value
     *
     * @return string
     */
    public function getServiceUrl()
    {
        return $this->_serviceUrl;
    }

    /**
     * Sets the property value
     *
     * @param string $_serviceUrl
     * @return Batch
     */
    public function setServiceUrl($serviceUrl)
    {
        $this->_serviceUrl = $serviceUrl;
        return $this;
    }

    /**
     * Retrieves the property value
     *
     * @return SimpleXMLElement
     */
    public function getData()
    {
        return $this->_data;
    }
}
