<?php
  if(is_page_template('page-pref.php')) {
    $pref_name = esc_html(get_pref_name());
    $items = get_city_pages($pref_name);
  }

  $post_id = get_the_ID();
  $term_name = get_term_name($post_id, 'item');
?>

<div class="correspondence-area shortcode">
  <?php if(is_page_template('page-pref.php')) { ?>
    <h2 class="heading"><?= $pref_name ?>の対応エリア一覧</h2>
  <?php } elseif(is_singular('area_detail') && get_field('show_small_area')) { ?>
    <h2 class="heading">トイレ修理・水道修理対応エリア一覧</h2>
  <?php } ?>
  <div class="container">
    <?php get_template_part('template-parts/zip-code/pref-smallarea-search'); ?>
    <?php if(is_page_template('page-pref.php')) { ?>
    <?php
    foreach ($items as $item_name => $cities) {
      if($item_name == $term_name) {
      $heading_title = $pref_name . 'の' . $item_name . '修理';
      $cities_sortby_time_required = sort_city_pages_by_time_required($cities);
    ?>
    <div class="area-block">
      <h3 class="area-block-ttl pref">
        <?= $heading_title ?>
        <div class="area-block-icon">
          <div class="area-block-bar top"></div>
          <div class="area-block-bar low"></div>
        </div>
      </h3>
      <div class="area-block-content">
        <?php
        if (!empty($cities_sortby_time_required)) {
          foreach($cities_sortby_time_required as $time_required => $city_ids) {
            if(!empty($city_ids)) {
        ?>
        <p class="area-time-ttl">
          <?php if($time_required === 'その他対応エリア') { ?>
            <?= $time_required ?>
          <?php } else {?>
            出動時間目安：<span class="red"><?= $time_required ?></span>
          <?php } ?>
        </p>
        <ul class="areas">
        <?php
        foreach ($city_ids as $city_id) {
          $post_terms = get_the_terms($city_id, 'area');
          $pref_and_city_name = $post_terms[0]->name;
        ?>
          <li>
            <a class="area-link" href="<?= get_the_permalink($city_id) ?>">
              <?= city_page_replacement_title($pref_and_city_name) ?>
            </a>
          </li>
        <?php } ?>
        </ul>
        <?php
            }
          }
        } else { ?>
        <ul class="areas">
          <?php foreach($cities as $city){
            $city_id = $city->ID;
            $post_terms = get_the_terms($city_id, 'area');
            $pref_and_city_name = $post_terms[0]->name;
          ?>
          <li>
            <a class="area-link" href="<?= get_the_permalink($city_id) ?>">
              <?= city_page_replacement_title($pref_and_city_name) ?>
            </a>
          </li>
          <?php } ?>
        </ul>
        <?php } ?>
       </div>
      </div>
      <?php } ?>
    <?php } }?>
    <p class="center">対応エリアは順次拡大中でございます。<br>こちらに記載がないエリアでも対応可能なことが多いため、まずはお気軽にお電話ください。</p>
  </div>
</div>