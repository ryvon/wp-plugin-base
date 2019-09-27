<?php

namespace Ryvon\Plugin\Handler;

interface ActivationHandlerInterface extends HandlerInterface
{
    /**
     * Called when the plugin is activated.  If any errors are returned they will be displayed to the user and
     * activation will be aborted.
     *
     * @return string[] Activation errors
     */
    public function activate(): array;
}
