/**
 * Developer interview task (Mobile)
 *
 * This script must be executed with a user with permissions to create/drop
 * databases, tables and also with GRANT permissions.
 *
 * @author Pablo Viquez <pviquez@pabloviquez.com>
 */

-- Drop the DB if exists
DROP DATABASE IF EXISTS `pviquez_mobile`;

-- If DB has not been created create it
CREATE DATABASE IF NOT EXISTS `pviquez_mobile`
    DEFAULT CHARSET utf8
    DEFAULT COLLATE utf8_general_ci;

-- Lets create one user to query
-- User: pviquez_user
-- Password: pviquez_user
GRANT ALL
   ON pviquez_mobile.*
   TO 'pviquez_user'@'localhost'
IDENTIFIED BY 'pviquez_user';

-- Reload the internal cache for permissions
FLUSH PRIVILEGES;

-- Lets now switch to the newly created DB
USE `pviquez_mobile`;

-- Table to store the conversion rates
CREATE TABLE `conversion_rate` (
    currency VARCHAR(3) NOT NULL,
    rate DECIMAL(20,10),
    last_updated TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (currency)
) ENGINE=InnoDB;
