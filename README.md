WIKI Example :: Wikipedia Code Exercise
--------------------------------------------------------------------------------
Developer interview task (Mobile)
Author: Pablo Viquez <pviquez@pabloviquez.com>


Global App Notes
--------------------------------------------------------------------------------
The public directory resides in the "src" directory. All other files should be
outside the public eye hoewever stil accesible to the web server user.


Minimum Requirements
--------------------------------------------------------------------------------
 + PHP 5.3 or greater
 ++ PHP Modules:
   - PDO
   - SimpleXML

 + MySQL 5.x


Directory Structure
--------------------------------------------------------------------------------
The app has the following structure:

/-
 /batch     -> Batch script. This is where batch scripts are
 /config    -> App configuration. This should be the only place to edit configs
 /docs      -> Any relevant documentation
 /lib       -> PHP library for the app
 /sql       -> SQL Scripts for the DB creation
 /src       -> Public html directory



PHP App Notes
--------------------------------------------------------------------------------
The main idea was to design something that can handle requirements growth, using
classes with high cohesion and low coupling.

How to configure the app
************************
The design can be divided in 2 main areas, the batch or command line and the web
interface.

Both areas are setup with the same configuration file, which is located in the
"config/config.ini" file.

This should be the only place to edit configurations.


How to run the batch
********************

        php batch/rates.php


Design Aspects:
***************

The main idea behind this approach was that the comsuption of a 3rd party service
of exchange rates does not required to be executed constantly or on real time.

Thats why an asynchronous process (Batch file) was created. This file could be
called from a cronjob or task schedule or from the web once per day.

All classes lives inside the "lib" directory. This lib directory is suppoused to
be outside the live app, the same goes for the config.ini file.

All app configurations, should be outside the public directory.


There are some issues that could be improved:
1. Dao Class: This class should not be responsible for the DB
   connection instantiation. The DB instantiation should be
   moved out of the DAO into a new base class that can be called
   from any other class. Ideally the DB class should implement the
   singleton pattern in order to avoid unnecessary DB connections.

2. Batch Process: The process creates a simple batch process, however this could
   be improved by adding a more roubust process control to detect and log failures
   and to not run if another one is currently running.

3. Locale aware: This application could benefit from a locale aware setup, that's
   presenting the currencies according to the user browser locale, for a more
   I18N friendly app

4. Unit test: Unit test are extremely important, this because they could easily
   test the internal classes just like the Batch processing.



JS App Notes
--------------------------------------------------------------------------------
