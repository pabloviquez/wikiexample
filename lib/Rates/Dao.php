<?php
/**
 * Developer interview task (Mobile)
 *
 * @file
 * @ingroup CodeExercise
 *
 * @author Pablo Viquez <pviquez@pabloviquez.com>
 */

namespace Lib\Rates;

use \PDO,
    \Lib\Config;

/**
 * Data Access Object for the currency rates
 */
class Dao
{
    /**
     * Database instance
     *
     * @var PDO
     */
    private $_db;

    /**
     * Retrieves the specific conversion rate of all if none is specified
     *
     * @param array $currencies Optional array of currency codes to retrieve
     * @return array An array with the requested rates
     */
    public function get(array $currencies = array())
    {
        $where = null;
        $params = array();

        if (!empty($currencies)) {
            $values = array_fill(0, count($currencies), 'cr.currency = ?');
            $where = sprintf('AND (%s)', implode(' OR ', $values));
        }

        $sql = "SELECT cr.currency,
                       cr.rate
                  FROM conversion_rate cr
                 WHERE 1=1 {$where}";

        $sth = $this->_getDbInstance()->prepare($sql);
        $sth->execute($currencies);
        $data = $sth->fetchAll(PDO::FETCH_OBJ);

        $result = array();
        foreach ($data as $rate) {
            $result[$rate->currency] = $rate->rate;
        }

        return $result;
    }

    /**
     * Retrieves a list of all the supported currency codes
     *
     * @return array
     */
    public function getCodes()
    {
        $sql = "SELECT cr.currency FROM conversion_rate cr";
        $sth = $this->_getDbInstance()->prepare($sql);
        $sth->execute();
        $values = $sth->fetchAll(PDO::FETCH_ASSOC);

        // Lets flattened the data
        $codes = array();
        foreach ($values as $currency) {
            $codes[] = $currency['currency'];
        }

        return $codes;
    }

    /**
     * Stores the rates in the DB, if they exists, the data is updated
     *
     * @param array $rates Key/Value array as follow:
     *                     array(
     *                         'CURRENCY_CODE' => amount,
     *                     )
     * @return bool
     */
    public function save(array $rates)
    {
        $sql =
            "INSERT INTO conversion_rate
                        (currency,
                         rate,
                         last_updated)
                 VALUES (:p_currency,
                         :p_rate,
                         CURRENT_TIMESTAMP)
            ON DUPLICATE KEY UPDATE
                rate = :p_rate";

        $sth = $this->_getDbInstance()->prepare($sql);

        // Lets interate using the prepared statement and execute it with
        // the different values.
        foreach ($rates as $currency => $rate) {
            if (strlen($currency) !== 3 || !is_numeric($rate)) {
                // Move to the next iteration
                continue;
            }

            $sth->bindParam(':p_currency', $currency);
            $sth->bindParam(':p_rate', $rate);
            $sth->execute();
        }
    }

    /**
     * Retrieves a valid instance of the database connection
     *
     * @return PDO
     */
    protected function _getDbInstance()
    {
        if ($this->_db instanceof PDO) {
            return $this->_db;
        }

        $config = Config::getInstance()->getConfig();

        $this->_db = new PDO(
            $config['database_dsn'],
            $config['database_usr'],
            $config['database_pwd']
        );

        return $this->_db;
    }
}
