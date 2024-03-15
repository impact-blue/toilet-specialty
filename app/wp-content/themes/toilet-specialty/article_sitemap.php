<?php
  header('Content-Type: text/xml; charset=' . get_option('blog_charset'), true );
  echo '<?xml version="1.0" encoding="' . get_option('blog_charset') . '"?>' . "\n";
  $article_page_id = get_page_by_path('article')->ID;

  $args = array(
    'posts_per_page' => -1,
    'orderby' => 'modified',
    'post_type' => 'article_detail',
    'order' => 'DESC',
  );
  $article_posts = get_posts($args);
  ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<url>
  <loc><?php echo get_the_permalink($article_page_id); ?></loc>
  <lastmod><?php echo get_the_modified_date('Y-m-d', $article_page_id); ?></lastmod>
</url>
<?php foreach ($article_posts as $article_post) { ?>
<url>
  <loc><?php echo get_the_permalink($article_post->ID); ?></loc>
  <lastmod><?php echo get_the_modified_date('Y-m-d', $article_post->ID); ?></lastmod>
</url>
<?php }; ?>
</urlset>