<?php

namespace Ryvon\Plugin;

interface PluginInterface
{
    /**
     * @return string
     */
    public function getId(): string;

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

    /**
     * @return string|null
     */
    public function getDisplayName(): ?string;

    /**
     * @return string|null
     */
    public function getVersion(): ?string;

    /**
     * @return void
     */
    public function run(): void;
}
