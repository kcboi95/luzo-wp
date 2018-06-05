<div class="wrap">
<h1><?php echo get_admin_page_title() ?></h1>
<form method="post" action="options.php">
<?php
    settings_fields(LUZO_PLUGIN_SETTINGS_GROUP);
    do_settings_sections('luzo_settings_page');
    submit_button();
?>
</form>
</div>