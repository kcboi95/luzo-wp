<?php

/**
 * Example submenu
 *
 *  Luzo_Controller_Admin_Language_List
 * |____|                 |______| |__|
 *   ||                      ||      ||
 *   ||                      ||      ||
 *   ||                      ||     Action
 *   ||                      ||     (list)
 *   ||                   Controller
 * Class prefix           (language)
 * (dfm)
 *
 * menu slug result will be dfm_language_list
 *
 * 'menu_key' => [
 *       'page_title' => 'Language Management',
 *       'menu_title' => 'Language Management',
 *       'controller' => 'language',
 *       'action' => 'list'
 *       'capability' => 'manage_options', // optional, default is `manage_options`
 *       'no_header' => false, // optional, default is `false`
 *       'add_to_menu' => true, // optional, default is `true`
 *       'parent_slug' => 'custom_slug' // optional, default is null, you can use this to assign submenu to another menu
 *   ]
 */
return [
    'settings' => [
        'page_title' => 'Settings',
        'menu_title' => 'Settings',
        'controller' => 'plugin',
        'action' => 'settings',
        'no_header' => false
    ],
    'about_us' => [
        'page_title' => 'About Us',
        'menu_title' => 'About Us',
        'controller' => 'link',
        'action' => 'about',
        'no_header' => true
    ]
];
