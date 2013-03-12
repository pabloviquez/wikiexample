WIKI Example :: Wikipedia Code Exercise
================================================================================
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

<pre>
/-
 /batch     -> Batch script. This is where batch scripts are
 /config    -> App configuration. This should be the only place to edit configs
               This directory should not be public, however if by any chance its
               public, an .htaccess file is also included which prevents serving
               the file. If the configuration does not allow .htaccess file, then
               it's important to manually change the web server config to deny any
               request to ".ini" files inside this directory or the app for that matters.
 /docs      -> Any relevant documentation
 /lib       -> PHP library for the app
 /sql       -> SQL Scripts for the DB creation
 /src       -> Public html directory

</pre>



1. PHP App Notes
--------------------------------------------------------------------------------
The main idea was to design something that can handle requirements growth, using
classes with high cohesion and low coupling.

1.1 How to configure the app
--------------------------------------------------------------------------------
The design can be divided in 2 main areas, the batch or command line and the web
interface.

Both areas are setup with the same configuration file, which is located in the
"config/config.ini" file.

This should be the only place to edit configurations.


1.2. How to run the batch
--------------------------------------------------------------------------------

        php batch/rates.php


If by any chance, there's no access to the console, anoter script was created in
the front end which does the exact same thing, however in the public site.

To call it make a request to:

        http://[localhost || whateverdomain || path ]/process/process.php


1.3. Design Aspects:
--------------------------------------------------------------------------------

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

5. Caching system. The DB results should be cached. The implementation of a caching
   server; like Memcached or Redis, is critical for optimal performance.



2. Client Side App Notes
--------------------------------------------------------------------------------

2.1. Design Aspects:
--------------------------------------------------------------------------------
The page uses a responsive design, implementing Twitter Bootstrap for faster and
more efficient coding.



2.1. What could be improved?
--------------------------------------------------------------------------------
1. Progressive Enhancement with JavaScript. While smartphones are known to support
   JavaScript, since this is a donations page, it should support browser with
   no JavaScript. Right now, if the user does not have JavaScript enabled,
   it wont be able to switch currencies.

2. Unit test. As part of the quality control best practices, unit testing for the
   JS is a good idea.

3. The twitter bootstrap CSS file contains a lot of classes that are not being
   used, for better performance, removing them is a good idea or just download
   the necessary ones.

4. Even though the requirements didn't state the requirement, I was unable to
   to a test on Windows Phone or IE. As a thing to improve, I definitely will
   recommend to do a test for IE compatibility.



