<?php

namespace Ryvon\Plugin;

use Ryvon\Plugin\Handler\ActivationHandlerInterface;
use Ryvon\Plugin\Handler\DeactivationHandlerInterface;
use Ryvon\Plugin\Handler\GenericHandlerInterface;
use Ryvon\Plugin\Handler\HandlerInterface;

class Plugin implements PluginInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $file;

    /**
     * @var array
     */
    private $meta;

    /**
     * @var HandlerInterface[]
     */
    private $handlers;

    /**
     * @param string $file
     * @param HandlerInterface[] $handlers
     */
    public function __construct(string $file, array $handlers)
    {
        $this->id = basename(basename($file, '.php'));
        $this->file = $file;
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
    public function getId(): string
    {
        return $this->id;
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
     * @return string
     */
    public function getDisplayName(): ?string
    {
        $pluginData = $this->getPluginMeta();

        return $pluginData['Plugin Name'] ?? null;
    }

    /**
     * @return string
     */
    public function getVersion(): ?string
    {
        $pluginData = $this->getPluginMeta();

        return $pluginData['Version'] ?? null;
    }

    /**
     * @return array
     */
    private function getPluginMeta(): array
    {
        if ($this->meta === null) {
            $this->meta = get_file_data($this->getFile(), [
                'Plugin Name' => 'Plugin Name',
                'Version' => 'Version',
            ], 'plugin');
        }

        return $this->meta;
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

        $admin = is_admin();
        foreach ($this->getHandlers() as $handler) {
            if (($handler instanceof GenericHandlerInterface) && $handler->setup($admin) === false) {
                return;
            }
        }
    }

    /**
     * @return void
     */
    public function activate(): void
    {
        $errors = [];

        foreach ($this->getHandlers() as $handler) {
            if ($handler instanceof ActivationHandlerInterface) {
                $activationErrors = $handler->activate();
                if (is_array($activationErrors) && count($activationErrors)) {
                    foreach ($activationErrors as $handlerError) {
                        $errors[] = $handlerError;
                    }
                }
            }
        }

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
