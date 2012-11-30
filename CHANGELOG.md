CHANGELOG
=========

### 30-11-2012

* Renamed **SandboxCoreBundle** to **SyliusSandboxBundle**. This change also introduces different namespaces.
  Now it is ``Sylius\Bundle\SandboxBundle`` instead of ``Sylius\Sandbox\Bundle\CoreBundle``.
* Use CDNs to load js and css assets. Removed Twitter Bootstrap from composer.json.

### 01-11-2012

* Removed cart bundle. It was moved inside core bundle.
  Now the app uses redesigned [**SyliusCartBundle**](http://github.com/Sylius/SyliusCartBundle).
