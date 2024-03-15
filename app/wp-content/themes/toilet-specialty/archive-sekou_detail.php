<?php
global $paged;
get_header();
$terms = get_the_terms($post->ID, 'sekou');
?>
  <main>
    <section id="post-list" class="sekou">
      <h1 class="heading">施工事例一覧</h1>
      <div class="container">
        <?php
         get_template_part('template-parts/term-list'); ?>
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
                <time datetime="<?php the_time('Y-m-d') ?>" itemprop="datePublished"><?php the_time('Y年m月d日') ?></time>
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
