<?php

namespace Ryvon\Plugin\RequirementChecker;

class AcfChecker implements RequirementCheckerInterface
{
    /**
     * @var string
     */
    private $errorMessage;

    /**
     * @param string $errorMessage The error message to show to the user if Advanced custom fields is not available.
     *                             Example: PluginName requires Advanced Custom Fields.
     */
    public function __construct($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @inheritDoc
     */
    public function check(): ?array
    {
        if (!$this->isAcfActive()) {
            return [$this->errorMessage];
        }

        return [];
    }

    /**
     * @return bool
     */
    private function isAcfActive(): bool
    {
        if (!function_exists('is_plugin_active')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        return is_plugin_active('advanced-custom-fields/acf.php')
            || is_plugin_active('advanced-custom-fields-pro/acf.php');
    }
}
