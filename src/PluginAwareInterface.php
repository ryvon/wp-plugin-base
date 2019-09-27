<?php

namespace Ryvon\Plugin;

interface PluginAwareInterface
{
    /**
     * @param PluginInterface $plugin
     */
    public function setPlugin(PluginInterface $plugin): void;
}
