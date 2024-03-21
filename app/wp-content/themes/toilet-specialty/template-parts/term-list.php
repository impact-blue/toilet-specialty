<?php
  $term_list = get_sekou_tags();
?>
<div class="tags">
  <h2 class="tags-ttl">タグから記事を探す</h2>
  <ul class="tags-list">
  <?php 
  $counter = 0; 
  foreach ($term_list as $term) { 
    $counter++;
    if ($counter > 1 && $counter <= 5) {
  ?>
    <li class="tags-item"><a href="<?= get_term_link($term->term_id); ?>"><?= $term->name; ?></a></li>
  <?php 
    }
  }
  ?>
  </ul>
  <div class="tags-btn">もっと見る</div>
  <ul class="tags-list">
  <?php 
  $counter = 0;
  foreach ($term_list as $term) { 
    $counter++;
    if ($counter > 5) {
  ?>
    <li class="tags-item"><a href="<?= get_term_link($term->term_id); ?>"><?= $term->name; ?></a></li>
  <?php 
    }
  } 
  ?>
  </ul>
</div>