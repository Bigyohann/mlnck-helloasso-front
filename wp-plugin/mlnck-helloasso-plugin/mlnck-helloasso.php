<?php
/**
 * Plugin Name: MLNCK HelloAsso React Loader
 * Description: Loads the compiled React frontend for MLNCK HelloAsso.
 * Version: 1.0.0
 * Author: bigyohann
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'vendor/plugin-update-checker-5.6/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/bigyohann/mlnck_front_helloasso/',
    __FILE__,
    'mlnck-helloasso-plugin'
);

define('MLNCK_HELLOASSO_VERSION', '1.0.0');

class MLNCK_HelloAsso_Loader {

    public function __construct() {
        add_shortcode('mlnck_helloasso', [$this, 'render_shortcode']);
        add_action('wp_enqueue_scripts', [$this, 'register_assets']);
    }

    private function get_assets() {
        $asset_dir = plugin_dir_path(__FILE__) . 'dist/assets/';
        $js_files = [];
        $css_files = [];

        if (is_dir($asset_dir)) {
            $files = scandir($asset_dir);
            foreach ($files as $file) {
                if (preg_match('/\.js$/', $file)) {
                    $js_files[] = $file;
                } elseif (preg_match('/\.css$/', $file)) {
                    $css_files[] = $file;
                }
            }
        }

        return ['js' => $js_files, 'css' => $css_files];
    }

    public function register_assets() {
        $assets = $this->get_assets();
        $asset_url = plugin_dir_url(__FILE__) . 'dist/assets/';

        foreach ($assets['js'] as $index => $file) {
            $handle = 'mlnck-helloasso-js-' . $index;
            wp_register_script(
                $handle,
                $asset_url . $file,
                [],
                MLNCK_HELLOASSO_VERSION,
                true
            );
        }

        foreach ($assets['css'] as $index => $file) {
            $handle = 'mlnck-helloasso-css-' . $index;
            wp_register_style(
                $handle,
                $asset_url . $file,
                [],
                MLNCK_HELLOASSO_VERSION
            );
        }

        // Add type="module" to ALL our scripts
        add_filter('script_loader_tag', function($tag, $handle, $src) {
            if (strpos($handle, 'mlnck-helloasso-js-') === 0) {
                return '<script type="module" src="' . esc_url($src) . '" id="' . esc_attr($handle) . '-js"></script>';
            }
            return $tag;
        }, 10, 3);
    }

    public function render_shortcode() {
        $assets = $this->get_assets();
        
        foreach ($assets['js'] as $index => $file) {
            wp_enqueue_script('mlnck-helloasso-js-' . $index);
        }
        
        foreach ($assets['css'] as $index => $file) {
            wp_enqueue_style('mlnck-helloasso-css-' . $index);
        }

        return '<div id="mlnck_helloasso"></div>';
    }
}

new MLNCK_HelloAsso_Loader();
