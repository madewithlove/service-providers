<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\ServiceProviders\Templating;

use Interop\Container\ServiceProviderInterface;
use Madewithlove\ServiceProviders\Utilities\Alias;
use Psr\Container\ContainerInterface;
use Twig_Environment;
use Twig_Extension;
use Twig_Loader_Array;
use Twig_Loader_Filesystem;
use Twig_LoaderInterface;

class TwigServiceProvider implements ServiceProviderInterface
{
    /**
     * Path to the views or a list of views.
     *
     * @var string|string[]
     */
    protected $views;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var Twig_Extension[]
     */
    protected $extensions = [];

    /**
     * @param string|string[]  $views
     * @param array            $options
     * @param Twig_Extension[] $extensions
     */
    public function __construct($views = [], array $options = [], array $extensions = [])
    {
        $this->views = $views;
        $this->options = $options;
        $this->extensions = $extensions;
    }

    /**
     * {@inheritdoc}
     */
    public function getServices()
    {
        return [
            Twig_LoaderInterface::class => [$this, 'getLoader'],
            Twig_Environment::class => [$this, 'getEnvironment'],
            'twig' => new Alias(Twig_Environment::class),
        ];
    }

    /**
     * @return Twig_LoaderInterface
     */
    public function getLoader()
    {
        $isViewsFolder = is_string($this->views) && is_dir($this->views);
        $loader = $isViewsFolder ? Twig_Loader_Filesystem::class : Twig_Loader_Array::class;

        return new $loader($this->views ?: []);
    }

    /**
     * @param ContainerInterface $container
     *
     * @return Twig_Environment
     */
    public function getEnvironment(ContainerInterface $container)
    {
        $twig = new Twig_Environment($container->get(Twig_LoaderInterface::class), $this->options);
        foreach ($this->extensions as $extension) {
            $twig->addExtension(is_string($extension) ? $container->get($extension) : $extension);
        }

        return $twig;
    }
}
