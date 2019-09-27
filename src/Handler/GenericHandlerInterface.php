<?php

namespace Ryvon\Plugin\Handler;

interface GenericHandlerInterface extends HandlerInterface
{
    /**
     * Called on every page load. Should be used to add any Wordpress hooks required for the handler.
     *
     * If false is returned no further handlers will be processed. Any other return is discarded.
     *
     * @param bool $isAdmin Whether we are in the administrator section or not
     * @return false|mixed
     */
    public function setup(bool $isAdmin);
}
