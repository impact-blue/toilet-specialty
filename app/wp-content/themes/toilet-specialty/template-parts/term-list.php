<?php
  $term_list = get_sekou_tags();
?>
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