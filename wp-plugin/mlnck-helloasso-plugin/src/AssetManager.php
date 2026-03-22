<?php

declare(strict_types=1);

namespace MLNCK\HelloAsso;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class AssetManager
{
    private string $asset_dir;

    public function __construct(string $plugin_file, string $relative_path)
    {
        $this->asset_dir = \plugin_dir_path($plugin_file).$relative_path;
    }

    /**
     * @return array{js: list<string>, css: list<string>}
     */
    public function get_assets(): array
    {
        $filesystem = new Filesystem;

        if (! $filesystem->exists($this->asset_dir)) {
            return ['js' => [], 'css' => []];
        }

        try {
            $finder = (new Finder)
                ->files()
                ->in($this->asset_dir)
                ->depth(0)
                ->name(['*.js', '*.css']);
        } catch (\Symfony\Component\Finder\Exception\DirectoryNotFoundException $e) {
            return ['js' => [], 'css' => []];
        }

        return $this->process_finder_results($finder);
    }

    /**
     * @param Finder $finder
     * @return array{js: list<string>, css: list<string>}
     */
    private function process_finder_results(Finder $finder): array
    {
        $js_files = [];
        $css_files = [];

        foreach ($finder as $file) {
            $filename = $file->getFilename();
            if (\str_ends_with($filename, '.js')) {
                $js_files[] = $filename;
                continue;
            }

            if (\str_ends_with($filename, '.css')) {
                $css_files[] = $filename;
            }
        }

        return ['js' => $js_files, 'css' => $css_files];
    }
}
