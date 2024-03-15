<?php
  header('Content-Type: text/xml; charset=' . get_option('blog_charset'), true );
  echo '<?xml version="1.0" encoding="' . get_option('blog_charset') . '"?>' . "\n";
  $sekou_page_id = get_page_by_path('sekou')->ID;

  $sekou_terms = get_sekou_tags();

  $args = array(
    'posts_per_page' => -1,
    'orderby' => 'modified',
    'post_type' => 'sekou_detail',
    'order' => 'DESC',
  );
  $sekou_posts = get_posts($args);
  ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<url>
  <loc><?php echo get_the_permalink($sekou_page_id); ?></loc>
  <lastmod><?php echo get_the_modified_date('Y-m-d', $sekou_page_id); ?></lastmod>
</url>
<?php foreach ($sekou_terms as $sekou_term) { ?>
<url>
  <loc><?= get_term_link($sekou_term->term_id); ?></loc>
  <lastmod><?php echo get_the_modified_date('Y-m-d', $sekou_term->term_id); ?></lastmod>
</url>
<?php }; ?>
<?php foreach ($sekou_posts as $sekou_post) { ?>
<url>
  <loc><?php echo get_the_permalink($sekou_post->ID); ?></loc>
  <lastmod><?php echo get_the_modified_date('Y-m-d', $sekou_post->ID); ?></lastmod>
</url>
<?php }; ?>
</urlset>