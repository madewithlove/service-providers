<?php
namespace Madewithlove\Definitions\Definitions;

use Madewithlove\Definitions\Definitions\Console\SymfonyConsoleDefinition;
use Madewithlove\Definitions\TestCase;
use Symfony\Component\Console\Application;

class AbstractDefinitionProviderTest extends TestCase
{
    public function testCanSelfResolve()
    {
        $definition = new SymfonyConsoleDefinition('Foo');

        /** @var Application $console */
        $console = $definition->resolve(Application::class);

        $this->assertInstanceOf(Application::class, $console);
        $this->assertEquals('Foo', $console->getName());
    }
}
