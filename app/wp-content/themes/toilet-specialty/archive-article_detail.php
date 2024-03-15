<?php
global $paged;
get_header();

$term_list = get_item_tags();
$page_id = get_page_by_path('article')->ID;
$terms = get_the_terms($post->ID, 'item');
?>
  <main>
    <section id="post-list" class="article">
      <h1 class="heading"><?= esc_html(get_the_title($page_id)); $paged > 1 ? print(" {$paged}ページ目") : "" ?></h1>
      <div class="container">
        <?php if ($term_list) { ?>
          <div id="item-terms">
            <h2>タグ一覧から記事をさがす</h2>
            <div class="tags-description-wrapper">
              <p class="tags-description">水道修理ルート　記事タグ一覧</p>
            </div>
            <div class="tags-wrapper">
              <?php foreach ($term_list as $parent_term_name => $term_children) { ?>
                <h3><?= $parent_term_name ?></h3>
                <ul class="tags item-tags">
                  <?php foreach ($term_children as $child) { ?>
                    <li>
                      <a href="<?= $child['term_link'] ?>"><?= $child['term_name'] ?></a>
                    </li>
                  <?php } ?>
                </ul>
              <?php } ?>
            </div>
          </div>
        <?php } ?>
        <?php
        if (have_posts()) {
          while (have_posts()) {
            the_post();
        ?>
          <div class="post-item">
            <div class="item-left">
              <div class="item-left-img">
                <?php if (has_post_thumbnail()) { ?>
                  <?= the_post_thumbnail(); ?>
                <?php } ?>
              </div>
            </div>
            <div class="item-right">
              <h2 class="ttl"><a href="<?= esc_url(get_permalink()); ?>">
                <?php the_title(); ?>
              </a></h2>
              <p class="description">
                <?php the_excerpt() ?>
              </p>
              <div class="date-area">
                <time datetime="<?php the_modified_time('Y-m-d') ?>" itemprop="datePublished"><?php the_modified_time('Y年m月d日') ?></time>
              </div>
              <div class="archive-taxonomy-wrap">
                <?php
                  if($terms) {
                    foreach($terms as $term) {
                    $term_link = get_term_link($term);
                    $term_name = $term->name;
                ?>
                  <div class="archive-taxonomy"><a href="<?= $term_link ?>"><?= $term_name ?></a></div>
                <?php }} ?>
              </div>
            </div>
          </div>
        <?php
          }
        }
        ?>
        <div class="paginate">
          <?php archive_paginate(); ?>
        </div>
      </div>
    </section>
  </main>
<?php get_footer(); ?>
