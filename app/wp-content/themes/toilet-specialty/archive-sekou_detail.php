<?php
global $paged;
get_header();

$terms = get_the_terms($post->ID, 'sekou');
$page_id = get_page_by_path('sekou')->ID;
?>
  <main>
    <section id="post-list" class="sekou">
      <h1 class="heading">施工事例一覧</h1>
      <div class="container">
      <?php get_template_part('template-parts/term-list'); ?>
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