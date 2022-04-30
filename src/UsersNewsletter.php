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

            add_action('wp_enqueue_scripts', [$this, 'users_newsletter_loadScripts']);

            // Loading Ajax
            add_action('wp_ajax_users_newsletter_sendEmailToUsers', [$this, 'users_newsletter_sendEmailToUsers']);
            add_action('wp_ajax_nopriv_users_newsletter_sendEmailToUsers', [$this, 'users_newsletter_sendEmailToUsers']);
        }else {
            deactivate_plugins('users-newsletter/users-newsletter.php');
            add_action('admin_notices', function () {
                $this->users_newsletter_adminAlert('Error activating Premium addon for Users');
            });
        }
    }

    function users_newsletter_loadScripts() {

        // Scripts
        wp_enqueue_script('users-newsletters-js', plugin_dir_url(__FILE__) . 'js/users-newsletter.js', ['jquery'], '1.0', true);

        wp_localize_script('users-newsletters-js', 'ajax', ['ajaxurl' => admin_url('admin-ajax.php')]);

        // Styles
        wp_enqueue_style('users-newsletter-styles', plugin_dir_url(__FILE__) . 'css/styles.css');
    }

    function users_newsletter_sendEmailToUsers() {

        // wp_mail($email, 'Test', 'Sending test email');

        header('Content-Type: application/json');
        echo json_encode([
           'message' => 'Email sent',
           'emails' => $_POST['emails']
        ]);
        die();

    }

    function users_newsletter_adminAlert($message = '', $alertType = 'error') {
        ?>
        <div class="notice notice-<?= $alertType ?>">
            <p><?php _e( $message, 'users' ); ?></p>
        </div>
        <?php
    }
}