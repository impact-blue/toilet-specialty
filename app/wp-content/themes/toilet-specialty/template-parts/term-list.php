<?php
    $term_list = get_sekou_tags();
    $page_id = get_page_by_path('sekou')->ID;
?>
<?php if ($term_list) { ?>
  <div class="sekou-tags">
    <h2 class="sekou-tags-ttl">場所別の施工事例</h2>
    <ul class="sekou-tags-list">
    <?php foreach ($term_list as $term) { ?>
      <li class="sekou-tags-item">
        <a href="<?= get_term_link($term->term_id); ?>"><?= $term->name; ?></a>
      </li>
    <?php } ?>
    </ul>
  </div>
<?php } ?>