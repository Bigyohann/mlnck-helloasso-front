<?php

declare(strict_types=1);

/**
 * WordPress Stubs for Mago
 */

namespace {
    /**
     * @param string $_tag
     * @param callable $_callback
     */
    function add_shortcode(string $_tag, callable $_callback): void {}

    /**
     * @param string $_tag
     * @param callable $_callback
     * @param int $_priority
     * @param int $_accepted_args
     */
    function add_action(string $_tag, callable $_callback, int $_priority = 10, int $_accepted_args = 1): void {}

    /**
     * @param string $_tag
     * @param callable $_callback
     * @param int $_priority
     * @param int $_accepted_args
     */
    function add_filter(string $_tag, callable $_callback, int $_priority = 10, int $_accepted_args = 1): void {}

    function plugin_dir_path(string $_file): string
    {
        return '';
    }

    function plugin_dir_url(string $_file): string
    {
        return '';
    }

    /**
     * @param string $_handle
     * @param string $_src
     * @param list<string> $_deps
     * @param string|bool|null $_ver
     * @param bool $_in_footer
     */
    function wp_register_script(
        string $_handle,
        string $_src,
        array $_deps = [],
        $_ver = false,
        bool $_in_footer = false,
    ): void {}

    /**
     * @param string $_handle
     * @param string $_src
     * @param list<string> $_deps
     * @param string|bool|null $_ver
     * @param string $_media
     */
    function wp_register_style(
        string $_handle,
        string $_src,
        array $_deps = [],
        $_ver = false,
        string $_media = 'all',
    ): void {}

    /**
     * @param string $_handle
     * @param string $_src
     * @param list<string> $_deps
     * @param string|bool|null $_ver
     * @param bool $_in_footer
     */
    function wp_enqueue_script(
        string $_handle,
        string $_src = '',
        array $_deps = [],
        $_ver = false,
        bool $_in_footer = false,
    ): void {}

    /**
     * @param string $_handle
     * @param string $_src
     * @param list<string> $_deps
     * @param string|bool|null $_ver
     * @param string $_media
     */
    function wp_enqueue_style(
        string $_handle,
        string $_src = '',
        array $_deps = [],
        $_ver = false,
        string $_media = 'all',
    ): void {}

    function esc_url(string $_url): string
    {
        return '';
    }

    function esc_attr(string $_text): string
    {
        return '';
    }
}
