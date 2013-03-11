<?php
/**
 * Developer interview task (Mobile)
 *
 * This web script will connect to the 3rd party system, retrieve the data
 * parse it and update the database with the info.
 *
 * This does the exact same thing as the batch, however its visible to the world.
 *
 * @author Pablo Viquez <pviquez@pabloviquez.com>
 */

// Namespaces declarations
use \Lib\Config,
    \Lib\Rates\Batch;

/**
 * Config handler, will take care of autoloading and all configs
 */
require_once '../../lib/Config.php';

// Lets now run the batch
$ratesBatch = new Batch();
$ratesBatch->run();

echo "Completed!";
