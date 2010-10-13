Importer
================================

Introduction
------------
Importer provides a simple import mechanism for FLOW3. With Importer, you can import any database table into FLOW3's persistence.

How to use
----------

* Place the Importer folder into your FLOW3 distribution and activate the package. 
* Call `your-virtual-host/importer`, assuming `your-virtual-host` points to the `Web` directory of FLOW3. 
* Follow the instructions

To see the basic functionality, Importer comes with a `Demo` model with just one property `title`. You can use Importer to import some data from one of your database tables into the `Demo` repository and view the results at `your-virtual-host/importer/demo`.

Disclaimer
----------

* This is only a prototype. Use at your own risk.
* Currently only MySQL is supported, though it might work with other SQL databases as well.