<?php

namespace Ryvon\Plugin\Template;

interface LocatorInterface
{
    /**
     * @param string $templateFile
     * @return string|null
     */
    public function locate(string $templateFile): ?string;
}
