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

use MLNCK\HelloAsso\MLNCKHelloAssoLoader;
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/bigyohann/mlnck_front_helloasso',
    __FILE__,
    'mlnck-helloasso-plugin',
);
if (method_exists($myUpdateChecker, 'setBranch')) {
    $myUpdateChecker->setBranch('main');
}

define('MLNCK_HELLOASSO_VERSION', '1.0.0');

new MLNCKHelloAssoLoader(__FILE__);
