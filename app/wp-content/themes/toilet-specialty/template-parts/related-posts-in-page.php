<?php
$terms = get_the_terms($post->ID, 'item');
if (is_page('toilet-repair')) {
  $tag_name = "トイレ";
  $post_per_page = 10;
} elseif (is_singular('area_detail')) {
  $tag_name = get_term_name(get_the_ID(), 'item');
  $post_per_page = 3;
}
$articles = get_item_and_article_related_posts($tag_name, $post_per_page);
if (have_posts()) {
?>
<section id="post-list" class="area">
  <div class="container">
    <div id="item-terms">
      <h2><?=$tag_name ?>トラブルに関する解消法・お役立ち情報</h2>
    </div>
    <?php
      while ($articles->have_posts()) {
        $articles->the_post();
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
        <h3 class="ttl"><a href="<?= esc_url(get_permalink()); ?>">
          <?php the_title(); ?>
        </a></h3>
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
    wp_reset_postdata();
    ?>
  </div>
  <p class="more">
    <a href="/item">もっとみる >></a>
  </p>
</section>
<?php }?>