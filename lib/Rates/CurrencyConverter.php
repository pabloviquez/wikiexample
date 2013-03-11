<?php
/**
 * Developer interview task (Mobile)
 *
 * @file
 * @ingroup CodeExercise
 *
 * @author Pablo Viquez <pviquez@pabloviquez.com>
 */

/**
 * Namespace definition
 */
namespace Lib\Rates;

/**
 * Uses definition
 */
use \Lib\Rates\Dao;

/**
 * Currency converter class, responsible of the money conversion
 */
class CurrencyConverter
{
    /**
     * Parses the currency and amount given and returns an array with the respective
     * currency conversion
     *
     * This function converts from * to *
     *
     * @param string $currency
     * @param array $values Array with the following format:
     *                      array(
     *                          'JPY 5000',
     *                          'CZK 62.5',
     *                          ...
     *                      );
     * @return array
     */
    public static function convert($currency, array $values)
    {
        $c = new self;
        $currency = strtoupper($currency);

        switch ($currency) {
            case 'USD' :
                return $c->getDollars($values);
            default :
                return $c->getCurrencies($currency, $values);
        }
    }

    /**
     * Parses the currency and amount given and returns an array with the respective
     * dollar conversion
     *
     * This function translate currency to dollars
     *
     * @param array $values Array with the following format:
     *                      array(
     *                          'JPY 5000',
     *                          'CZK 62.5',
     *                      );
     * @return array
     */
    public function getDollars(array $values)
    {
        // Lets retrieve the conversion rates just for the required currencies
        $currencies = array();
        foreach ($values as $value) {
            $currency = sscanf($value, '%s %s');
            $currencies[$currency[0]] = $currency[1];
        }

        $reqCurrencies = array_keys($currencies);
        $rates = $this->_getRates($reqCurrencies);
        $result = array();

        // Now lets do the conversion
        foreach ($currencies as $currency => $amount) {
            // if the requested currency is not supported return NA
            if (!array_key_exists($currency, $rates)) {
                $result[] = "Not available rate for {$currency}";
                continue;
            }

            $dollars = (float)$amount * (float)$rates[$currency];
            $result[] = 'USD ' . number_format($dollars, 2);
        }

        return $result;
    }

    /**
     * With the given currency, retrieves the amount in the currency requested
     * from dollars
     *
     * This function translate Dollars to the currency
     *
     * @param string $currency
     * @param array $values Array with the following format:
     *                      array(
     *                          'USD 10',
     *                          'USD 25',
     *                      );
     * @return array
     */
    public function getCurrencies($currency, array $values)
    {
        $rates = $this->_getRates(array($currency));
        $results = array();

        foreach ($values as $value) {
            $dollar = sscanf($value, '%s %s');

            // Lets convert the values
            $dollars = (float) $dollar[1] / (float) $rates[$currency];
            $results[] = "{$currency} " . number_format($dollars, 2);
        }

        return $results;
    }

    /**
     * Retrieves all the currency codes stored in the DB
     *
     * @return array
     */
    public static function getSupportedCurrencies()
    {
        $dao = new Dao();
        return $dao->getCodes();
    }

    /**
     * Retrieves the given currency rate from the DB
     *
     * @return void
     */
    private function _getRates(array $currencies = array())
    {
        $dao = new Dao();
        return $dao->get($currencies);
    }
}
