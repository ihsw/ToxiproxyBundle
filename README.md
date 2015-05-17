Toxiproxy Bundle
===

[![Build status](https://travis-ci.org/ihsw/ToxiproxyBundle.svg?branch=master)](https://travis-ci.org/ihsw/ToxiproxyBundle.svg?branch=master)

[Toxiproxy](https://github.com/shopify/toxiproxy) makes it easy and trivial to test network conditions, for example low-bandwidth and high-latency situations. `ToxiproxyBundle` includes everything needed to get started with configuring Toxiproxy upstream connection and listen endpoints.

Installing via Composer
---

The recommended way to install `ToxiproxyBundle` is through [Composer](http://getcomposer.org/).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version of `ToxiproxyBundle`:

```bash
composer.phar require ihsw/ToxiproxyBundle
````

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

Documentation
---

More information can be found in the `examples` directory for expected usage.