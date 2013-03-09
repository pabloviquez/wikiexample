<?php
/**
 * Developer interview task (Mobile)
 *
 * This batch script will connect to the 3rd party system, retrieve the data
 * parse it and update the database with the info
 *
 * How to execute it:
 *
 * php rates.php
 *
 * @author Pablo Viquez <pviquez@pabloviquez.com>
 */

// Namespaces declarations
use \Lib\Batch;

/**
 * Batch handler, will take care of autoloading and all configs
 */
require_once '../lib/Batch.php';

$b = new Batch();

