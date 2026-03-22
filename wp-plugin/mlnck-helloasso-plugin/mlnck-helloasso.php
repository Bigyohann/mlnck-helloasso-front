<?php

declare(strict_types=1);

/**
 * Plugin Name: MLNCK HelloAsso React Loader
 * Description: Loads the compiled React frontend for MLNCK HelloAsso.
 * Version: 1.0.0
 * Author: bigyohann
 * Requires PHP: 8.1
 */

if (! defined('ABSPATH')) {
    exit();
}

if (file_exists(plugin_dir_path(__FILE__).'vendor/autoload.php')) {
    require_once plugin_dir_path(__FILE__).'vendor/autoload.php';
}

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/bigyohann/mlnck_front_helloasso',
    __FILE__,
    'mlnck-helloasso-plugin',
);
$myUpdateChecker->setBranch('main');

define('MLNCK_HELLOASSO_VERSION', '1.0.0');

class MLNCKHelloAssoLoader
{
    public function __construct()
    {
        add_shortcode('mlnck_helloasso', [$this, 'render_shortcode']);
        add_action('wp_enqueue_scripts', [$this, 'register_assets']);
    }

    private function get_assets(): array
    {
        $asset_dir = plugin_dir_path(__FILE__).'dist/assets/';
        $js_files = [];
        $css_files = [];
        $filesystem = new Filesystem;

        if ($filesystem->exists($asset_dir)) {
            $finder = new Finder;
            $finder->files()->in($asset_dir)->depth(0)->name(['*.js', '*.css']);

            foreach ($finder as $file) {
                $filename = $file->getFilename();
                match (true) {
                    str_ends_with($filename, '.js') => $js_files[] = $filename,
                    str_ends_with($filename, '.css') => $css_files[] = $filename,
                    default => null,
                };
            }
        }

        return ['js' => $js_files, 'css' => $css_files];
    }

    public function register_assets()
    {
        $assets = $this->get_assets();
        $asset_url = plugin_dir_url(__FILE__).'dist/assets/';

        foreach ($assets['js'] as $index => $file) {
            $handle = 'mlnck-helloasso-js-'.$index;
            wp_register_script(
                $handle,
                $asset_url.$file,
                [],
                MLNCK_HELLOASSO_VERSION,
                true,
            );
        }

        foreach ($assets['css'] as $index => $file) {
            $handle = 'mlnck-helloasso-css-'.$index;
            wp_register_style(
                $handle,
                $asset_url.$file,
                [],
                MLNCK_HELLOASSO_VERSION,
            );
        }

        // Add type="module" to ALL our scripts
        add_filter(
            'script_loader_tag',
            static function ($tag, $handle, $src) {
                if (str_starts_with($handle, 'mlnck-helloasso-js-')) {
                    return '<script type="module" src="'.esc_url($src).'" id="'.esc_attr($handle).'-js"></script>';
                }

                return $tag;
            },
            10,
            3,
        );
    }

    public function render_shortcode()
    {
        $assets = $this->get_assets();

        foreach ($assets['js'] as $index => $file) {
            wp_enqueue_script('mlnck-helloasso-js-'.$index);
        }

        foreach ($assets['css'] as $index => $file) {
            wp_enqueue_style('mlnck-helloasso-css-'.$index);
        }

        return '<div id="mlnck_helloasso"></div>';
    }
}

new MLNCKHelloAssoLoader;
