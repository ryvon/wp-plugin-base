<?php

namespace Ryvon\Plugin;

interface HandlerInterface
{
    /**
     * @param bool $isAdmin Whether we are in the administrator section or not
     * @return void
     */
    public function setup(bool $isAdmin): void;
}
