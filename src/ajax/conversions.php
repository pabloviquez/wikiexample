<?php
/**
 * Developer interview task (Mobile)
 *
 * This script receives 2 parameters by GET
 *
 * currency : This is the currency code selected in the dropdown.
 * data     : Values to convert to the "currency" selected, in the format:
 *            USD 10:USD 25:USD 50:USD 100  => Example
 *
 * The page will take those parameters and convert them into the appropiate
 * currency. IF the format is not correct OR the currency is not supported
 * then the response will be blank.
 *
 * The response will be a JSON document as follow, example:
 * Input:
 * $_GET['currency'] == 'CZK'
 * $_GET['data'] == 'USD 10:USD 25:USD 50:USD 100';
 *
 * Response:
 * ["CZK 192.68","CZK 481.70","CZK 963.40","CZK 1926.78"]
 *
 *
 * @file
 * @ingroup CodeExercise
 *
 * @author Pablo Viquez <pviquez@pabloviquez.com>
 */

/**
 * Namespaces declarations and requires
 */
use \Lib\Rates\CurrencyConverter;
require_once '../../lib/Config.php';

// Lets grab the parameters
$currency = ( isset( $_GET['currency'] ) && $_GET['currency'] ) ? strtoupper( $_GET['currency'] ) : null;
$data = ( isset( $_GET['data'] ) && $_GET['data'] ) ? $_GET['data'] : null;

// Lets output the header
header('Content-type: application/json');

// Lets validate in the parameters
if ( strlen( $currency ) !== 3 ) {
    exit;
}

$currencies = explode( ':', $data );
if ( !is_array( $currencies ) || empty( $currencies ) ) {
    exit;
}

// Get all the supported currencies and make sure the requested currency
// is supported
$supportedCurrencies = CurrencyConverter::getSupportedCurrencies();
if ( !in_array( $currency, $supportedCurrencies) && $currency !== 'USD' ) {
    exit;
}

// Now lets do the conversion and respond
$results = CurrencyConverter::convert( $currency, $currencies );
echo json_encode( $results );

