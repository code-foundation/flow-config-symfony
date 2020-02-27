# Status

[![Latest Stable Version](https://poser.pugx.org/code-foundation/flow-config-symfony/v/stable)](https://packagist.org/packages/code-foundation/flow-config-symfony) [![License](https://poser.pugx.org/code-foundation/flow-config-symfony/license)](https://packagist.org/packages/code-foundation/flow-config-symfony) [![codecov](https://codecov.io/gh/code-foundation/flow-config-symfony/branch/master/graph/badge.svg)](https://codecov.io/gh/code-foundation/flow-config-symfony) [![CircleCI](https://circleci.com/gh/code-foundation/flow-config-symfony.svg?style=svg)](https://circleci.com/gh/code-foundation/flow-config-symfony)

# Introduction

Flow Config is a key value configuration platform built on top of doctrine. It provides an PHP API for setting configuration
 at the platform that can be set by an install, and then set for a user, or other entity. Defaults are set in a single
 location, rather than scattering them through the code.

This package provides a Symfony 4 bundle for installing flow-config.

See https://github.com/code-foundation/flow-config

# Installation

```php
composer require code-foundation/flow-config-symfony
```

Add this bundle to your `bundles.php`

```
// app/config/bundles.php
<?php

return [
    CodeFoundation\FlowConfigBundle\FlowConfigBundle::class => ['all' => true],
];
```

Add a default yaml configuration file for your configuration defaults in `flow_config.yaml`

Note that the keys are evaluated as strings, the dot separation and prefixes of 'user' and 'system' are convention only,
 and do not have special meaning to flow config.

```
// app/config/packages/flow_config.yaml
flow_config:
  defaults:
    user.email.format: html
    user.timezone: UTC
    system.adminuser: admin
```

The bundle preconfigures the following services. In almost all cases, you want to use `flowconfig.cascade`

| Alias              | interface | class
| ---                | ---       | ---
| `flowconfig.cascade` | `CompositeConfigRepositoryInterface` | `CodeFoundation\FlowConfig\Repository\CascadeConfig`
| `flowconfig.entity` | `EntityConfigRepositoryInterface` | `CodeFoundation\FlowConfig\Repository\DoctrineEntityConfig`
| `flowconfig.system` | `ConfigRepositoryInterface` | `CodeFoundation\FlowConfig\Repository\DoctrineConfig`
| `flowconfig.ro` | `ReadonlyConfigRepositoryInterface` | `CodeFoundation\FlowConfig\Repository\ReadonlyConfig`

Entities passed to `setByEntity()` and `getByEntity()` must implement `CodeFoundation\FlowConfig\InterfacesEntityIdentifier`.

# Supported platforms
* PHP 7.3+
* Symfony 4.x
* Doctrine 2.x

# Contact

Github: https://github.com/code-foundation/flow-config-symfony

Email: contact@codefoundation.com.au

# License
Flow Config and the Symfony bundle is distributed under the MIT license.
