<?php

namespace Ryvon\Plugin;

use Brain\Monkey;
use Brain\Monkey\Functions;
use PHPUnit\Framework\TestCase;
use Ryvon\Plugin\Handler\GenericHandlerInterface;

class PluginTest extends TestCase
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
     * @return void
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

        $plugin = new Plugin($pluginFile, []);

        $this->assertEquals('plugin-name', $plugin->getId());
        $this->assertEquals($pluginFile, $plugin->getFile());
        $this->assertEquals($pluginPath, $plugin->getDirectoryPath());
        $this->assertEquals($pluginUrl, $plugin->getDirectoryUrl());
    }

    /**
     * @return void
     */
    public function testPluginMeta(): void
    {
        Functions\when('get_file_data')->justReturn([
            'Plugin Name' => 'Example Plugin',
            'Version' => '1.0.0-beta',
        ]);

        $plugin = new Plugin('plugin/plugin.php', []);

        $this->assertEquals('Example Plugin', $plugin->getDisplayName());
        $this->assertEquals('1.0.0-beta', $plugin->getVersion());
    }

    /**
     * @param bool $admin
     * @return void
     */
    public function testRun($admin = false): void
    {
        $handler = $this->getMockBuilder(GenericHandlerInterface::class)
            ->setMethods(['setup'])
            ->getMock();

        $handler->expects($this->once())->method('setup')->with($admin);

        $plugin = new Plugin('plugin/plugin.php', [$handler]);

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

        $plugin->run();
    }

    /**
     * @return void
     */
    public function testRunAdmin(): void
    {
        $this->testRun(true);
    }
}
