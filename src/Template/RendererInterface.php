<?php

namespace Ryvon\Plugin\Template;

interface RendererInterface
{
    /**
     * @param string $templateFile The template file we are rendering
     * @param array $context
     * @return string|null
     */
    public function render(string $templateFile, array $context = []): ?string;
}
