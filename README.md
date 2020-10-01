Doctrine ORM process bundle
===========================

[![Build Status](https://travis-ci.org/Ang3/doctrine-orm-process-bundle.svg?branch=master)](https://travis-ci.org/Ang3/doctrine-orm-process-bundle) 
[![Latest Stable Version](https://poser.pugx.org/ang3/doctrine-orm-process-bundle/v/stable)](https://packagist.org/packages/ang3/doctrine-orm-process-bundle) 
[![Latest Unstable Version](https://poser.pugx.org/ang3/doctrine-orm-process-bundle/v/unstable)](https://packagist.org/packages/ang3/doctrine-orm-process-bundle) 
[![Total Downloads](https://poser.pugx.org/ang3/doctrine-orm-process-bundle/downloads)](https://packagist.org/packages/ang3/doctrine-orm-process-bundle)

This bundles provides utils for Doctrine ORM processes or bulk operations.

**Integrated packages**
- [ang3/php-doctrine-orm-batch-processor](https://github.com/Ang3/php-doctrine-orm-batch-processor)

Summary
=======

- [Installation](#installation)
- [Usage](#usage)
    - [Batch processor](#batch-processor)
    - [Entity locker](#entity-locker)

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require ang3/doctrine-orm-process-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Usage
=====

Batch processor
---------------

The bundle configures a batch processor service by entity manager automatically from your configuration. 
You can get it by dependency injection with autowiring:

```php
use Ang3\Component\Doctrine\ORM\BatchProcessor;

class MyService
{
    private $batchProcessor;

    public function __construct(BatchProcessor $batchProcessor)
    {
        $this->batchProcessor = $batchProcessor;
    }
}
```

If the manager name is ```default```, then the autowired argument is 
```Ang3\Component\Doctrine\ORM\BatchProcessor $defaultBatchProcessor```. By default, the batch processor 
of the ```default``` manager is passed by type-hinting.

- Run the command ```php bin/console debug:autowiring BatchProcessor``` to get the list of autowired processors.

If you don't use autowiring to get the batch processor for another manager than ```default```, 
then you must pass the service as argument of your service following the naming convention:

```yaml
# app/config/services.yml or config/services.yaml
# ...
MyClass:
    arguments:
        $batchProcessor: '@ang3_doctrine_orm_process.batch_processor.my_manager'
```

Please see the documentation of 
[ang3/php-doctrine-orm-batch-processor](https://github.com/Ang3/php-doctrine-orm-batch-processor) 
for informations about usage of a processor.

Entity locker
-------------

...

That's it!