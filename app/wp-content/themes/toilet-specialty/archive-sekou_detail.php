<?php
global $paged;
get_header();

$terms = get_the_terms($post->ID, 'sekou');
$term_list = get_sekou_tags();
$page_id = get_page_by_path('sekou')->ID;
?>
  <main>
    <section id="post-list" class="sekou">
      <h1 class="heading">トイレトラブル解消系記事一覧</h1>
      <div class="sekou-tags">
        <h2 class="sekou-tags-ttl">タグから記事を探す</h2>
        <ul class="sekou-tags-list">
        <?php 
        $counter = 0; 
        foreach ($term_list as $term) { 
        ?>
          <li class="sekou-tags-item"><a href="<?= get_term_link($term->term_id); ?>"><?= $term->name; ?></a></li>
        <?php if ($counter >= 3) {break;} $counter++ ?>
        <?php } ?>
        </ul>
        <div class="sekou-tags-btn">もっと見る</div>
        <ul class="sekou-tags-list">
        <?php 
        $counter = 0;
        foreach ($term_list as $term) { 
          if ($counter >= 4) {
        ?>
          <li class="sekou-tags-item"><a href="<?= get_term_link($term->term_id); ?>"><?= $term->name; ?></a></li>
        <?php 
          }
          $counter++;
        } 
        ?>
        </ul>
      </div>
      <div class="container">
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
      <?php get_template_part('template-parts/new-cta');?>
    </section>
    <?php  ?>
  </main>
<?php get_footer(); ?>