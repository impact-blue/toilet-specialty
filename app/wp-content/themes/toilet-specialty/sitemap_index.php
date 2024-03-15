<?php
  header('Content-Type: text/xml; charset=' . get_option('blog_charset'), true );
  echo '<?xml version="1.0" encoding="' . get_option('blog_charset') . '"?>' . "\n";

  $confirm_id = get_page_by_path('contact-confirm')->ID;
  $finished_id = get_page_by_path('contact-finished')->ID;
  $front_page_id = get_option('page_on_front');

  // 固定ページの投稿情報
  $page_args = array(
    'posts_per_page' => 1,
    'orderby' => 'modified',
    'post_type' => 'page',
    'order' => 'DESC',
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-pref.php',
    'meta_compare' => '!=',
    'exclude' => array($confirm_id, $finished_id, $front_page_id)
  );
  $pages = get_posts($page_args);

  //大エリアページの投稿情報
  $area_args = array(
    'posts_per_page' => 1,
    'orderby' => 'modified',
    'post_type' => 'page',
    'order' => 'DESC',
    'meta_key'   => '_wp_page_template',
    'meta_value' => 'page-pref.php',
  );
  $areas = get_posts($area_args);

  // 水回りトラブルの投稿情報
  $item_args = array(
    'posts_per_page' => 1,
    'orderby' => 'modified',
    'post_type' => 'item_detail',
    'order' => 'DESC',
  );
  $items = get_posts($item_args);

  // その他の記事の投稿情報
  $article_args = array(
    'posts_per_page' => 1,
    'orderby' => 'modified',
    'post_type' => 'article_detail',
    'order' => 'DESC',
  );
  $articles = get_posts($article_args);

  // 施工事例一覧の投稿情報
  $sekou_args = array(
    'posts_per_page' => 1,
    'orderby' => 'modified',
    'post_type' => 'sekou_detail',
    'order' => 'DESC',
  );
  $sekous = get_posts($sekou_args);

  // 中エリアページの投稿情報
  $area_municipalitie_args = array(
    'posts_per_page' => 1,
    'orderby' => 'modified',
    'post_type' => 'area_detail',
    'order' => 'DESC',
    'meta_key' => 'show_small_area',
    'meta_value' => 0,
    'meta_compare' => '='
  );
  $area_municipalities = get_posts($area_municipalitie_args);

  // 小エリアページの投稿情報
  $area_address_args = array(
    'posts_per_page' => 1,
    'orderby' => 'modified',
    'post_type' => 'area_detail',
    'order' => 'DESC',
    'meta_key' => 'show_small_area',
    'meta_value' => true
  );
  $area_address = get_posts($area_address_args);
?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($pages as $pages_post) { ?>
  <sitemap>
    <loc><?= home_url('page-sitemap.xml') ?></loc>
    <lastmod><?php echo get_the_modified_date('Y-m-d', $pages_post->ID); ?></lastmod>
  </sitemap>
<?php }; ?>
<?php foreach ($areas as $areas_post) { ?>
  <sitemap>
    <loc><?= home_url('area-sitemap.xml') ?></loc>
    <lastmod><?php echo get_the_modified_date('Y-m-d', $areas_post->ID); ?></lastmod>
  </sitemap>
<?php }; ?>
<?php foreach ($items as $items_post) { ?>
  <sitemap>
    <loc><?= home_url('item-sitemap.xml') ?></loc>
    <lastmod><?php echo get_the_modified_date('Y-m-d', $items_post->ID); ?></lastmod>
  </sitemap>
<?php }; ?>
<?php foreach ($articles as $articles_post) { ?>
  <sitemap>
    <loc><?= home_url('article-sitemap.xml') ?></loc>
    <lastmod><?php echo get_the_modified_date('Y-m-d', $articles_post->ID); ?></lastmod>
  </sitemap>
<?php }; ?>
<?php foreach ($sekous as $sekous_post) { ?>
  <sitemap>
    <loc><?= home_url('sekou-sitemap.xml') ?></loc>
    <lastmod><?php echo get_the_modified_date('Y-m-d', $sekous_post->ID); ?></lastmod>
  </sitemap>
<?php }; ?>
<?php foreach ($area_municipalities as $area_municipalities_post) { ?>
  <sitemap>
    <loc><?= home_url('area-municipalities-sitemap.xml') ?></loc>
    <lastmod><?php echo get_the_modified_date('Y-m-d', $area_municipalities_post->ID); ?></lastmod>
  </sitemap>
<?php }; ?>
<?php foreach ($area_address as $area_address_post) { ?>
  <sitemap>
    <loc><?= home_url('area-address-sitemap.xml') ?></loc>
    <lastmod><?php echo get_the_modified_date('Y-m-d', $area_address_post->ID); ?></lastmod>
  </sitemap>
<?php }; ?>
</sitemapindex>