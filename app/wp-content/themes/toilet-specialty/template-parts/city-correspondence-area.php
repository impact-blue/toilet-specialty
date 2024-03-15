<?php
// 市区町村内の対応エリア
$area_field = get_field('area_field');
$area_name = get_term_name(get_the_ID(), 'area');

$post_id = get_the_ID();
$post_terms = get_the_terms($post_id, 'area');
$city_name = city_page_replacement_title($area_name);
$item_slug = get_term_slug($post_id, 'item');
$item_name = get_item_name();
?>

<section class="correspondence-area city">
  <h2 class="heading"><?php echo $city_name .'の'. $item_name . '修理対応エリア'; ?></h2>
  <div class="container">
    <?php get_template_part('template-parts/zip-code/search'); ?>
    <?php if ($area_field && $area_name) { ?>
      <section class="area-block">
        <h3 class="area-block-ttl">
          <?= $area_name ?>の対応エリア例<br class="is-sp"><?php if(!empty($time_required)){?>（出動時間目安：<?= $time_required['label'] ?>）<?php }?>
        </h3>
        <div class="areas area-field"><?= $area_field ?></div>
      </section>
    <?php } ?>
  </div>
</section>