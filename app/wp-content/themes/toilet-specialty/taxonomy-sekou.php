<?php
get_header();

// タグ名を取得
$sekou_tag_slug = get_query_var('sekou');
$taxonomy_name = get_term_by('slug', $sekou_tag_slug, 'sekou')->name;

// 該当タグ以外の記事を取得
$other_articles = get_sekou_other_articles($sekou_tag_slug);
?>
  <main>
    <section id="post-list" class="area">
      <h1 class="heading"><?= $taxonomy_name ?>の施工事例一覧</h1>
      <div class="container">
        <?php get_template_part('template-parts/term-list'); ?>
        <?php
        if (have_posts()) {
          while (have_posts()) { the_post();
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
            </div>
          </div>
        <?php
          }
        } else {
        ?>
          <p>記事が1件も登録されていません</p>
        <?php
        }
        ?>
        <div class="paginate">
          <?php archive_paginate(); ?>
        </div>
      </div>
      <?php get_template_part('template-parts/new-cta');?>
      <?php include('template-parts/post/sekou-other-articles.php');?>
    </section>
  </main>
<?php get_footer(); ?>
