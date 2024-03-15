  <?php
  if (is_singular(['item_detail', 'article_detail'])) {
    $related_tags = get_item_and_article_related_tags(get_the_ID());

    // '親タクソノミーと子の関係にあるタクソノミーを全て取得
    $term_children_ids = $related_tags['term_children_ids'];

    $current_tag_id = $related_tags['current_term_id'];

    if ($term_children_ids) {
      echo '<div class="related-tags">';
      echo '<div class="related-tag-heading">関連タグ：</div>';
  ?>
      <?php
      foreach ($term_children_ids as $term_id) {
        $term = get_term_by('id', $term_id, 'item');

        // 記事に紐づくタクソノミーと同じタクソノミーの場合は処理を中断
        if ($term_id === $current_tag_id) continue;
      ?>
        <div class="tags">
          <a href="<?= get_term_link($term_id) ?>"><?= $term->name ?></a>
        </div>
          <?php
      }
      echo '</div>';
    }
  }
  ?>