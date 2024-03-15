<?php
$related_tags = get_item_and_article_related_tags(get_the_ID());
$parent_term_id = $related_tags['parent_term_id'];
$current_term_id = $related_tags['current_term_id'];

// 関連記事を取得
$current_term_name = get_term_by('id', $current_term_id, 'item')->name;
$query_instance = get_item_and_article_related_posts($current_term_name, 10);

if ($query_instance->have_posts()) {
$post_title = esc_html(get_the_title());
?>
  <div class="related-posts">
    <h2><?= $current_term_name ?>に関する合わせて読みたい記事</h2>
    <?php
    if ($query_instance->have_posts()) {
      while ($query_instance->have_posts()) {
        $query_instance->the_post();
    ?>
      <div class="related-post">
        <div class="left">
          <div class="left-img">
            <?php if (has_post_thumbnail()) { ?>
              <?= the_post_thumbnail(); ?>
            <?php } ?>
          </div>
        </div>
        <div class="right">
          <a class="post-title" href="<?php the_permalink(); ?>"><?= the_title() ?></a>
          <p class="is-pc description">
            <?php the_excerpt() ?>
          </p>
        </div>
      </div>
    <?php
      }
    }
    wp_reset_postdata(); ?>
  </div>
<?php
}
?>
