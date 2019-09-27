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

if (!function_exists('plugin_verify_php_version')) {
    /**
     * @param string $requiredVersion
     * @param string|null $adminErrorMessage
     * @return bool
     */
    function plugin_verify_php_version($requiredVersion, $adminErrorMessage = null)
    {
        if (version_compare(PHP_VERSION, $requiredVersion, '<')) {
            if ($adminErrorMessage !== null) {
                plugin_add_admin_notice($adminErrorMessage);
            }

            return false;
        }

        return true;
    }
}
