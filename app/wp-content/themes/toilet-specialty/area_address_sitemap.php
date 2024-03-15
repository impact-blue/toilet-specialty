<?php
  header('Content-Type: text/xml; charset=' . get_option('blog_charset'), true );
  echo '<?xml version="1.0" encoding="' . get_option('blog_charset') . '"?>' . "\n";

  $args = array(
    'posts_per_page' => -1,
    'orderby' => 'modified',
    'post_type' => 'area_detail',
    'order' => 'DESC',
    'meta_key' => 'show_small_area',
    'meta_value' => true
  );
  $area_address_posts = get_posts($args);
  ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($area_address_posts as $area_address_post) { ?>
<url>
  <loc><?php echo get_the_permalink($area_address_post->ID); ?></loc>
  <lastmod><?php echo get_the_modified_date('Y-m-d', $area_address_post->ID); ?></lastmod>
</url>
<?php }; ?>
</urlset>