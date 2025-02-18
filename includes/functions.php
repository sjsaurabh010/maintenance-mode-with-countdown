<?php
// Plugin Activation
function mmwc_activate_plugin() {
    add_option('mmwc_maintenance_mode', 'on');
    add_option('mmwc_end_time', strtotime('+1 day')); // default maintenance for 1 day
}

// Plugin Deactivation
function mmwc_deactivate_plugin() {
    delete_option('mmwc_maintenance_mode');
    delete_option('mmwc_end_time');
}

// Uninstall Plugin
function mmwc_uninstall_plugin() {
    delete_option('mmwc_maintenance_mode');
    delete_option('mmwc_end_time');
}

// Add settings page to WordPress admin
function mmwc_add_settings_page() {
    add_options_page(
        'Maintenance Mode Settings',
        'Maintenance Mode',
        'manage_options',
        'maintenance-mode-with-countdown',
        'mmwc_settings_page'
    );
}
add_action('admin_menu', 'mmwc_add_settings_page');

// Settings page content
function mmwc_settings_page() {
    ?>
    <div class="wrap">
        <h2>Maintenance Mode with Countdown Timer Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('mmwc-settings-group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Maintenance Mode</th>
                    <td>
                        <input type="radio" name="mmwc_maintenance_mode" value="on" <?php checked(get_option('mmwc_maintenance_mode'), 'on'); ?> /> On
                        <input type="radio" name="mmwc_maintenance_mode" value="off" <?php checked(get_option('mmwc_maintenance_mode'), 'off'); ?> /> Off
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">End Time</th>
                    <td>
                        <input type="datetime-local" name="mmwc_end_time" value="<?php echo date('Y-m-d\TH:i:s', get_option('mmwc_end_time')); ?>" />
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Register the settings
function mmwc_register_settings() {
    register_setting('mmwc-settings-group', 'mmwc_maintenance_mode');
    register_setting('mmwc-settings-group', 'mmwc_end_time');
}
add_action('admin_init', 'mmwc_register_settings');
