<?php
/**
 * Developer interview task (Mobile)
 *
 * @author Pablo Viquez <pviquez@pabloviquez.com>
 */

use \Lib\Rates\CurrencyConverter;

/**
 * Require the configuration and loader of the PHP
 */
require_once '../lib/Config.php';

// Retrieve all the supported currencies
$currencies = CurrencyConverter::getSupportedCurrencies();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pablo Viquez :: Code Exercise</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/global.css" rel="stylesheet" media="screen">
</head>
<body>
    <div class="container">
        <h1>Developer interview task (Mobile)</h1>
        <p class="lead">Code Exercice by Pablo Víquez</p>

        <div class="well">
            <p>Let's say that for our annual fundraiser we want to use currency
            conversion rates that are periodically updated automatically rather
            than having to constantly update them by hand. In order to do this, we
            sign up for a 3rd party service that provides us with daily conversion
            rates for the currencies that we support. The service is a simple API
            that outputs XML when called with the URL
            <a href="http://toolserver.org/~kaldari/rates.xml">http://toolserver.org/~kaldari/rates.xml</a>.</p>
        </div>

        <h2>Donations</h2>
        <div id="donations">
            <button class="btn">USD 10</button>
            <button class="btn">USD 25</button>
            <button class="btn">USD 50</button>
            <button class="btn">USD 100</button>
        </div>

        <p>&nbsp;</p>

        <form>
            <fieldset>
                <legend>Change the currency</legend>
                <select id="currencySelector">
                    <option value="USD">USD</option>

                    <?php /*foreach ($currencies as $currency ) : ?>
                    <option><?php echo $currency; ?></option>
                    <?php endforeach; */?>
                </select>
            </fieldset>
        </form>

        <p>&nbsp;</p>

    </div>
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/donations.js"></script>
</body>
</html>
