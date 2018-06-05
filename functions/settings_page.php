<?php
/**
 * License key setting field
 *
 * @return void
 */
function luzo_setting_display_license_key_element()
{
    ?>
    	<input type="text" class="regular-text" name="luzo_license_key" id="luzo_license_key" value="<?php echo get_option('luzo_license_key'); ?>" />
    <?php

}

/**
 * Register setting fields
 *
 * @return void
 */
function luzo_display_theme_panel_fields()
{
    add_settings_section(LUZO_PLUGIN_SETTINGS_GROUP, "", null, "luzo_settings_page");

    add_settings_field("luzo_license_key", "License Key", "luzo_setting_display_license_key_element", "luzo_settings_page", LUZO_PLUGIN_SETTINGS_GROUP);

    register_setting(LUZO_PLUGIN_SETTINGS_GROUP, "luzo_license_key");
}

add_action("admin_init", "luzo_display_theme_panel_fields");