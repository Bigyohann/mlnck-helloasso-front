<?php

declare(strict_types=1);

namespace MLNCK\HelloAsso;

class MLNCKHelloAssoLoader
{
    private const ASSET_DIR = 'dist/assets/';

    private AssetManager $asset_manager;

    public function __construct(string $plugin_file)
    {
        $this->asset_manager = new AssetManager($plugin_file, self::ASSET_DIR);

        \add_shortcode('mlnck_helloasso', [$this, 'render_shortcode']);
        \add_action('wp_enqueue_scripts', [$this, 'register_assets']);
    }

    public function register_assets(): void
    {
        $assets = $this->asset_manager->get_assets();
        $asset_url = \plugin_dir_url(\dirname(__DIR__).'/mlnck-helloasso.php').self::ASSET_DIR;

        $this->register_js_assets($assets['js'], $asset_url);
        $this->register_css_assets($assets['css'], $asset_url);

        $this->add_module_type_to_scripts();
    }

    /**
     * @param list<string> $js_files
     */
    private function register_js_assets(array $js_files, string $asset_url): void
    {
        foreach ($js_files as $index => $file) {
            $handle = 'mlnck-helloasso-js-'.$index;
            \wp_register_script(
                $handle,
                $asset_url.$file,
                [],
                \MLNCK_HELLOASSO_VERSION,
                true,
            );
        }
    }

    /**
     * @param list<string> $css_files
     */
    private function register_css_assets(array $css_files, string $asset_url): void
    {
        foreach ($css_files as $index => $file) {
            $handle = 'mlnck-helloasso-css-'.$index;
            \wp_register_style(
                $handle,
                $asset_url.$file,
                [],
                \MLNCK_HELLOASSO_VERSION,
            );
        }
    }

    private function add_module_type_to_scripts(): void
    {
        // Add type="module" to ALL our scripts
        \add_filter(
            'script_loader_tag',
            static function ($tag, $handle, $src) {
                if (\str_starts_with((string) $handle, 'mlnck-helloasso-js-')) {
                    return (
                        '<script type="module" src="'
                        .\esc_url((string) $src)
                        .'" id="'
                        .\esc_attr((string) $handle)
                        .'-js"></script>'
                    );
                }

                return $tag;
            },
            10,
            3,
        );
    }

    public function render_shortcode(): string
    {
        $assets = $this->asset_manager->get_assets();

        foreach ($assets['js'] as $index => $file) {
            \wp_enqueue_script('mlnck-helloasso-js-'.$index);
        }

        foreach ($assets['css'] as $index => $file) {
            \wp_enqueue_style('mlnck-helloasso-css-'.$index);
        }

        return '<div id="mlnck_helloasso"></div>';
    }
}
