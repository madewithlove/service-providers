# Madewithlove Service Providers

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

A repository of universal service providers for [service-providers] compliant containers

## Install

Via Composer

``` bash
$ composer require madewithlove/service-providers
```

This repository **does not** ship with any third party package, you will need to install them yourself. If per example you need the `FlysystemServiceProvider` you would install Flysystem alongside this package.

## Usage

### Service providers

If the container you're using is already compatible with [service-provider] then register it like you simply would normally.

Otherwise you can use a decorator or bridge, you can find some on Packagist, and this package ships with some as well, per example for [league/container]:
 
```php
use League\Flysystem\FilesystemInterface;
use League\League\Container;
use Madewithlove\ServiceProviders\Bridges\LeagueContainerDecorator;
use Madewithlove\ServiceProviders\Filesystem\FlysystemServiceProvider;

$container = new Container();
$container->addServiceProvider(
    new LeagueContainerDecorator(new FlysystemServiceProvider(...))
);

$filesystem = $container->get(FilesystemInterface::class);
```

For providers with configuration, you can pass it as constructor argument. See the provider's signature for what options they take:

```php
$provider = new EloquentServiceProvider([
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

### Utilities

This package also ships with some utilities to write your own service providers:

**Alias**: An alias to an existing value in the container:

```php
public function getServices()
{
    return ['my_alias' => new Alias('to_something_else')];
}
```

**Parameter**: A plain value to store in the container:

```php
public function getServices()
{
    return ['views_path' => new Parameter(__DIR__.'/views)];
}
```

**ParametersServiceProvider**: A blank service provider to quickly set multiple values in the container:

```php
new ParametersServiceProvider([
    'foo' => 'bar',
    'bar' => 'baz',
]);

$container->get('foo'); // (string) "bar"
```

**PrefixedProvider**: A decorator to prefix a provider's services with a given string:

```php
new PrefixedProvider('config', new ParametersServiceProvider([
    'foo' => 'bar',
]));

$container->get('config.foo'); // (string) "bar"
```

## Available service providers

```
├── Bridges
│   └── LeagueContainerDecorator.php
├── CommandBus
│   └── TacticianServiceProvider.php
├── Console
│   └── SymfonyConsoleServiceProvider.php
├── Database
│   ├── EloquentServiceProvider.php
│   └── FactoryMuffinServiceProvider.php
├── Development
│   ├── DebugbarServiceProvider.php
│   └── MonologServiceProvider.php
├── Events
│   └── LeagueEventsServiceProvider.php
├── Filesystem
│   └── FlysystemServiceProvider.php
├── Http
│   ├── LeagueRouteServiceProvider.php
│   ├── RelayServiceProvider.php
│   └── ZendDiactorosServiceProvider.php
├── Templating
│   └── TwigServiceProvider.php
└── Utilities
    ├── Alias.php
    ├── Parameter.php
    ├── ParametersServiceProvider.php
    └── PrefixedProvider.php
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

[ico-code-quality]: https://img.shields.io/scrutinizer/g/madewithlove/service-providers.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/madewithlove/service-providers.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/madewithlove/service-providers.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/madewithlove/service-providers/master.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/madewithlove/service-providers.svg?style=flat-square
[league/container]: http://container.thephpleague.com/
[link-author]: https://github.com/Anahkiasen
[link-code-quality]: https://scrutinizer-ci.com/g/madewithlove/service-providers
[link-contributors]: ../../contributors
[link-downloads]: https://packagist.org/packages/madewithlove/service-providers
[link-packagist]: https://packagist.org/packages/madewithlove/service-providers
[link-scrutinizer]: https://scrutinizer-ci.com/g/madewithlove/service-providers/code-structure
[link-travis]: https://travis-ci.org/madewithlove/service-providers
[service-provider]: https://github.com/container-interop/service-provider
