<?php

namespace Ryvon\Plugin\PostType;

interface PostTypeLabelGeneratorInterface
{
    /**
     * @param string $singular
     * @param string $plural
     * @param string $textDomain
     * @return array
     */
    public function generate(string $singular, string $plural, string $textDomain = 'default'): array;
}
