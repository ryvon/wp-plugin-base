<?php

namespace Ryvon\Plugin;

use Brain\Monkey;
use Brain\Monkey\Functions;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class BasePluginTest extends TestCase
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
     * @return MockObject|BaseHandler
     * @throws \ReflectionException
     */
    private function getBaseHandlerMock(PluginInterface $plugin)
    {
        return $this->getMockForAbstractClass(BaseHandler::class, [$plugin]);
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    public function testFile(): void
    {
        Functions\when('plugin_dir_path')->alias(static function ($value) {
            return trailingslashit(dirname($value));
        });

        Functions\when('plugin_dir_url')->alias(static function ($value) {
            $parts = explode('/', untrailingslashit(plugin_dir_path($value)));
            return 'https://example.com/' . trailingslashit(implode('/', array_slice($parts, -3)));
        });

        $pluginFile = '/var/www/html/wp-content/plugins/plugin-name/plugin-name.php';
        $pluginPath = '/var/www/html/wp-content/plugins/plugin-name/';
        $pluginUrl = 'https://example.com/wp-content/plugins/plugin-name/';

        $plugin = $this->getBasePluginMock([$pluginFile]);

        $this->assertEquals('plugin-name', $plugin->getId());
        $this->assertEquals($pluginFile, $plugin->getFile());
        $this->assertEquals($pluginPath, $plugin->getDirectoryPath());
        $this->assertEquals($pluginUrl, $plugin->getDirectoryUrl());
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    public function testShortFile(): void
    {
        $stub = $this->getBasePluginMock(['wp-content/plugins/plugin-name/plugin-name.php']);
        $this->assertEquals('plugin-name/plugin-name.php', $stub->getShortFile());

        $stub = $this->getBasePluginMock(['plugin-name/plugin-name.php']);
        $this->assertNull($stub->getShortFile());

        $stub = $this->getBasePluginMock(['plugin-name.php']);
        $this->assertNull($stub->getShortFile());
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    public function testVersion(): void
    {
        $stub = $this->getBasePluginMock();

        Functions\when('get_file_data')->justReturn([
            'Version' => '1.0.0-beta'
        ]);

        $this->assertEquals('1.0.0-beta', $stub->getVersion());
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    public function testAddHandler(): void
    {
        $plugin = $this->getBasePluginMock();
        $handler = $this->getBaseHandlerMock($plugin);

        $this->assertContainsNoHandlers($plugin);

        $plugin->addHandlerObject($handler);

        $this->assertContainsHandler($plugin, $handler);
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    public function testAddHandlerString(): void
    {
        $plugin = $this->getBasePluginMock();
        $handler = $this->getBaseHandlerMock($plugin);

        $this->assertContainsNoHandlers($plugin);

        $plugin->addHandler(get_class($handler));

        $this->assertContainsOnlyHandlerInstances($plugin);
    }

    /**
     * @param bool $admin
     * @return void
     * @throws \ReflectionException
     */
    public function testRun($admin = false): void
    {
        $plugin = $this->getBasePluginMock(['plugin/plugin.php']);

        $handler = $this->getBaseHandlerMock($plugin);
        $handler->expects($this->once())->method('setup')->with($admin);

        $registerCallback = function ($pluginFile, $callback) use ($plugin) {
            $this->assertIsString($pluginFile);
            $this->assertIsArray($callback);
            $this->assertEquals($plugin, $callback[0]);
            $this->assertIsString($callback[1]);
            $callback[0]->{$callback[1]}();
        };

        Functions\when('is_admin')->justReturn($admin);
        Functions\expect('register_activation_hook')->times(1)->andReturnUsing($registerCallback);
        Functions\expect('register_deactivation_hook')->times(1)->andReturnUsing($registerCallback);

        $plugin->addHandlerObject($handler);
        $plugin->run();
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    public function testRunAdmin(): void
    {
        $this->testRun(true);
    }

    /**
     * @param PluginInterface $plugin
     * @param HandlerInterface $handler
     * @throws \ReflectionException
     */
    private function assertContainsHandler(PluginInterface $plugin, HandlerInterface $handler): void
    {
        $reflection = new \ReflectionClass($plugin);
        $method = $reflection->getMethod('getHandlers');
        $method->setAccessible(true);

        $handlers = $method->invokeArgs($plugin, []);
        $this->assertNotEmpty($handlers);
        $this->assertContains($handler, $handlers);
    }

    /**
     * @param PluginInterface $plugin
     * @throws \ReflectionException
     */
    private function assertContainsOnlyHandlerInstances(PluginInterface $plugin): void
    {
        $reflection = new \ReflectionClass($plugin);
        $method = $reflection->getMethod('getHandlers');
        $method->setAccessible(true);

        $handlers = $method->invokeArgs($plugin, []);
        $this->assertNotEmpty($handlers);
        $this->assertContainsOnlyInstancesOf(HandlerInterface::class, $handlers);
    }

    /**
     * @param PluginInterface $plugin
     * @throws \ReflectionException
     */
    private function assertContainsNoHandlers(PluginInterface $plugin): void
    {
        $reflection = new \ReflectionClass($plugin);
        $method = $reflection->getMethod('getHandlers');
        $method->setAccessible(true);

        $this->assertEmpty($method->invokeArgs($plugin, []));
    }
}
