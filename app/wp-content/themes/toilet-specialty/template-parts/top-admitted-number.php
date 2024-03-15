<?php
  global $template_path;

  $city_list_has_admitted_number = get_posts([
    'posts_per_page' => -1,
    'post_type' => 'area_detail',
    'order' => 'ASC',
    'meta_query' => [
      [
        'key' => 'show_small_area',
        'value' => 0,
        'compare' => '=',
      ],
      [
        'key' => 'admitted_number',
        'value'   => '',
        'compare' => '!=',
      ],
    ],
  ]);

  $pref_list = [];
  $pref_str_pattern = '/(東京都|北海道|(?:京都|大阪)府|.{2,3}県)/u';

  foreach ($city_list_has_admitted_number as $city_page) {
    $city_id = $city_page->ID;
    $city_terms = get_the_terms($city_id, 'area');
    $city_term_name = $city_terms[0]->name;
    preg_match($pref_str_pattern, $city_term_name, $match);
    $pref_name = $match[0];

    if (!isset($pref_list[$pref_name]) ) {
      $pref_list[$pref_name] = [];
    }
    $pref_list[$pref_name][] = $city_page;
  }

  $region_list = [];
  foreach($pref_list as $pref_name => $city_page_list) {
    $pref_id = get_pref_id($pref_name);
    $region_field = get_field_object('area_select', $pref_id);
    $region_value = get_field('area_select',  $pref_id);
    $region_name = $region_field['choices'][$region_value];
    $replace_region_name = str_replace('地方', '', $region_name);

    if (!isset($region_list[$replace_region_name]) ) {
      $region_list[$replace_region_name] = [];
    }
    $region_list[$replace_region_name][$pref_name] = $city_page_list;
  }

  if (is_page_template('page-pref.php')) {
    $pref_class = '_pref';
    $pref_name = get_pref_name();
    $sub_pref_city_pages = get_city_pages($pref_name)['トイレ'];
  }
?>
<div class="top-admitted">
  <?php if (is_front_page()) { ?>
    <h2 class="top-admitted-ttl">水道修理ルート<br class="is-sp">（クリーンライフ）は、<br class="is-sp">各市町村から指定を受けた<br>指定給水装置工事事業者<br class="is-sp">(水道局指定工事店)です。</h2>
  <?php } ?>
  <div class="top-admitted-inner <?php if(is_page_template('page-pref.php')) echo $pref_class ?>">
    <div class="top-admitted-header <?php if(is_page_template('page-pref.php')) echo $pref_class ?>">
      <div class="top-admitted-pic <?php if(is_page_template('page-pref.php')) echo $pref_class ?>"><img src="<?= $template_path ?>/img/medal.webp" alt=""></div>
      <p class="top-admitted-txt <?php if(is_page_template('page-pref.php')) echo $pref_class ?>">水道局指定工事店は、必要な機材・資材を取り揃えていて、適切な工事と正しい事務手続きを行い、誠実な対応ができると保証されている事業者になります。トイレつまりなどあらゆる水まわりのトラブルに対応可能ですので、安心してご依頼ください。</p>
    </div>
    <?php if (is_front_page()) { ?>
      <ul class="top-admitted-area-list">
        <?php foreach($region_list as $region_name => $pref_page_list) { ?>
        <li class="top-admitted-area-item">
          <h3 class="top-admitted-head <?php if(is_page_template('page-pref.php')) echo $pref_class ?>"><span><?= $region_name ?></span>の指定給水装置工事事業者 指定番号</h3>
          <div class="top-admitted-body">
            <ul class="top-admitted-pref-list">
              <?php foreach($pref_page_list as $pref_name => $city_page_list) { ?>
              <li class="top-admitted-pref-item">
                <p class="top-admitted-subttl"><span><?= $pref_name ?></span>の指定給水装置工事事業者 指定番号</p>
                <ul class="top-admitted-small-list">
                  <?php foreach($city_page_list as $array_number => $city_post_objects) { ?>
                    <?php
                      $city_admitted_number_id = $city_post_objects->ID;
                      $city_admitted_number_terms = get_the_terms($city_admitted_number_id, 'area');
                      $city_admitted_number_term_name = $city_admitted_number_terms[0]->name;
                      $city_admitted_number_name = city_page_replacement_title($city_admitted_number_term_name);
                      $admitted_number = get_field('admitted_number', $city_admitted_number_id);
                    ?>
                    <li class="top-admitted-small-item">
                      <p class="top-admitted-small-box"><?= $city_admitted_number_name ?></p>
                      <p class="top-admitted-small-box">第<?= $admitted_number ?>号</p>
                    </li>
                  <?php } ?>
                </ul>
              </li>
              <?php } ?>
            </ul>
          </div>
        </li>
        <?php } ?>
      </ul>
    <?php } elseif(is_page_template('page-pref.php')) { ?>
      <ul class="top-admitted-area-list">
        <li class="top-admitted-area-item">
          <h3 class="top-admitted-head <?php if(is_page_template('page-pref.php')) echo $pref_class ?>"><span><?php if(is_page_template('page-pref.php')) echo $pref_name ?></span>の指定給水装置工事事業者 指定番号</h3>
          <div class="top-admitted-body">
            <ul class="top-admitted-pref-list">
              <li class="top-admitted-pref-item">
                <ul class="top-admitted-small-list">
                  <?php foreach($sub_pref_city_pages as $sub_pref_city_page) { ?>
                    <?php
                     $sub_pref_city_page_id = $sub_pref_city_page->ID;
                     $sub_pref_city_page_terms = get_the_terms($sub_pref_city_page_id, 'area');
                     $sub_pref_city_page_terms_name = $sub_pref_city_page_terms[0]->name;
                     $sub_pref_city_page_name = city_page_replacement_title($sub_pref_city_page_terms_name);
                     $sub_pref_admitted_number = get_field('admitted_number', $sub_pref_city_page_id);
                    ?>
                    <?php if($sub_pref_admitted_number) { ?>
                      <li class="top-admitted-small-item">
                        <p class="top-admitted-small-box"><?= $sub_pref_city_page_name ?></p>
                        <p class="top-admitted-small-box">第<?= $sub_pref_admitted_number ?>号</p>
                      </li>
                    <?php } ?>
                  <?php } ?>
                </ul>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    <?php } ?>
  </div>
</div>