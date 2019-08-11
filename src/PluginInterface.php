<?php

namespace Ryvon\Plugin;

interface PluginInterface
{
    /**
     * @return void
     */
    public function run(): void;

    /**
     * @return string
     */
    public function getFile(): string;

    /**
     * @return string
     */
    public function getDirectoryPath(): string;

    /**
     * @return string
     */
    public function getDirectoryUrl(): string;
}
