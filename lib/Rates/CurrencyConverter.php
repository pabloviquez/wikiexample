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
     * Retrieves
     * Enter description here ...
     *
     */
    public function getDollars($currency, $amount)
    {

    }

    /**
     * Retrieves the given currency rate from the DB
     *
     * @return void
     */
    private function _getRates($currency)
    {
        $dao = new Dao();
        return $dao->get($currency);
    }
}
