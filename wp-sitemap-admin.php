<?php
class WP_Sitemap_Admin
{
    public static function init()
    {
        add_action('admin_menu', array('WP_Sitemap_Admin', 'add_admin_menu'));/* инициализируем меню в админке*/
        add_action('admin_init', array('WP_Sitemap_Admin', 'plugin_settings'));/*Вывод настроек в меню*/
        add_filter('plugin_action_links_' . plugin_basename(plugin_dir_path(__FILE__) . 'index.php'), array('WP_Sitemap_Admin', 'admin_plugin_settings_link'));/*добавляем ссылку на настройки на странице плагинов */
    }

    public static function add_admin_menu()
    {
        $hello1 = __('WP-sitemap', 'wp-sitemap-computy');
        add_options_page(' ', $hello1, 'manage_options', 'wp-sitemap-options', array('WP_Sitemap_Admin', 'wp_sitemap_options'));
    }

    public static function admin_plugin_settings_link($links)
    {
        $settings_link = '<a href="options-general.php?page=wp-sitemap-options">'.__('Settings', 'wp-sitemap-computy').'</a>';
        array_unshift($links, $settings_link);
        return $links;
    }



    public static function plugin_settings()
    {

        register_setting('option_group_sitemap', 'wp_sitemap_computy_option_name', 'sanitize_wp_sitemap');
        $trans1 = __('Plugin setting', 'wp-sitemap-computy');
        $trans10 = __('Disable embedded sitemap');

        add_settings_section('section_id', $trans1, '', 'sitemap_page');
      add_settings_field('primer_field9', $trans10, array('WP_Sitemap_Admin', 'fill_primer_fiel9'), 'sitemap_page', 'section_id');
    }


## Заполняем опцию 9
    public static function fill_primer_fiel9()
    {
        $val = get_option('wp_sitemap_computy_option_name');
        if (isset($val['vkl'])) {
            $vp = $val['vkl'];
        } else {
            $vp = '';
        }
        $val = $val ? $vp : null;
        ?>
        <label><input type="checkbox" name="wp_sitemap_computy_option_name[vkl]"
       value="1" <?php checked(1, $val) ?> /> <?php _e(' (Disable sitemap feature in WordPress)', 'wp-sitemap-computy'); ?>
        </label>
        <?php
    }


## Очистка данных
    public static function sanitize_wp_sitemap($options)
    {
        foreach ($options as $name => & $val) {
            if ($name == 'vkl')
                $val = intval($val);
        }
        return $options;
    }

    public static function wp_sitemap_options()
    {
        // тут уже будет находиться содержимое страницы настроек
        ?>
        <div class="wrap wp-sitemap-computy-admin">
        <h2><?php echo _e('WP SITEMAP COMPUTY', 'wp-sitemap-computy'), ' V', WP_SITEMAP_COMPUTY_VERSION; ?></h2>
        <p><?php echo _e('With the support of <a href="https://computy.ru" target="_blank" title="Development and support of sites on WordPress"> Computy </a>', 'wp-sitemap-computy') ?> </p>
        <hr/>
        <h2><?php echo _e('Plugin description', 'wp-sitemap-computy') ?></h2>
        <?php echo _e('WordPress 5.5 introduces a new feature that adds basic extensible XML sitemap functionality to WordPress core.<br> 
         This functionality does not imply settings and all pages are displayed in the sitemap.<br>
This plugin disables the built-in systemmap.', 'wp-sitemap-computy') ?>
        <div class="wrap">
            <h2><?php echo get_admin_page_title() ?></h2>
            <form action="options.php" method="POST">
                <?php
                settings_fields('option_group_sitemap');     // скрытые защитные поля
                do_settings_sections('sitemap_page'); // Секции с настройками (опциями). У нас она всего одна 'section_id'
                submit_button();
                ?>
            </form>
        </div>
 <?php
    }
}