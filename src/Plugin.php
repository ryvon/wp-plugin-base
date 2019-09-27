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
    private $data;

    /**
     * @var HandlerInterface[]
     */
    private $handlers;

    /**
     * @param string $file
     * @param HandlerInterface[] $handlers
     * @param array $data
     */
    public function __construct(string $file, array $handlers, array $data = [])
    {
        $this->id = basename(basename($file, '.php'));
        $this->file = $file;
        $this->handlers = [];
        $this->data = $data;

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
        $pluginData = $this->getData('plugin_meta');
        if ($pluginData === null) {
            $pluginData = get_file_data($this->getFile(), [
                'Plugin Name' => 'Plugin Name',
                'Version' => 'Version',
            ], 'plugin');

            $this->setData('plugin_meta', $pluginData);
        }

        return $pluginData;
    }

    /**
     * TODO Evaluate whether we want to keep [set/get/clear]Data or not. The intent is to provide a way for handlers to
     *      know about post type ids or other required data but there may be a better way of handling it (Options class
     *      passed to handler constructors?)
     *
     * @param string $key
     * @param $value
     */
    public function setData(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * @param string $key
     * @param mixed $defaultValue
     * @return mixed
     */
    public function getData(string $key, $defaultValue = null)
    {
        return $this->data[$key] ?? $defaultValue;
    }

    /**
     * @param string $key
     */
    public function clearData(string $key): void
    {
        if (isset($this->data[$key])) {
            unset($this->data[$key]);
        }
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
