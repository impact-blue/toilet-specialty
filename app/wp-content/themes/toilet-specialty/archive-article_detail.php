<?php
global $paged;
get_header();

$term_list = get_item_tags();
$terms = get_the_terms($post->ID, 'item');
$page_id = get_page_by_path('article')->ID;
?>
  <main>
    <section id="post-list" class="article">
      <h1 class="heading">トイレトラブル解消系記事一覧</h1>
      <div class="container">
      <?php if ($term_list) { ?>
        <div class="tags">
          <h2 class="tags-ttl">タグから記事を探す</h2>
          <ul class="tags-list">
          <?php foreach ($term_list as $term_parent => $term_children) { ?>
            <?php 
            $counter = 0; 
            foreach ($term_children as $child) { 
              $counter++;
              if ($counter <= 4) {
            ?>
              <li class="tags-item"><a href="<?= $child['term_link'] ?>"><?= $child['term_name'] ?></a></li>
            <?php 
              }
            } 
            ?>
          <?php } ?>
          </ul>
          <div class="tags-btn">もっと見る</div>
          <ul class="tags-list">
          <?php foreach ($term_list as $term_parent => $term_children) { ?>
            <?php 
            $counter = 0; 
            foreach ($term_children as $child) { 
              $counter++;
              if ($counter > 4) {
            ?>
              <li class="tags-item"><a href="<?= $child['term_link'] ?>"><?= $child['term_name'] ?></a></li>
            <?php 
              }
            } 
            ?>
          <?php } ?>
          </ul>
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
              <p class="description">
                <?php the_excerpt() ?>
              </p>
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
