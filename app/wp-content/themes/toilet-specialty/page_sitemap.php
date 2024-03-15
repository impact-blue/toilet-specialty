<?php
  header('Content-Type: text/xml; charset=' . get_option('blog_charset'), true );
  echo '<?xml version="1.0" encoding="' . get_option('blog_charset') . '"?>' . "\n";
  $confirm_id = get_page_by_path('contact-confirm')->ID;
  $finished_id = get_page_by_path('contact-finished')->ID;
  $item_id = get_page_by_path('item')->ID;
  $area_id = get_page_by_path('area')->ID;

  $args = array(
    'posts_per_page' => -1,
    'orderby' => 'modified',
    'post_type' => 'page',
    'order' => 'DESC',
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-pref.php',
    'meta_compare' => '!=',
    'exclude' => array($confirm_id, $finished_id, $item_id, $area_id)
  );
  $page_posts = get_posts($args);
  ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($page_posts as $page_post) { ?>
<url>
  <loc><?php echo get_the_permalink($page_post->ID); ?></loc>
  <lastmod><?php echo get_the_modified_date('Y-m-d', $page_post->ID); ?></lastmod>
</url>
<?php }; ?>
</urlset>