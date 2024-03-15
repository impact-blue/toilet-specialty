<?php
$sekou_date = get_field('sekou_date');
$sekou_area = get_field('sekou_area')->name;
$sekou_branch = get_field('sekou_branch');
$sekou_problem = get_field('sekou_problem');
$sekou_desc = get_field('sekou_desc');
$sekou_before_img = get_field('sekou_before_img');
$sekou_before_maker = get_field('sekou_before_maker');
$sekou_before_price = number_format(get_field('sekou_before_price'));
$sekou_before_year = get_field('sekou_before_year');
$sekou_after_img = get_field('sekou_after_img');
$sekou_after_maker = get_field('sekou_after_maker');
$sekou_after_price = number_format(get_field('sekou_after_price'));
$sekou_after_time = get_field('sekou_after_time');

// 該当エリアのリンクを取得
$post_id = get_the_ID();
$post_terms = get_the_terms($post_id, 'sekou');
$args = [
  'post_type' => 'area_detail',
  'post_status' => 'publish',
  'tax_query' => [
    'relation' => 'AND',
    [
      'taxonomy' => 'item',
      'field' => 'name',
      'terms' => $post_terms[0]->name,
    ],
    [
      'taxonomy' => 'area',
      'field' => 'slug',
      'terms' => $sekou_area,
    ]
  ]
];
$area_pages = get_posts($args);
?>
<div class="sekou-info">
  <h2 class="sekou-info-ttl">施工情報</h2>
  <div class="sekou-info-basic">
    <ul class="sekou-info-basic-upper">
      <li class="sekou-info-basic-upper-item">
        <p class="ttl">施工日</p>
        <p class="content"><?= $sekou_date ?></p>
      </li>
      <li class="sekou-info-basic-upper-item">
        <p class="ttl">エリア</p>
        <?php if(!empty($area_pages)) { ?>
        <a class="content" href="<?= get_permalink($area_pages[0]->ID) ?>"><?= $sekou_area ?></a>
        <?php } else { ?>
        <p class="content"><?= $sekou_area ?></p>
        <?php }?>
      </li>
      <li class="sekou-info-basic-upper-item">
        <p class="ttl">担当支社</p>
        <p class="content"><?= $sekou_branch ?></p>
      </li>
      <li class="sekou-info-basic-upper-item">
        <p class="ttl">症状</p>
        <p class="content"><?= $sekou_problem ?></p>
      </li>
    </ul>
    <p class="sekou-info-desc">
      <?= $sekou_desc ?>
    </p>
  </div>
  <div class="sekou-info-compare">
    <div class="sekou-info-compare-item before">
      <p class="sekou-info-compare-ttl">施工前</p>
      <img class="sekou-info-compare-img" src="<?= $sekou_before_img['url']?>" alt="<?= $sekou_before_img['alt']?>" />
      <ul class="sekou-info-compare-info">
        <?php
        if (!empty($sekou_before_maker) || !empty($sekou_after_maker)) {
        ?>
        <li class="sekou-info-compare-info-item">
          <p class="ttl">メーカー</p>
          <p class="content"><?= $sekou_before_maker ?></p>
        </li>
        <?php } ?>
        <?php
        if (!empty($sekou_before_price) || !empty($sekou_after_price)) {
        ?>
        <li class="sekou-info-compare-info-item">
          <p class="ttl">お見積り料金</p>
          <p class="content"><?= $sekou_before_price ?>円</p>
        </li>
        <?php } ?>
        <?php
        if (!empty($sekou_before_year) || !empty($sekou_after_time)) {
        ?>
        <li class="sekou-info-compare-info-item">
          <p class="ttl">使用年数</p>
          <p class="content"><?= $sekou_before_year ?></p>
        </li>
        <?php } ?>
      </ul>
    </div>
    <div class="arrow">
    </div>
    <div class="sekou-info-compare-item after">
      <p class="sekou-info-compare-ttl">施工後</p>
      <img class="sekou-info-compare-img" src="<?= $sekou_after_img['url']?>" alt="<?= $sekou_after_img['alt']?>" />
      <ul class="sekou-info-compare-info">
        <?php
        if (!empty($sekou_before_maker) || !empty($sekou_after_maker)) {
        ?>
        <li class="sekou-info-compare-info-item">
          <p class="ttl">メーカー</p>
          <p class="content"><?= $sekou_after_maker ?></p>
        </li>
        <?php } ?>
        <?php
        if (!empty($sekou_before_price) || !empty($sekou_after_price)) {
        ?>
        <li class="sekou-info-compare-info-item">
          <p class="ttl">施工料金</p>
          <p class="content"><?= $sekou_after_price ?>円</p>
        </li>
        <?php } ?>
        <?php
        if (!empty($sekou_before_year) || !empty($sekou_after_time)) {
        ?>
        <li class="sekou-info-compare-info-item">
          <p class="ttl">施工時間</p>
          <p class="content"><?= $sekou_after_time ?></p>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</div>