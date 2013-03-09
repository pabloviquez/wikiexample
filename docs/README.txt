Developer interview task (Mobile)
--------------------------------------------------------------------------------
Author: Pablo Viquez <pviquez@pabloviquez.com>

Global App Notes
--------------------------------------------------------------------------------
The public directory resides in the "src" directory. All other files should be
outside the public eye hoewever stil accesible to the web server user.


JS App Notes
--------------------------------------------------------------------------------



PHP App Notes
--------------------------------------------------------------------------------
The main idea was to design something that can handle requirements growth, using
classes with high cohesion and low coupling.

Design Aspects:

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

