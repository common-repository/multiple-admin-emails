<?php
/*
Plugin Name: Multiple Admin Emails
Plugin URI: http://wordpress.org/plugins/multiple-admin-emails
Description: Allows to edit From Name, From Email, admin emails and send test emails
Author: Phuc Pham
Version: 1.0
Author URI: http://facebook.com/svincoll4
*/

class P4P_Multiple_Admin_Emails{

    const TEXT_DOMAIN = 'p4p_mae';
    const PREFIX = 'p4p_mae_';
    const ADMIN_SLUG = 'multiple-admin-emails';

    var $field_settings;

    public function __construct(){
        $this->init();
        $this->admin_init();
        $this->front_init();
    }

    function init(){
        $this->field_settings = get_option(self::PREFIX."fields");

        add_filter('wp_mail_from', array($this, 'setting_from'));
        add_filter('wp_mail_from_name', array($this, 'setting_from_name'));
        add_filter('option_admin_email', array($this, 'setting_admin_emails'));
    }

    function admin_init(){
        if(!is_admin()){
            return;
        }

        add_action('admin_menu', array($this, 'register_menu'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    function front_init(){

    }

    function register_settings(){
        $group = self::PREFIX."group";

        register_setting( $group, self::PREFIX.'fields');
    }

    function register_menu(){
        add_options_page( __('Multiple Admin Emails', self::TEXT_DOMAIN), __('Multiple Admin Emails', self::TEXT_DOMAIN), 'manage_options', self::ADMIN_SLUG, array($this, 'admin_settings_fields'));
    }

    function admin_settings_fields(){
        include 'admin-settings.php';
    }

    function setting_from($from){
        if(!empty($this->field_settings['from_email'])){
            return $this->field_settings['from_email'];
        }

        return $from;
    }

    function setting_from_name($from_name){
        if(!empty($this->field_settings['from_name'])){
            return $this->field_settings['from_name'];
        }

        return $from_name;
    }

    function setting_admin_emails($email){
        if(!empty($this->field_settings['emails'])){
            $admin_emails = $this->field_settings['emails'];
            $admin_emails = explode("\n", $admin_emails);
            $admin_emails = array_filter($admin_emails);
            $admin_emails = array_map('trim', $admin_emails);

            if($admin_emails){
                $admin_emails = implode(",", $admin_emails);
                return $admin_emails;
            }

            return $email;

        }

        return $email;
    }
}

new P4P_Multiple_Admin_Emails();