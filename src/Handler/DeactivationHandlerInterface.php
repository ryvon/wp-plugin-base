<?php

namespace Ryvon\Plugin\Handler;

interface DeactivationHandlerInterface extends HandlerInterface
{
    /**
     * Called when the plugin is deactivated.
     *
     * @return void
     */
    public function deactivate(): void;
}
