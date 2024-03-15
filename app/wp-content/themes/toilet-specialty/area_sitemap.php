<?php
  header('Content-Type: text/xml; charset=' . get_option('blog_charset'), true );
  echo '<?xml version="1.0" encoding="' . get_option('blog_charset') . '"?>' . "\n";

  $args = array(
    'posts_per_page' => -1,
    'orderby' => 'modified',
    'post_type' => 'page',
    'order' => 'DESC',
    'meta_key'   => '_wp_page_template',
    'meta_value' => 'page-pref.php',
  );
  $area_posts = get_posts($args);
  ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($area_posts as $area_post) { ?>
<url>
  <loc><?php echo get_the_permalink($area_post->ID); ?></loc>
  <lastmod><?php echo get_the_modified_date('Y-m-d', $area_post->ID); ?></lastmod>
</url>
<?php }; ?>
</urlset>