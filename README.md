Sylius
======

Simple but **end-user and developer friendly** webshop engine built on top of Symfony2.

This is sandbox application that shows some examples of the Sylius bundles usage.  
It's also testing ground for new features planned for [main Sylius application](http://github.com/Sylius/Sylius).

Live demo
---------

[Click here](http://sylius.org/sandbox) to view a demo of this application.

The inferface is powered by the coolest [Twitter Bootstrap 2](http://twitter.github.com/bootstrap).

Quick installation
------------------

Clone this repository with this command.

``` bash
$ git clone http://github.com/Sylius/Sylius-Sandbox.git
```

Open `sandbox/config/container/parameters.yml.dist`, set your values and save as `parameters.yml`.

Install dependencies using composer.

``` bash
$ wget http://getcomposer.org/composer.phar
$ php composer.phar install
```

Create database schema and dump assetic assets by typing this commands inside console.

``` bash
$ ./bin/rebuild-database
$ php sandbox/console assetic:dump
```

Open up ``/path/to/Sylius-Sandbox/public/dev.php`` in your browser and play with the application.


Testing and build status
------------------------

This application uses [travis-ci.org](http://travis-ci.org/Sylius/SyliusAssortmentBundle) for CI.

You can run the tests by simply using this command, only if you installed vendors.

``` bash
$ phpunit -c sylius-sandbox
```

Contributing
------------

All informations about contributing to Sylius can be found on [this page](http://sylius.readthedocs.org/en/latest/contributing/index.html).

Mailing lists
-------------

### Users.

If you are using this application and have any questions, feel free to ask on users mailing list.
[Mail](mailto:sylius@googlegroups.com) or [view it](http://groups.google.com/group/sylius).

### Developers.

If you want to contribute, and develop this application, use the developers mailing list.
[Mail](mailto:sylius-dev@googlegroups.com) or [view it](http://groups.google.com/group/sylius-dev).

Sylius twitter account
----------------------

If you want to keep up with updates, [follow the official Sylius account on twitter](http://twitter.com/_Sylius)
or [follow me](http://twitter.com/pjedrzejewski).

Bug tracking
------------

This application uses [GitHub issues](https://github.com/Sylius/Sylius-Sandbox/issues).
If you have found bug, please create an issue.

Versioning
----------

Releases will be numbered with the format `major.minor.patch`.

And constructed with the following guidelines.

* Breaking backwards compatibility bumps the major.
* New additions without breaking backwards compatibility bumps the minor.
* Bug fixes and misc changes bump the patch.

For more information on SemVer, please visit [semver.org website](http://semver.org/).

This versioning method is same for all **Sylius** bundles and applications.

License
-------

License can be found [here](https://github.com/Sylius/Sylius-Sandbox/blob/master/LICENSE).

Authors
-------

The application was originally created by [Paweł Jędrzejewski](http://pjedrzejewski.com).
See the list of [contributors](https://github.com/Sylius/Sylius-Sandbox/contributors).
