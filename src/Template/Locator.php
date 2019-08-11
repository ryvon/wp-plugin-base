<?php

namespace Ryvon\Plugin\Template;

class Locator implements LocatorInterface
{
    /**
     * @var string
     */
    private $pluginPath;

    /**
     * @var string|null
     */
    private $pluginTemplatePath;

    /**
     * @param string $pluginPath The path to the plugin directory, this will be checked after the theme
     * @param string|null $pluginTemplatePath The relative path to use when searching the plugin directory
     */
    public function __construct(string $pluginPath, ?string $pluginTemplatePath = 'templates')
    {
        $this->pluginPath = $pluginPath;
        $this->pluginTemplatePath = $pluginTemplatePath;
    }

    /**
     * @return string
     */
    public function getPluginPath(): string
    {
        return $this->pluginPath;
    }

    /**
     * @param string $pluginPath
     * @return void
     */
    public function setPluginPath(string $pluginPath): void
    {
        $this->pluginPath = $pluginPath;
    }

    /**
     * @return string|null
     */
    public function getPluginTemplatePath(): ?string
    {
        return $this->pluginTemplatePath;
    }

    /**
     * @param string|null $pluginTemplatePath
     * @return void
     */
    public function setPluginTemplatePath(?string $pluginTemplatePath): void
    {
        $this->pluginTemplatePath = $pluginTemplatePath;
    }

    /**
     * @param string $templateFile
     * @return string|null
     */
    public function locate(string $templateFile): ?string
    {
        $template = locate_template($templateFile);
        if ($template) {
            return $template;
        }

        $path = rtrim($this->getPluginPath(), '/') . '/';
        if ($this->getPluginTemplatePath()) {
            $path .= trim($this->getPluginTemplatePath(), '/') . '/';
        }

        if (file_exists($path . $templateFile)) {
            return $path . $templateFile;
        }

        return null;
    }
}
