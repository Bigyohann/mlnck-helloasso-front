# MLNCK HelloAsso WordPress Plugin

This plugin loads the compiled React frontend for MLNCK HelloAsso into any WordPress page or post.

## Installation

1.  Zip the `mlnck-helloasso-plugin` directory.
2.  In WordPress, go to **Plugins > Add New > Upload Plugin**.
3.  Upload the zip file and activate it.

## Usage

Simply use the following shortcode in any page or post where you want the React application to appear:

`[mlnck_helloasso]`

## How it works

The plugin scans the `dist/assets` directory for `.js` and `.css` files and enqueues them when the shortcode is used. It also ensures the main script is loaded with `type="module"`, which is required for Vite/React applications.
