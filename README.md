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

For definitions without configuration, just create a new instance of the definition and add it to any `definition-interop` compatible project:

``` php
$provider = new LeagueRouteDefinition();

// Add to a definition-interop project
$container->addDefinitionProvider($provider);

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

Available definitions:

```
src
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
