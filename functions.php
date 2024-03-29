<?php

// Theme init

if (!function_exists('zenfse_barbone_setup')) {
  function zenfse_barbone_setup()
  {
    // Enable support for post thumbnails and featured images.
    add_theme_support('post-thumbnails');

    // Add support for custom navigation menus.

    register_nav_menus(array(
      'desktop-menu'   => __('Desktop Menù', 'zenfse_barbone'),
      'mobile-menu'   => __('Mobile Menù', 'zenfse_barbone'),

    ));

    // Add support for the following post formats: aside, gallery, quote, image, and video

    add_theme_support('post-formats', array('aside', 'gallery', 'quote', 'image', 'video'));
  }
}
add_action('after_setup_theme', 'zenfse_barbone_setup');

// Enqueue scripts

function zenfse_barbone_enqueue_script()
{
  wp_enqueue_script('zenfse_barbone-script', get_stylesheet_directory_uri() . '/dist/site.js', array(), filemtime(get_stylesheet_directory() . '/dist/site.js'), true);
}
add_action('wp_enqueue_scripts', 'zenfse_barbone_enqueue_script');

// Enqueue styles

function zenfse_barbone_enqueue_style()
{
  wp_enqueue_style('zenfse_barbone-style', get_stylesheet_directory_uri() . '/style.css', array(), filemtime(get_stylesheet_directory() . '/style.css'), false);
}
add_action('wp_enqueue_scripts', 'zenfse_barbone_enqueue_style');

// Dashboard style

function zenfse_barbone_admin_styles()
{
  wp_enqueue_style('zenfse_barbone-admin-style', get_template_directory_uri() . '/dist/dashboard-style.css');
}
add_action('admin_enqueue_scripts', 'zenfse_barbone_admin_styles');


// Preload fonts 

function zenfse_barbone_preload_fonts()
{
  echo '<link rel="preload" href="' . get_template_directory_uri() . '/src/assets/fonts/Roboto-Regular.woff2" as="font" type="font/woff2" crossorigin>';
  echo '<link rel="preload" href="' . get_template_directory_uri() . '/src/assets/fonts/Roboto-Bold.woff2" as="font" type="font/woff2" crossorigin>';
  echo '<link rel="preload" href="' . get_template_directory_uri() . '/src/assets/fonts/Roboto-Light.woff2" as="font" type="font/woff2" crossorigin>';
}
add_action('wp_head', 'zenfse_barbone_preload_fonts');


// Add support for SVG files in the media library

function zenfse_barbone_mime_types($mimes)
{
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'zenfse_barbone_mime_types');

function zenfse_barbone_check_svg($file)
{
  if ($file['type'] === 'image/svg+xml') {
    $svg_content = file_get_contents($file['tmp_name']);
    // Check the SVG file content and reject the file if it's not safe
    if (!zenfse_barbone_is_safe_svg($svg_content)) {
      $file['error'] = 'This SVG file is not safe to upload';
    }
  }
  return $file;
}
add_filter('wp_handle_upload_prefilter', 'zenfse_barbone_check_svg');

function zenfse_barbone_is_safe_svg($svg_content)
{
  if (strpos($svg_content, '<script>') !== false) {
    return false;
  }
  return true;
}

// Render SVG as code

function zenfse_barbone_render_svg($block_content, $block)
{
  if ($block['blockName'] === 'core/image' && isset($block['attrs']['id'])) {
    $attachment_id = $block['attrs']['id'];
    if (get_post_mime_type($attachment_id) == 'image/svg+xml') {
      $file = get_attached_file($attachment_id);
      $svg_content = file_get_contents($file);
      $block_content = preg_replace('/<img[^>]+>/i', $svg_content, $block_content);
    }
  }

  return $block_content;
}
add_filter('render_block', 'zenfse_barbone_render_svg', 10, 2);



/* Filter core blocks */

// Add script to filer core/blocks

function zenfse_barbone_core_blocks_scripts()
{

  // core/image dimension

  wp_register_script(
    'zenfse_barbone-core-blocks-image',
    get_stylesheet_directory_uri() . '/blocks/build-core-blocks/image-dimension.js',
    array('wp-blocks'),
    filemtime(get_stylesheet_directory() . '/blocks/build-core-blocks/image-dimension.js'),
    true
  );
  wp_enqueue_script('zenfse_barbone-core-blocks-image');
}

add_action('enqueue_block_editor_assets', 'zenfse_barbone_core_blocks_scripts');



// Frontend enqueue core/image dimension

function zenfse_barbone_enqueue_frontend_core_image()
{
  if (!is_admin()) {
    $id = get_the_ID();
    if (has_block('core/image', $id)) {
      wp_enqueue_script('zenfse_barbone-core-blocks-image-frontend', get_stylesheet_directory_uri() . '/blocks/build-core-blocks/image-dimension-frontend.js', array(), filemtime(get_stylesheet_directory() . '/blocks/build-core-blocks/image-dimension-frontend.js'), true);
      wp_enqueue_style('zenfse_barbone-core-blocks-image-frontend-style', get_stylesheet_directory_uri() . '/blocks/build-core-styles/image-dimension-frontend-style.css', array(), filemtime(get_stylesheet_directory() . '/blocks/build-core-styles/image-dimension-frontend-style.css'));
    }
  }
}

add_action('wp_enqueue_scripts', 'zenfse_barbone_enqueue_frontend_core_image');


// Backend enqueue core/image dimension

function enqueue_backend_core_image()
{
  wp_enqueue_style('zenfse_barbone-core-blocks-image-backend-style', get_stylesheet_directory_uri() . '/blocks/build-core-styles/image-dimension-backend-style.css', array(), filemtime(get_stylesheet_directory() . '/blocks/build-core-styles/image-dimension-backend-style.css'));
}
add_action('admin_enqueue_scripts', 'enqueue_backend_core_image');



/* Custon blocks */

// Register custom blocks

include_once get_template_directory() . '/blocks/custom-blocks/navigation/callback.php';

function zenfse_barbone_register_blocks()
{

  add_filter('block_categories_all', 'zenfse_barbone_blocks_categories');
  function zenfse_barbone_blocks_categories($categories)
  {
    array_unshift($categories, array(
      'slug'  => 'zenfse_barbone-blocks',
      'title' => 'ZenFSE Blocks'
    ));
    return $categories;
  };


  $blocks = array(
    'navigation' => 'zenfse_barbone_render_navigation_block',
    'gallery' => '',
    'gallery-con-titolo' => '',
    'footer' => '',
  );

  foreach ($blocks as $dir => $render_callback) {
    $args = array();
    if (!empty($render_callback)) {
      $args['render_callback'] = $render_callback;
    }
    register_block_type(__DIR__ . '/blocks/build-custom-blocks/' . $dir, $args);
  }
}
add_action('init', 'zenfse_barbone_register_blocks');
