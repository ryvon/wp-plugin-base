<?php

namespace Ryvon\Plugin\RequirementChecker;

use Ryvon\Plugin\Handler\ActivationHandlerInterface;
use Ryvon\Plugin\Handler\GenericHandlerInterface;
use Ryvon\Plugin\PluginAwareInterface;
use Ryvon\Plugin\PluginInterface;

class RequirementCheckerHandler implements ActivationHandlerInterface, GenericHandlerInterface, PluginAwareInterface
{
    /**
     * @var PluginInterface
     */
    private $plugin;

    /**
     * @var RequirementCheckerInterface[]
     */
    private $checkers;

    /**
     * @param RequirementCheckerInterface[] $checkers
     */
    public function __construct(array $checkers)
    {
        $this->checkers = $checkers;
    }

    /**
     * @param PluginInterface $plugin
     */
    public function setPlugin(PluginInterface $plugin): void
    {
        $this->plugin = $plugin;
    }

    /**
     * @inheritDoc
     */
    public function activate(): array
    {
        return $this->getErrors();
    }

    /**
     * @inheritDoc
     */
    public function setup(bool $isAdmin)
    {
        $errors = $this->getErrors();
        if (count($errors)) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
            deactivate_plugins(plugin_basename($this->plugin->getFile()));

            if ($isAdmin) {
                plugin_add_admin_notice(implode('<br/>', $errors));
            }

            return false;
        }

        return true;
    }

    /**
     * @return string[]
     */
    protected function getErrors(): array
    {
        $errorsLists = [];

        foreach ($this->checkers as $checker) {
            $checkerErrors = $checker->verify();
            if ($checkerErrors) {
                $errorsLists[] = $checkerErrors;
            }
        }

        return array_merge([], ...$errorsLists);
    }
}
