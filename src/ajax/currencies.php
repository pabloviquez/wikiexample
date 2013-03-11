<?php
/**
 * Developer interview task (Mobile)
 *
 * @file
 * @ingroup CodeExercise
 *
 * @author Pablo Viquez <pviquez@pabloviquez.com>
 */

use \Lib\Rates\CurrencyConverter;

require_once '../../lib/Config.php';

$currencies = CurrencyConverter::getSupportedCurrencies();

echo json_encode($currencies);
