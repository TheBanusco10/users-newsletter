<?php

namespace UsersNewsletter;

if (!function_exists('is_plugin_active')) {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

class UsersNewsletter
{
    public function __construct(){}

    public function users_newsletter_init() {
        add_action('plugins_loaded', [$this, 'users_newsletter_checkMainPlugin']);
    }

    public function users_newsletter_checkMainPlugin() {
        if (is_plugin_active('users/users.php')) {
            add_action('admin_notices', function () {
                $this->users_newsletter_adminAlert('Premium addon for Users activated', 'success');
            });
        }else {
            deactivate_plugins('users-newsletter/users-newsletter.php');
            add_action('admin_notices', function () {
                $this->users_newsletter_adminAlert('Error activating Premium addon for Users');
            });
        }
    }

    function users_newsletter_adminAlert($message = '', $alertType = 'error') {
        ?>
        <div class="notice notice-<?= $alertType ?>">
            <p><?php _e( $message, 'users' ); ?></p>
        </div>
        <?php
    }
}