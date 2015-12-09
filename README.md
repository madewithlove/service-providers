# Madewithlove Definitions

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This repository contains several `definition-interop` compatible definitions for various popular packages.

## Install

Via Composer

``` bash
$ composer require madewithlove/definitions
```

## Usage

### Standalone

The definitions in this package leverage Assembly's [DefinitionResolver](https://github.com/mnapoli/assembly/blob/master/src/Container/DefinitionResolver.php) to self-resolve.
This allows them to be used standalone without a `definition-interop` compatible container or anything:

```php
$provider = new Madewithlove\Definitions\Definitions\CommandBus\TacticianDefinition();
$commandBus = $provider->resolve(League\Tactician\CommandBus::class);

$commandBus->handle(new SomeCommand());
```

### With a definition-interop container

For definitions without configuration, just create a new instance of the definition and add it to any `definition-interop` compatible project:

``` php
$provider = new LeagueRouteDefinition();

// Add to a definition-interop project
$container = new Assembly\Container\Container([], [
    $provider,
]);

// Works
$container->get(RouteCollection::class);
```

For definitions with configuration, simply pass it as constructor argument. See the definition's signature for what options they take:

```php
$provider = new EloquentDefinition([
    'local' => [
        'driver' => 'sqlite',
        'etc' => 'etc,
    ],
    'production' => [
        'driver' => 'mysql',
        'etc' => 'etc,
    ],
]);
```

### Container aware definitions

Some definitions implement `ContainerAwareInterface` _facultatively_ per example if you'd like Relay to be able to resolve middlewares from a container, etc.
To make them fully capable, simply call `setContainer` on them:

```php
$definition = new RelayDefinition([Middleware::class, 'some-middleware']);
$definition->setContainer($container);
```

### Available definitions

```
├── AbstractDefinitionProvider.php
├── Caching
│   └── IlluminateCacheDefinition.php
├── CommandBus
│   └── TacticianDefinition.php
├── Console
│   └── SymfonyConsoleDefinition.php
├── Database
│   └── EloquentDefinition.php
├── Development
│   ├── DebugbarDefinition.php
│   └── MonologDefinition.php
├── Filesystem
│   └── FlysystemDefinition.php
├── Http
│   ├── LeagueRouteDefinition.php
│   ├── RelayDefinition.php
│   └── ZendDiactorosDefinition.php
├── Templating
│   └── TwigDefinition.php
└── ValuesDefinition.php
```

See the constructor arguments of each for the options they take. Contributions welcome!

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email heroes@madewithlove.be instead of using the issue tracker.

## Credits

- [Anahkiasen][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/madewithlove/definitions.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/madewithlove/definitions/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/madewithlove/definitions.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/madewithlove/definitions.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/madewithlove/definitions.svg?style=flat-square
[link-packagist]: https://packagist.org/packages/madewithlove/definitions
[link-travis]: https://travis-ci.org/madewithlove/definitions
[link-scrutinizer]: https://scrutinizer-ci.com/g/madewithlove/definitions/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/madewithlove/definitions
[link-downloads]: https://packagist.org/packages/madewithlove/definitions
[link-author]: https://github.com/Anahkiasen
[link-contributors]: ../../contributors
