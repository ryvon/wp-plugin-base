<?php

namespace Ryvon\Plugin;

use Ryvon\Plugin\Handler\ActivationHandlerInterface;
use Ryvon\Plugin\Handler\DeactivationHandlerInterface;
use Ryvon\Plugin\Handler\GenericHandlerInterface;
use Ryvon\Plugin\Handler\HandlerInterface;


abstract class Plugin implements PluginInterface
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
    private $handlers;

    /**
     * @param string $file
     */
    public function __construct(string $file, array $handlers)
    {
        $this->file = $file;
        $this->id = basename(basename($file, '.php'));
        $this->handlers = [];

        foreach ($handlers as $handler) {
            if ($handler instanceof PluginAwareInterface) {
                $handler->setPlugin($this);
            }
            $this->handlers[] = $handler;
        }
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
     * @return HandlerInterface[]
     */
    protected function getHandlers(): array
    {
        return $this->handlers;
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
            if (($handler instanceof GenericHandlerInterface) && $handler->setup($admin) === false) {
                return;
            }
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
        $activationErrors = [];

        foreach ($this->getHandlers() as $handler) {
            if ($handler instanceof ActivationHandlerInterface) {
                $activationErrors[] = $handler->activate();
            }
        }

        $errors = array_merge([], ...$activationErrors);
        if (count($errors)) {
            echo implode('<br/>', $errors);
            exit;
        }
    }

    /**
     * @return void
     */
    public function deactivate(): void
    {
        foreach ($this->getHandlers() as $handler) {
            if ($handler instanceof DeactivationHandlerInterface) {
                $handler->deactivate();
            }
        }
    }
}
