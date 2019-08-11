<?php

namespace Ryvon\Plugin;

abstract class BaseHandler implements HandlerInterface
{
    /**
     * @var PluginInterface
     */
    protected $plugin;

    /**
     * @param PluginInterface $plugin
     */
    public function __construct(PluginInterface $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @return PluginInterface
     */
    public function getPlugin(): PluginInterface
    {
        return $this->plugin;
    }

    /**
     * Convenience function to add a filter while binding the callback to this handler instance.
     *
     * @param string $tag
     * @param string|callable $functionToAdd
     * @param int $priority
     * @param int $acceptedArgs
     * @return void
     */
    protected function addFilter(string $tag, $functionToAdd, int $priority = 10, int $acceptedArgs = 1): void
    {
        add_filter($tag, $this->getCallback($functionToAdd), $priority, $acceptedArgs);
    }

    /**
     * Convenience function to add an action while binding the callback to this handler instance.
     *
     * @param string $tag
     * @param string|callable $functionToAdd
     * @param int $priority
     * @param int $acceptedArgs
     * @return void
     */
    protected function addAction(string $tag, $functionToAdd, int $priority = 10, int $acceptedArgs = 1): void
    {
        add_action($tag, $this->getCallback($functionToAdd), $priority, $acceptedArgs);
    }

    /**
     * Convenience function to add a shortcode while binding the callback to this handler instance.
     *
     * @param string $tag
     * @param string|callable $functionToAdd
     * @return void
     */
    protected function addShortcode(string $tag, $functionToAdd): void
    {
        add_shortcode($tag, $this->getCallback($functionToAdd));
    }

    /**
     * @param string|callable $functionToAdd
     * @return string|callable
     */
    private function getCallback($functionToAdd)
    {
        if (!is_string($functionToAdd)) {
            return $functionToAdd;
        }

        if (!method_exists($this, $functionToAdd)) {
            return $functionToAdd;
        }

        return [$this, $functionToAdd];
    }
}
