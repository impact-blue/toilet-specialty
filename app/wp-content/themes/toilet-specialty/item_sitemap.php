<?php
  header('Content-Type: text/xml; charset=' . get_option('blog_charset'), true );
  echo '<?xml version="1.0" encoding="' . get_option('blog_charset') . '"?>' . "\n";

  $item_page_id = get_page_by_path('item')->ID;

  $args = array(
    'posts_per_page' => -1,
    'orderby' => 'modified',
    'post_type' => 'item_detail',
    'order' => 'DESC',
  );
  $item_posts = get_posts($args);
  ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<url>
  <loc><?php echo get_the_permalink($item_page_id); ?></loc>
  <lastmod><?php echo get_the_modified_date('Y-m-d', $item_page_id); ?></lastmod>
</url>
<?php foreach ($item_posts as $item_post) { ?>
<url>
  <loc><?php echo get_the_permalink($item_post->ID); ?></loc>
  <lastmod><?php echo get_the_modified_date('Y-m-d', $item_post->ID); ?></lastmod>
</url>
<?php }; ?>
</urlset>