<?php

namespace Ryvon\Plugin;

use Ryvon\Plugin\Template\Locator;
use Ryvon\Plugin\Template\Renderer;
use Ryvon\Plugin\Template\RendererInterface;

abstract class BasePlugin implements PluginInterface
{
    /**
     * @var string
     */
    private $file;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $version;

    /**
     * @var HandlerInterface[]
     */
    private $handlers = [];

    /**
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->file = $file;
        $this->id = basename(basename($file, '.php'));
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDirectoryPath(): string
    {
        return plugin_dir_path($this->getFile());
    }

    /**
     * @return string
     */
    public function getDirectoryUrl(): string
    {
        return plugin_dir_url($this->getFile());
    }

    /**
     * @return HandlerInterface[]
     */
    protected function getHandlers(): array
    {
        return $this->handlers;
    }

    /**
     * @return string|null
     */
    public function getShortFile(): ?string
    {
        $lastSlash = strrpos($this->getFile(), '/');
        if ($lastSlash === false) {
            return null;
        }

        $penultimateSlash = strrpos($this->getFile(), '/', 0 - (strlen($this->getFile()) - $lastSlash + 1));
        if ($penultimateSlash === false) {
            return null;
        }

        return ltrim(substr($this->getFile(), $penultimateSlash), '/');
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        if ($this->version === null) {
            $pluginData = get_file_data($this->getFile(), ['Version' => 'Version'], 'plugin');

            $this->version = $pluginData['Version'] ?? 'Unknown';
        }
        return $this->version;
    }

    /**
     * @param string|HandlerInterface $handlerObjectOrClass
     * @return self
     */
    public function addHandler($handlerObjectOrClass): self
    {
        $classObject = $handlerObjectOrClass;

        if (\is_string($handlerObjectOrClass)) {
            $classObject = new $handlerObjectOrClass($this);
        }

        return $this->addHandlerObject($classObject);
    }

    /**
     * @param HandlerInterface $object
     * @return self
     */
    public function addHandlerObject(HandlerInterface $object): self
    {
        $this->handlers[] = $object;
        return $this;
    }

    /**
     * Setup the plugin hooks.
     *
     * @return void
     */
    public function run(): void
    {
        register_activation_hook($this->getFile(), [$this, 'activate']);
        register_deactivation_hook($this->getFile(), [$this, 'deactivate']);

        $this->setup();

        $admin = is_admin();
        foreach ($this->getHandlers() as $handler) {
            $handler->setup($admin);
        }
    }

    /**
     * @return void;
     */
    abstract protected function setup(): void;

    /**
     * @return void
     */
    public function activate(): void
    {
    }

    /**
     * @return void
     */
    public function deactivate(): void
    {
    }
}
