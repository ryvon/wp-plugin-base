<?php

namespace Ryvon\Plugin;

use Brain\Monkey;
use Brain\Monkey\Functions;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class BaseHandlerTest extends TestCase
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        Monkey\setUp();
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        Monkey\tearDown();
    }

    /**
     * @param array $arguments
     * @return MockObject|BasePlugin
     * @throws \ReflectionException
     */
    private function getBasePluginMock($arguments = ['/var/www/html/wp-content/plugins/plugin-name/plugin-name.php'])
    {
        return $this->getMockForAbstractClass(BasePlugin::class, $arguments);
    }

    /**
     * @param PluginInterface $plugin
     * @param array $mockedMethods
     * @return MockObject|BaseHandler
     * @throws \ReflectionException
     */
    private function getBaseHandlerMock(PluginInterface $plugin, array $mockedMethods = [])
    {
        return $this->getMockForAbstractClass(
            BaseHandler::class,
            [$plugin],
            '',
            true,
            true,
            true,
            $mockedMethods
        );
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    public function testGetPlugin(): void
    {
        $plugin = $this->getBasePluginMock();
        $handler = $this->getBaseHandlerMock($plugin);

        $this->assertEquals($plugin, $handler->getPlugin());
    }

    /**
     * @throws \ReflectionException
     */
    public function testAddFilter(): void
    {
        $plugin = $this->getBasePluginMock();
        $handler = $this->getBaseHandlerMock($plugin);

        $filterArgs = ['test_filter', 'function', 10, 1];

        Functions\expect('add_filter')->times(1)->andReturnUsing(
            function ($tag, $function, $priority, $acceptedArgs) use ($filterArgs) {
                $this->assertEquals($filterArgs, [$tag, $function, $priority, $acceptedArgs]);
            }
        );

        $reflection = new \ReflectionClass($handler);

        $addFilter = $reflection->getMethod('addFilter');
        $addFilter->setAccessible(true);
        $addFilter->invokeArgs($handler, $filterArgs);
    }

    /**
     * @throws \ReflectionException
     */
    public function testAddAction(): void
    {
        $plugin = $this->getBasePluginMock();
        $handler = $this->getBaseHandlerMock($plugin);

        $actionCallback = static function ($a, $b) {
        };

        $actionArgs = ['test_action', $actionCallback, 100, 2];

        Functions\expect('add_action')->times(1)->andReturnUsing(
            function ($tag, $function, $priority, $acceptedArgs) use ($actionArgs) {
                $this->assertEquals($actionArgs, [$tag, $function, $priority, $acceptedArgs]);
            }
        );

        $reflection = new \ReflectionClass($handler);

        $addAction = $reflection->getMethod('addAction');
        $addAction->setAccessible(true);
        $addAction->invokeArgs($handler, $actionArgs);
    }

    /**
     * @throws \ReflectionException
     */
    public function testAddShortcode(): void
    {
        $plugin = $this->getBasePluginMock();
        $handler = $this->getBaseHandlerMock($plugin, ['shortcode_function']);

        $handler->expects($this->never())->method('shortcode_function');

        $shortcodeArgs = ['test_shortcode', 'shortcode_function'];

        Functions\expect('add_shortcode')->times(1)->andReturnUsing(
            function ($tag, $function) use ($handler, $shortcodeArgs) {
                $this->assertEquals([$shortcodeArgs[0], [$handler, $shortcodeArgs[1]]], [$tag, $function]);
            }
        );

        $reflection = new \ReflectionClass($handler);

        $addShortcode = $reflection->getMethod('addShortcode');
        $addShortcode->setAccessible(true);
        $addShortcode->invokeArgs($handler, $shortcodeArgs);
    }
}
