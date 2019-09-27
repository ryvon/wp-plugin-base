<?php

if (!function_exists('plugin_add_admin_notice')) {
    /**
     * @param string $message
     * @param string $type
     */
    function plugin_add_admin_notice($message, $type = 'error')
    {
        add_action('admin_notices', function () use ($message, $type) {
            ?>
            <div class="notice notice-<?php echo esc_attr($type); ?>">
                <p><?php echo $message; ?></p>
            </div>
            <?php
        });
    }
}

if (!function_exists('plugin_is_supported_php_version')) {
    /**
     * @param string $requiredVersion
     * @return bool
     */
    function plugin_is_supported_php_version($requiredVersion = '7.1')
    {
        return !version_compare(PHP_VERSION, $requiredVersion, '<');
    }
}

if (!function_exists('plugin_deactivate_on_unsupported_php')) {
    /**
     * @param string $pluginFile
     * @param string|false $message The message to show to the user when deactivated. Should contain 2 sprintf
     *                              placeholders for the the PHP version needed and the version installed.
     *                              Example: PluginName requires PHP %1$s or greater, you are running PHP %2$s.
     * @param string $phpVersion
     * @return bool
     */
    function plugin_deactivate_on_unsupported_php($pluginFile, $message, $phpVersion = '7.1')
    {
        if (plugin_is_supported_php_version($phpVersion)) {
            return false;
        }

        $pluginBasename = plugin_basename($pluginFile);
        $versionError = sprintf(
            $message,
            $phpVersion,
            PHP_VERSION
        );

        if (!function_exists('deactivate_plugins') || !function_exists('is_plugin_active')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        if (is_plugin_active($pluginBasename)) {
            plugin_add_admin_notice($versionError);
            deactivate_plugins($pluginBasename);
        } else {
            // If we got here while not active we are activating
            echo $versionError;
            exit;
        }

        return true;
    }
}
