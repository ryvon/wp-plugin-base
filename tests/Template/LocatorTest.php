<?php

namespace Ryvon\Plugin;

use Brain\Monkey;
use Brain\Monkey\Functions;
use PHPUnit\Framework\TestCase;
use Ryvon\Plugin\Template\Locator;

class LocatorTest extends TestCase
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
    public function testGetSet(): void
    {
        $locator = new Locator('/var/www/html/wp-content/plugins/plugin-name', 'templates');

        $this->assertEquals('/var/www/html/wp-content/plugins/plugin-name', $locator->getPluginPath());
        $this->assertEquals('templates', $locator->getPluginTemplatePath());

        $locator->setPluginPath('/var/www/html/wp-content/plugins/another-plugin-name');
        $locator->setPluginTemplatePath('template');

        $this->assertEquals('/var/www/html/wp-content/plugins/another-plugin-name', $locator->getPluginPath());
        $this->assertEquals('template', $locator->getPluginTemplatePath());
    }

    /**
     * @return void
     */
    public function testLocateInTheme(): void
    {
        $locator = new Locator('/var/www/html/wp-content/plugins/plugin-name', 'templates');

        Functions\expect('locate_template')->times(1)->andReturnUsing(
            static function ($file) {
                return '/var/www/html/wp-content/themes/theme-name/' . $file;
            }
        );

        $this->assertEquals('/var/www/html/wp-content/themes/theme-name/test.php', $locator->locate('test.php'));
    }

    /**
     * @return void
     */
    public function testLocateInPlugin(): void
    {
        $path = '/var/www/html/wp-content/plugins/plugin-name';
        $subPath = 'templates';
        $locator = new Locator($path, $subPath);

        Functions\expect('locate_template')->times(1)->andReturnUsing(
            static function (/** @noinspection PhpUnusedParameterInspection */ $file) {
                return '';
            }
        );

        Functions\expect('file_exists')->times(1)->andReturnUsing(
            static function (/** @noinspection PhpUnusedParameterInspection */ $file) {
                return true;
            }
        );

        $this->assertEquals(sprintf('%s/%s/test.php', $path, $subPath), $locator->locate('test.php'));
    }

    /**
     * @return void
     */
    public function testLocateMissing(): void
    {
        $path = '/var/www/html/wp-content/plugins/plugin-name';
        $subPath = 'templates';
        $locator = new Locator($path, $subPath);

        Functions\expect('locate_template')->times(1)->andReturnUsing(
            static function (/** @noinspection PhpUnusedParameterInspection */ $file) {
                return '';
            }
        );

        Functions\expect('file_exists')->times(1)->andReturnUsing(
            static function (/** @noinspection PhpUnusedParameterInspection */ $file) {
                return false;
            }
        );

        $this->assertNull($locator->locate('test.php'));
    }
}
