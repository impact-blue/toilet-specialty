<?php
get_header();

$related_tag = get_the_terms(get_the_ID(), 'sekou')[0];
$other_articles = get_sekou_other_articles($related_tag->slug);
?>
  <main id="single-detail" class="sekou_detail">
    <h1 class="item-title">
      <img src="<?= $template_path ?>/img/men-title.png" width="260" height="192" alt="男性">
      <span><?php the_title() ?></span>
    </h1>
    <section class="post-content">
      <?php
      get_template_part('template-parts/post/sekou-info');
      the_content();
      ?>
      <p class="simple-link">
        <a href="<?= get_term_link($related_tag->term_id)?>"><?= $related_tag->name?>の施工事例一覧へ >></a>
      </p>
    </section>
    <?php include ('template-parts/post/sekou-other-articles.php'); ?>
  </main>
<?php get_footer(); ?>
