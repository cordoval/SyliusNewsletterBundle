SyliusNewsletterBundle documentation.
=====================================

Bundle that provides newsletter feature to your applications.

**Note!** This documentation is inspired by [FOSUserBundle docs](https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Resources/doc/index.md).

Installation.
-------------

+ Installing dependencies.
+ Downloading the bundle.
+ Autoloader configuration.
+ Adding bundle to kernel.
+ Creating your Newsletter class.
+ DIC configuration.
+ Importing routing cfgs.
+ Updating database schema.

### Installing dependencies.

This bundle uses Pagerfanta library and PagerfantaBundle.
The installation guide can be found [here](https://github.com/whiteoctober/WhiteOctoberPagerfantaBundle).

### Downloading the bundle.

The good practice is to download the bundle to the `vendor/bundles/Sylius/Bundle/NewsletterBundle` directory.

This can be done in several ways, depending on your preference. The first
method is the standard Symfony2 method.

**Using the vendors script.**

Add the following lines in your `deps` file...

```
[SyliusNewsletterBundle]
    git=git://github.com/Sylius/NewsletterBundle.git
    target=bundles/Sylius/Bundle/NewsletterBundle
```

Now, run the vendors script to download the bundle.

``` bash
$ php bin/vendors install
```

**Using submodules.**

If you prefer instead to use git submodules, the run the following:

``` bash
$ git submodule add git://github.com/Sylius/NewsletterBundle.git vendor/bundles/Sylius/Bundle/NewsletterBundle
$ git submodule update --init
```

### Autoloader configuration.

Add the `Sylius\Bundle` namespace to your autoloader.

``` php
<?php
// app/autoload.php

$loader->registerNamespaces(array(
    // ...
    'Sylius\\Bundle' => __DIR__.'/../vendor/bundles',
));
```

### Adding bundle to kernel.

Finally, enable the bundle in the kernel.

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Sylius\Bundle\NewsletterBundle\SyliusNewsletterBundle(),
    );
}
```
### Creating your Newsletter class or using the default one.

``under construction...``.

``` php
<?php
// src/Application/Bundle/NewsletterBundle/Entity/Newsletter.php

namespace Application\Bundle\NewsletterBundle\Entity;

use Sylius\Bundle\NewsletterBundle\Entity\Newsletter as BaseNewsletter;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_newsletter_newsletter")
 */
class Newsletter extends BaseNewsletter
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}
```

### Creating your Subscriber class or using the default one.

``under construction...``.

### Container configuration.

Now you have to do the minimal configuration, no worries, it is not painful.

Open up your `config.yml` file and add this...

``` yaml
sylius_newsletter:
    driver: ORM
    classes:
        model:
            newsletter: Application\Bundle\NewsletterBundle\Entity\Newsletter
            subscriber: Application\Bundle\NewsletterBundle\Entity\Subscriber
```

`Please note, that the "ORM" is currently the only supported driver.`

### Import routing files.

Now is the time to import routing files. Open up your `routing.yml` file. Customize the prefixes or whatever you want.

``` yaml
sylius_newsletter_subscriber:
    resource: "@SyliusNewsletterBundle/Resources/config/routing/frontend/subscriber.yml"

sylius_newsletter_backend_newsletter:
    resource: "@SyliusNewsletterBundle/Resources/config/routing/backend/newsletter.yml"
    prefix: /administration/newsletters

sylius_newsletter_backend_subscriber:
    resource: "@SyliusNewsletterBundle/Resources/config/routing/backend/subscriber.yml"
    prefix: /administration/newsletters
```

### Updating database schema.

The last thing you need to do is updating the database schema.

For "ORM" driver run the following command.

``` bash
$ php app/console doctrine:schema:update --force
```

### Finish.

``under construction...``.
