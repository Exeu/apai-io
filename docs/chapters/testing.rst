Testing
=======

PHPUnit
-------

When you download ApaiIO it comes with some unittests. If you plan to run these tests you can do it simply by running phpunit in the project root dir.

$ cd /path/to/lib
$ phpunit
Please see http://phpunit.de/manual/current/en/index.html for more information about PHPUnit.

The tests are located in the folder: tests/. Feel free to have a look at them.

Environment variables
_____________________

If you want to run all tests you need to set up some environment variables. These variables are nescessary to make request to the amazon api.

.. code-block:: bash

    $ export APAI_IO_SECRETKEY=YOUR SECRET KEY
    $ export APAI_IO_ACCESSKEY=YOUR ACCESS KEY

If these variables are correct, all tests will run instead of skipping some tests.