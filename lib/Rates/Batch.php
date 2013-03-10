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
     * Queries and returns the 3rd party data
     *
     * @return array
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
/*
function postXml($xmlBody) {
    if (!$xmlBody) {
        //return null;
    }

    $certFilePath =
        realpath(
            dirname(__FILE__) .
            DIRECTORY_SEPARATOR .
            '..' . DIRECTORY_SEPARATOR .
            'resources' . DIRECTORY_SEPARATOR . 'cacert.pem');

    $zMailUrl = 'https://www.zdirect.com/api/append_data';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_URL, $zMailUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlBody);

    $content = curl_exec($ch);

    // If the error is due SSL certificate, lets use one thats valid
    // Peer certificate cannot be authenticated with known CA certificates.
    if (curl_errno($ch) == 60) { // CURLE_SSL_CACERT
        curl_setopt($ch, CURLOPT_CAINFO, $certFilePath);
        $content = curl_exec($ch);
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return trim($content);
}
*/
