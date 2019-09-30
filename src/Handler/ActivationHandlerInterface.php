<?php

namespace Ryvon\Plugin\Handler;

interface ActivationHandlerInterface extends HandlerInterface
{
    /**
     * Called when the plugin is activated.  If any errors are returned they will be displayed to the user and
     * activation will be aborted.
     *
     * @return string[]|null The activation errors to show the user.
     */
    public function activate(): ?array;
}
