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
uses \Lib\Rates\Dao;

/**
 * Currency converter class, responsible of the money conversion
 */
class CurrencyConverter
{
    /**
     * Parses the currency and amount given and returns an array with the respective
     * dollar conversion
     *
     * @param array $values
     * @return array
     */
    public function getDollars(array $values)
    {

    }

    /**
     * Retrieves all the currency codes stored in the DB
     *
     * @return array
     */
    public function getCurrencies()
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
