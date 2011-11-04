Sylius.
=======

Simple but **end-user and developer friendly** webshop engine built on top of Symfony2.

This is sandbox application that shows some examples of the Sylius bundles usage.

Quick installation.
-------------

Clone this repository with this command.

``` bash
$ git clone http://github.com/Sylius/Sylius-Sandbox path/to/Sylius-Sandbox
```

Open `app/config/container/includes/parameters.yml.dist`, set your values and save as `parameters.yml`.
Run the vendors script.

``` bash
$ php ./tools/vendors install
```

Generate database schema.

``` bash
$ php app/tools/console doctrine:schema:create
```

Open up ``/path/to/Sylius-Sandbox/public`` in your browser and play with the application.

Documentation.
--------------

Docs are available [here](https://github.com/Sylius/Sylius-Sandbox/blob/master/doc/index.md).

Bundles used in application.
----------------------------

* [SyliusAssortmentBundle](http://github.com/Sylius/SyliusAssortmentBundle),
* [SyliusCatalogBundle](http://github.com/Sylius/SyliusCatalogBundle),
* [SyliusNewsletterBundle](http://github.com/Sylius/SyliusNewsletterBundle),
* [SyliusCartBundle](http://github.com/Sylius/SyliusCartBundle),
* [SyliusThemingBundle](http://github.com/Sylius/SyliusThemingBundle),
* [SyliusBloggerBundle](http://github.com/Sylius/SyliusBloggerBundle),
* [SyliusSalesBundle](http://github.com/Sylius/SyliusSalesBundle),
* [WhiteOctoberPagerfantaBundle](http://github.com/whiteoctober/WhiteOctoberPagerfantaBundle),
* [LiipThemeBundle](http://github.com/liip/LiipThemeBundle).

Mailing lists.
--------------

If you are using this application and have any questions, feel free to ask on users mailing list.
[Mail](mailto:sylius@googlegroups.com) or [view it](http://groups.google.com/group/sylius).

If you want to contribute, and develop this application, use the developers mailing list.
[Mail](mailto:sylius-dev@googlegroups.com) or [view it](http://groups.google.com/group/sylius-dev).

Sylius twitter account.
-----------------------

If you want to keep up with updates, [follow the official Sylius account on twitter](http://twitter.com/_Sylius) 
or [follow me](http://twitter.com/pjedrzejewski).

Bug tracking.
-------------

This application uses [GitHub issues](https://github.com/Sylius/SyliusThemingBundle/issues).
If you have found bug, please create an issue.

Versioning.
-----------

Releases will be numbered with the format `<major>.<minor>.<patch>`.

And constructed with the following guidelines.

* Breaking backwards compatibility bumps the major.
* New additions without breaking backwards compatibility bumps the minor.
* Bug fixes and misc changes bump the patch.

For more information on SemVer, please visit [semver.org website](http://semver.org/).
This versioning method is same for all **Sylius** bundles and applications.

License.
--------

License can be found [here](https://github.com/Sylius/Sylius-Sandbox/blob/master/LICENSE).

Authors.
--------

The application was originally created by [Paweł Jędrzejewski](http://diweb.pl).
See the list of [contributors](http://github.com/Sylius/Sylius-Sandbox/contributors).
