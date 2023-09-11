<?php

class CoreTheme
{

    protected static $instance;
    public static $menus;
    public static $settings;
    public static $bloginfo;




    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private function __construct()
    {

        self::$menus = self::getMenusArray(get_field('system', 'options')['menus']);
        self::$settings = self::getInfoSettings();

        self::$bloginfo = [
            'icon' => self::getSiteIconData(),
            'title' => get_bloginfo('name'),
            'description' => get_bloginfo('description')
        ];

        self::removeWpDefaultScriptsAndStyles();
        self::disableGutenBerg();
        self::addThemeSupport();
        self::registerAllMenus();
        self::registerCustomPostTypesAndTaxonomies();
        self::enqueAllScriptsAndStyles();
        self::addRootStyles();
        self::addPageExcerpt();
        self::addShortCodeYoastSEO();
        self::enableWebp();

        self::addCustomizerSettings();
        self::customizerPreviewScripts();
        self::removeComments();

    }

    public static function render()
    {
        $findContent = false;
        
        $defaultPageContent = get_field("content", "options");
        $obj = get_queried_object_id();

        $pageContent = get_field("content", $obj);

        if($pageContent == false || empty($pageContent) || $obj == 0){
            $pageContent = null;
            $allTemplates = get_field("template_constructor", "options");
            
            if (!empty($allTemplates)) {

                foreach ($allTemplates as $template) {
                    if ($template['type']($template['params'])) {
                        $pageContent = $template['content'];
                        $findContent = true;
                        break;
                    } else {
                        $findContent = false;
                    }
                }
            }
        }
        else{
            $findContent = true;
        }

        if ($findContent == true) {
            self::renderPage($pageContent, $defaultPageContent);
        }
    }

    private static function renderPage($pageContent, $defaultPageContent)
    {

        if (!empty($pageContent || $defaultPageContent)) {
            foreach ($pageContent as $contentItem) {

                if ($contentItem['default_content'] === true) {
                    foreach ($defaultPageContent as $defaultItem) {
                        if ($defaultItem['acf_fc_layout'] === $contentItem['acf_fc_layout']) {
                            $contentItem = $defaultItem;
                            break;
                        }
                    }
                }

                if ($contentItem['is_visible'] === true) {
                    $path = "template-parts/" . $contentItem['acf_fc_layout'] . "/" . $contentItem['acf_fc_layout'];
                    ob_start();
                    get_template_part($path, $contentItem['layout'], $contentItem[$contentItem['acf_fc_layout'] . "-" . $contentItem['layout']]);
                    echo do_shortcode(ob_get_clean());
                }

            }
        }

    }

    public static function renderBlock($slug, $mode = false)
    {
        if ($mode == false) {
            $content = get_field($slug);
        } else {
            $content = get_field($slug, $mode);
        }

        if (!empty($content) && $content != false && $content['is_visible'] == true) {
            $path = "template-parts/" . $slug . "/" . $slug;
            ob_start();
            get_template_part($path, $content['layout'], $content[$slug . "-" . $content['layout']]);
            return ob_get_clean();
        } else {
            throw new Exception("Не удалось загрузить данные шаблона " . $slug);
        }
    }

    private function getInfoSettings()
    {
        $infoSettings = get_field("settings", "options");
        $infoSettings['phones'] = explode(",", $infoSettings['phone']);
        $infoSettings['clean_phone'] = getCleanPhone($infoSettings['phones']);
        return $infoSettings;
    }

    private static function addRootStyles()
    {
        add_action('wp_head', 'setRootStyles');
        function setRootStyles()
        {
            $colors = get_field('system', 'options')['colors']; ?>
            <style id="root-styles">
                :root {
                    --default-transition: 0.3s ease-in-out;
                    <?
                    foreach ($colors as $color) {
                        $value = get_theme_mod($color['key'], $color['value']);
                        echo "--" . $color['key'] . ": $value;\n";
                    }
                    ?>
                }
            </style>
        <?
        }


    }

    private static function addThemeSupport()
    {
        $themeSupportSettings = get_field('system', 'options')['theme_support'];
        foreach ($themeSupportSettings as $supItem) {
            if ($supItem['enable'] == true) {
                if ($supItem['params_enable'] == true && $supItem['args'] != null) {
                    if (isset($supItem['args'])) {
                        $argsArray = json_decode($supItem['args'], true);

                        if (is_array($argsArray)) {
                            add_theme_support($supItem['function'], $argsArray);
                        }

                    }
                } else {
                    add_theme_support($supItem['function']);
                }
            }
        }
    }

    private static function addPageExcerpt()
    {
        function page_excerpt()
        {
            add_post_type_support('page', array('excerpt'));
        }
        add_action('init', 'page_excerpt');

        add_filter('excerpt_length', function () {
            return 20;
        });

        add_filter('excerpt_more', function ($more) {
            return '...';
        });
    }

    private static function disableGutenBerg()
    {
        if ('disable_gutenberg') {
            remove_theme_support('core-block-patterns');
            add_filter('use_block_editor_for_post_type', '__return_false', 100);
            remove_action('wp_enqueue_scripts', 'wp_common_block_scripts_and_styles');
            add_action('admin_init', function () {
                remove_action('admin_notices', ['WP_Privacy_Policy_Content', 'notice']);
                add_action('edit_form_after_title', ['WP_Privacy_Policy_Content', 'notice']);
            });
        }
    }


    private static function getMenusArray($menuArray)
    {

        $result = [];
        foreach ($menuArray as $item) {
            $result[$item['slug']] = [
                'slugMenu' => $item['slug'],
                'titleMenu' => $item['title'],
                'args' => json_decode($item['args'], true)
            ];
        }

        return $result;
    }

    private function registerAllMenus()
    {
        foreach (self::$menus as $menu) {
            $regMenu = [$menu['slugMenu'] => $menu['titleMenu']];
            register_nav_menus($regMenu);
        }
    }

    private static function registerCustomPostTypesAndTaxonomies()
    {

        add_action('init', 'regCPT');
        function regCPT()
        {


            $cpts = get_field('system', 'options')['cpts'];

            if (!empty($cpts)) {

                foreach ($cpts as $item) {
                    $taxLabels = $item['taxArgs']['labels'];
                    $taxSlug = $item['taxArgs']['rewrite']['slug'];

                    register_taxonomy(
                        $item['taxName'],
                        array(),
                        array(
                            'labels' => $taxLabels,
                            'hierarchical' => $item['taxArgs']['hierarchical'],
                            'public' => $item['taxArgs']['public'],
                            'show_admin_column' => $item['taxArgs']['show_admin_column'],
                            'rewrite' => array('slug' => $taxSlug)
                        )
                    );

                    $cptLabels = $item['cptArgs']['labels'];
                    $cptSupports = $item['cptArgs']['supports'];

                    register_post_type($item['titleCPT'], array(
                        'labels' => $cptLabels,
                        'public' => $item['cptArgs']['public'],
                        'has_archive' => $item['cptArgs']['has_archive'],
                        'menu_position' => $item['cptArgs']['menu_position'],
                        'menu_icon' => $item['cptArgs']['menu_icon'],
                        'supports' => $cptSupports,
                        'taxonomies' => array($item['taxName']),
                    )
                    );
                }
            }
        }
    }

    private static function enqueAllScriptsAndStyles()
    {

        add_action('wp_enqueue_scripts', 'enqueAllS');

        function enqueAllS()
        {
            wp_deregister_script('jquery');
            $stylesAndScripts = get_field('system', 'options')['stylesAndScripts'];

            foreach ($stylesAndScripts as $item) {

                if ($item['type'] == 'url') {

                    $item['url'] = str_replace("{get_template_directory_uri}", get_template_directory_uri(), $item['url']);

                    $deps = [];
                    if (isset($item['deps']) && $item['deps'] != null) {
                        $deps = str_replace([' ', '"'], "", $item['deps']);
                        $deps = explode(",", $deps);
                    }

                    if ($item['file'] == 'script') {
                        if ($item['in_footer'] == 'header') {
                            $in_footer = false;
                        } else {
                            $in_footer = true;
                        }
                        wp_enqueue_script($item['slug'], $item['url'], $deps, $item['ver'], $in_footer);
                    } else {
                        wp_enqueue_style($item['slug'], $item['url'], $deps, $item['ver'], $item['media']);
                    }
                }
            }
        }

        $stylesAndScripts = get_field('system', 'options')['stylesAndScripts'];

        foreach ($stylesAndScripts as $key => $item) {
            if ($item['type'] == 'inline') {

                if ($item['in_footer'] == 'header' || $item['in_footer'] == null) {
                    add_action('wp_head', function () use ($item) {
                        echo $item['code'];
                    });
                } else {
                    add_action('wp_footer', function () use ($item) {
                        echo $item['code'];
                    });
                }
            }
        }

        add_action('wp_enqueue_scripts', 'ajax_form_scripts');
        function ajax_form_scripts()
        {
            wp_localize_script('ajax-form', 'ajax_form_object', [
                'url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('ajax-form-nonce'),
            ]);
        }
    }

    private static function removeWpDefaultScriptsAndStyles()
    {
        add_action('wp_enqueue_scripts', 'removeWpDefaultScriptsAndStylesInner');
        function removeWpDefaultScriptsAndStylesInner()
        {
            wp_dequeue_style('wp-block-library');
            wp_dequeue_style('wp-block-library-theme');
            wp_dequeue_style('wc-block-style');
            wp_deregister_script('jquery');
            wp_deregister_script('wp-embed');
        }
    }



    public function getSiteIconData()
    {
        $siteIconId = get_option('site_icon');
        $siteIcon = [];
        if ($siteIconId != false && $siteIconId != null && wp_get_attachment_image_src($siteIconId, 'full')) {
            $siteIcon['url'] = wp_get_attachment_image_src($siteIconId, 'full')[0];
            if ($siteIcon) {
                $siteIcon['alt'] = get_post_meta($siteIconId, '_wp_attachment_image_alt', true);
                $siteIcon['title'] = get_the_title($siteIconId);
            }
        }
        return $siteIcon;

    }

    private static function addShortCodeYoastSEO()
    {
        add_filter('wpseo_title', 'support_wpseo_shortcodes');
        add_filter('wpseo_opengraph_title', 'support_wpseo_shortcodes');
        add_filter('wpseo_twitter_title', 'support_wpseo_shortcodes');
        add_filter('wpseo_metadesc', 'support_wpseo_shortcodes', 100, 1);
        add_filter('wpseo_twitter_description', 'support_wpseo_shortcodes', 100, 1);
        function support_wpseo_shortcodes($content)
        {
            return do_shortcode($content);
        }
        add_filter('wpseo_opengraph_desc', 'support_wpseo_opengrap_shortcodes', 10);
        function support_wpseo_opengrap_shortcodes($description)
        {
            unset($description);
            $opengrap_description = get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true);
            return do_shortcode($opengrap_description);
        }
    }

    private static function removeComments()
    {
        function wph_remove_comments_column($defaults)
        {
            unset($defaults['comments']);
            return $defaults;
        }
        add_filter('manage_pages_columns', 'wph_remove_comments_column');
        add_filter('manage_posts_columns', 'wph_remove_comments_column');

        add_action('admin_menu', 'remove_admin_menus');
        function remove_admin_menus()
        {
            global $menu;

            $unset_titles = [
                __('Comments'),
            ];

            end($menu);
            while (prev($menu)) {

                $value = explode(' ', $menu[key($menu)][0]);
                $title = $value[0] ?: '';

                if (in_array($title, $unset_titles, true)) {
                    unset($menu[key($menu)]);
                }
            }

        }
    }

    public static function renderMenu($keyMenu)
    {
        $currentMenu = self::$menus[$keyMenu];
        $currentMenuArgs = $currentMenu['args'];
        wp_nav_menu($currentMenuArgs);
    }

    private static function customizerPreviewScripts()
    {

        add_action('wp_footer', 'insert_custom_js');
        function insert_custom_js()
        { ?>
            <script>
                var themeDir = '<?php echo get_template_directory_uri(); ?>';
                var colorsJsonPath = themeDir + '/inc/config/colors.json';
            </script>
            <?php
        }


        add_action('customize_preview_init', 'customizerPreviewEnqueue');
        function customizerPreviewEnqueue()
        {
            wp_enqueue_script('customizer-colors', get_template_directory_uri() . '/assets/js/customizer.js', ['customize-preview', 'jquery'], '1.0', true);
            wp_localize_script(
                'customizer-colors',
                'customizerData',
                array(
                    'colors' => get_field('system', 'options')['colors'],
                )
            );
        }


    }

    public static function getMenu($slugMenu)
    {
        require_once('structureMenu.php');
        $oMainMenu = new StructureMenu($slugMenu);
        return $oMainMenu->getItemsStructureMenu();
    }

    private static function addCustomizerSettings()
    {
        add_action('customize_register', 'addColorSettings');
        function addColorSettings()
        {

            $colors = get_field('system', 'options')['colors'];
            global $wp_customize;

            $wp_customize->add_section(
                'site_colors',
                array(
                    'title' => 'Цвета сайта',
                    'priority' => 30,
                )
            );

            if (!empty($colors)) {
                foreach ($colors as $color) {

                    $wp_customize->add_setting(
                        $color['key'],
                        array(
                            'default' => $color['value'],
                            'transport' => 'postMessage',
                            'sanitize_callback' => 'sanitize_hex_color',
                        )
                    );

                    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $color['key'], [
                        'label' => $color['title'],
                        'section' => 'site_colors',
                        'settings' => $color['key'],
                    ]));
                }
            }
        }
    }

    private static function enableWebp()
    {
        function webp_upload_mimes($existing_mimes)
        {
            $existing_mimes['webp'] = 'image/webp';
            return $existing_mimes;
        }
        add_filter('mime_types', 'webp_upload_mimes');
    }

    public static function returnColor($color)
    {

        $colors = get_field('system', 'options')['colors'];

        foreach ($colors as $colorItem) {
            if ($color === $colorItem['key']) {
                $returnColor = get_theme_mod($colorItem['key'], $colorItem['value']);
                break;
            } else {
                $returnColor = $colorItem['value'];
            }
        }

        return $returnColor;
    }

    public static function hexToRgb($hex, $alpha = false)
    {
        $rgb = sscanf($hex, "#%02x%02x%02x");
        return $rgb;
    }

    public static function rgbToArray($rgb)
    {
        $rgb = str_replace(["rgba(", ")"], "", $rgb);
        $rgb = str_replace(["rgb(", ")"], "", $rgb);
        return explode(", ", $rgb);
    }

    public static function rgbaToHex($rgbaColor)
    {
        preg_match('/rgba\((\d+), (\d+), (\d+), ([\d.]+)\)/', $rgbaColor, $matches);

        if (count($matches) !== 5) {
            return false;
        }

        $red = intval($matches[1]);
        $green = intval($matches[2]);
        $blue = intval($matches[3]);
        $alpha = floatval($matches[4]);

        if ($red < 0 || $red > 255 || $green < 0 || $green > 255 || $blue < 0 || $blue > 255 || $alpha < 0 || $alpha > 1) {
            return false;
        }

        $hexRed = str_pad(dechex($red), 2, '0', STR_PAD_LEFT);
        $hexGreen = str_pad(dechex($green), 2, '0', STR_PAD_LEFT);
        $hexBlue = str_pad(dechex($blue), 2, '0', STR_PAD_LEFT);

        return '#' . $hexRed . $hexGreen . $hexBlue;
    }

    public static function formConstruct($atts)
    {
        $atts = shortcode_atts([
            'id' => 1
        ], $atts);


        if (!is_numeric($atts['id'])) {
            return '<p class="msg error">Неправильно указан ID формы</p>';
        } else {
            $formID = ['id' => ($atts['id'] - 1)];
            ob_start();
            get_template_part('template-parts/items/form', null, $formID);
            return ob_get_clean();

        }
    }

    public static function constructTitle($titleArray)
    {
        $el = $titleArray['title']['element'];
        $title = $titleArray['title']['title'];
        $class = null;
        if ($titleArray['title']['class'] != null) {
            $class = $titleArray['title']['class'];
            $class = "class='{$class}'";
        }
        return "<{$el} {$class}>{$title}</{$el}>";
    }

}

?>