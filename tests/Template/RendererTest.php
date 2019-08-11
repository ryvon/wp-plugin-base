<?php

namespace Ryvon\Plugin;

use Brain\Monkey;
use Brain\Monkey\Functions;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ryvon\Plugin\Template\LocatorInterface;
use Ryvon\Plugin\Template\Renderer;

class RendererTest extends TestCase
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
     * @return MockObject|LocatorInterface
     */
    private function createLocatorMock()
    {
        return $this->createMock(LocatorInterface::class);
    }

    /**
     * @return void
     */
    public function testGetSet(): void
    {
        $locator = $this->createLocatorMock();
        $renderer = new Renderer($locator);

        $this->assertEquals($locator, $renderer->getLocator());
    }

    /**
     * @return void
     */
    public function testRenderMissing(): void
    {
        $locator = $this->createLocatorMock();
        $renderer = new Renderer($locator);

        $this->assertEquals(null, $renderer->render('test.php'));
    }

    /**
     * @return void
     */
    public function testRenderUnreadable(): void
    {
        $locator = $this->createLocatorMock();
        $renderer = new Renderer($locator);

        $locator->expects($this->once())->method('locate')->willReturnCallback(static function ($file) {
            return sprintf('/tmp/%s-%s', $file, uniqid('-', true));
        });

        $this->assertEquals(null, $renderer->render('test.php'));
    }

    /**
     * @return void
     */
    public function testRenderExisting(): void
    {
        $locator = $this->createLocatorMock();
        $renderer = new Renderer($locator);

        $locator->expects($this->exactly(3))->method('locate')->willReturnCallback(static function ($file) {
            return sprintf('%s/Resources/%s', dirname(__DIR__), $file);
        });

        $this->assertEquals("<p>Message</p>\n", $renderer->render('message.php', [
            'message' => 'Message'
        ]));

        $this->assertEquals("<div><p>Sub Message</p>\n</div>\n", $renderer->render('sub-render.php', [
            'message' => 'Sub Message'
        ]));
    }

    /**
     * @return void
     */
    public function testError(): void
    {
        $this->assertFalse(defined('WP_DEBUG'), 'WP_DEBUG already defined');

        define('WP_DEBUG', true);

        Functions\expect('error_log')->times(2);

        $this->testRenderMissing();
        $this->testRenderUnreadable();
    }
}
