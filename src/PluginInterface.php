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
     * @param string $key
     * @param $value
     */
    public function setData(string $key, $value): void;

    /**
     * @param string $key
     * @param mixed $defaultValue
     * @return mixed
     */
    public function getData(string $key, $defaultValue = null);

    /**
     * @return void
     */
    public function run(): void;
}
