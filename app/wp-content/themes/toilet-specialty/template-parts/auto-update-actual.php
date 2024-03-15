<?php /*
  // 全国の加算件数
  // 前月分の件数を加算するので、1ヶ月ずらす必要あり。
  $number_of_add = [
    '01' => 3900, // 12月の実績
    '02' => 4800, // 1月の実績
    '03' => 4200, // 2月の実績
    '04' => 4300, // 3月の実績
    '05' => 4000, // 4月の実績
    '06' => 3400, // 5月の実績
    '07' => 3600, // 6月の実績
    '08' => 4100, // 7月の実績
    '09' => 4500, // 8月の実績
    '10' => 4600, // 9月の実績
    '11' => 3700, // 10月の実績
    '12' => 3800  // 11月の実績
  ];

  // 月ごとの値を初期化するための配列を作成
  $number_of_add_init = [
    '01' => 0,
    '02' => 0,
    '03' => 0,
    '04' => 0,
    '05' => 0,
    '06' => 0,
    '07' => 0,
    '08' => 0,
    '09' => 0,
    '10' => 0,
    '11' => 0,
    '12' => 0
  ];

  $number_of_add_toilet =
  $number_of_add_kitchen =
  $number_of_add_bath =
  $number_of_add_other =
  $number_of_add_init;

  // 月毎の加算件数を取得
  $month = date('m');

  // 年を取得
  $year = date('Y');

  // 4つのサービスの割合
  $service = [
    'toilet' => 0.4, // トイレの割合
    'kitchen' => 0.1, // 洗面所・キッチンの割合
    'bath' => 0.2, // 浴室の割合
    'other' => 0.3 // その他の割合
  ];

  $area_name = get_area_name();

  $area_population = get_field('area_population');
  $area_population_total = 0;

  if (is_singular('area_detail') && !get_field('show_small_area') || is_page_template('page-pref.php') || is_front_page()) {
    // 中エリアの投稿取得
    $args = [
      'posts_per_page' => -1,
      'post_type' => 'area_detail',
      'meta_key' => 'show_small_area',
      'meta_value' => 0,
      'meta_compare' => '='
    ];
  } elseif (is_singular('area_detail') && get_field('show_small_area')) {
    // 小エリアの投稿取得
    $args = [
      'posts_per_page' => -1,
      'post_type' => 'area_detail',
      'meta_key' => 'show_small_area',
      'meta_value' => true
    ];
  }

  $area_posts = get_posts($args);

  if(is_front_page() || is_page_template('page-pref.php') || get_field('area_population')) {
    // 中・小エリア全件の人口取得
    foreach ($area_posts as $area_post) {
      $area_population_all = get_field('area_population', $area_post->ID);
      $area_population_total += $area_population_all;
    }

    for ($i = 1; $i <= 12; $i++) {
      $month_key = sprintf('%02d', $i);
      // 4つのサービスの件数
      if(is_singular('area_detail')) {
        $number_of_add_toilet[$month_key] += round($area_population / $area_population_total * $number_of_add[$month_key] * $service['toilet']);
        $number_of_add_kitchen[$month_key] += round($area_population / $area_population_total * $number_of_add[$month_key] * $service['kitchen']);
        $number_of_add_bath[$month_key] += round($area_population / $area_population_total * $number_of_add[$month_key] * $service['bath']);
        $number_of_add_other[$month_key] += round($area_population / $area_population_total * $number_of_add[$month_key] * $service['other']);

      } elseif(is_page_template('page-pref.php')) {
        $cities = get_city_pages($area_name)['トイレ'];
        foreach($cities as $city) {
          // 中エリアそれぞれの人口取得
          $area_population = get_field('area_population', $city->ID);

          // 大エリア用の中エリア4つのサービスの件数
          $number_of_add_toilet[$month_key] += round($area_population / $area_population_total * $number_of_add[$month_key] * $service['toilet']);
          $number_of_add_kitchen[$month_key] += round($area_population / $area_population_total * $number_of_add[$month_key] * $service['kitchen']);
          $number_of_add_bath[$month_key] += round($area_population / $area_population_total * $number_of_add[$month_key] * $service['bath']);
          $number_of_add_other[$month_key] += round($area_population / $area_population_total * $number_of_add[$month_key] * $service['other']);
        }
      } elseif(is_front_page()) {
        foreach ($area_posts as $area_post) {
          // 中エリアそれぞれの人口取得
          $area_population = get_field('area_population', $area_post->ID);

          // トップページ用の中エリア4つのサービスの件数
          $number_of_add_toilet[$month_key] += round($area_population / $area_population_total * $number_of_add[$month_key] * $service['toilet']);
          $number_of_add_kitchen[$month_key] += round($area_population / $area_population_total * $number_of_add[$month_key] * $service['kitchen']);
          $number_of_add_bath[$month_key] += round($area_population / $area_population_total * $number_of_add[$month_key] * $service['bath']);
          $number_of_add_other[$month_key] += round($area_population / $area_population_total * $number_of_add[$month_key] * $service['other']);
        }
      }
    }

    // 現在の月までの合計を計算
    $toilet_calc = $kitchen_calc = $bath_calc = $other_calc = 0;

    for ($i = 1; $i <= $month; $i++) {
      $month_key = sprintf('%02d', $i);
      $toilet_calc += $number_of_add_toilet[$month_key];
      $kitchen_calc += $number_of_add_kitchen[$month_key];
      $bath_calc += $number_of_add_bath[$month_key];
      $other_calc += $number_of_add_other[$month_key];
    }

    if($month_key == '01') {
      $toilet_calc += array_sum($number_of_add_toilet);
      $kitchen_calc += array_sum($number_of_add_kitchen);
      $bath_calc += array_sum($number_of_add_bath);
      $other_calc += array_sum($number_of_add_other);
    }

    $toilet_total = $toilet_calc - $number_of_add_toilet['01'];
    $kitchen_total = $kitchen_calc - $number_of_add_kitchen['01'];
    $bath_total = $bath_calc - $number_of_add_bath['01'];
    $other_total = $other_calc - $number_of_add_other['01'];
  }
?>
<?php if(is_front_page() || is_page_template('page-pref.php') || get_field('area_population')) { ?>
<div class="actual">
  <div class="actual-inner">
    <?php if(is_front_page()) { ?>
      <h2 class="actual-ttl">水道修理ルートへの<br>依頼件数</h2>
    <?php } else { ?>
      <h2 class="actual-ttl"><?= $area_name ?>から水道修理ルートへの<br>依頼件数</h2>
    <?php } ?>
    <ul class="actual-list">
      <li class="actual-item">
        <p><?= $year ?>年の<?php if($month_key !== '01') echo '1月〜' ?><?= ltrim($month, '0') ?>月の水道修理依頼件数</p>
      </li>
      <li class="actual-item">
        <div class="actual-wrap">
          <div class="actual-img"><img src="<?php echo get_template_directory_uri() ?>/img/actual_toilet.png" alt=""></div>
          <p>トイレのトラブル件数</p>
        </div>
        <p><?= number_format($toilet_total) ?>件</p>
      </li>
      <li class="actual-item">
        <div class="actual-wrap">
          <div class="actual-img"><img src="<?php echo get_template_directory_uri() ?>/img/actual_kitchen.png" alt=""></div>
          <p>キッチンのトラブル件数</p>
        </div>
        <p><?= number_format($kitchen_total) ?>件</p>
      </li>
      <li class="actual-item">
        <div class="actual-wrap">
        <div class="actual-img"><img src="<?php echo get_template_directory_uri() ?>/img/actual_bath.png" alt=""></div>
          <p>お風呂のトラブル件数</p>
        </div>
        <p><?= number_format($bath_total) ?>件</p>
      </li>
      <li class="actual-item">
        <div class="actual-wrap">
        <div class="actual-img"><img src="<?php echo get_template_directory_uri() ?>/img/actual_other.png" alt=""></div>
          <p>その他のトラブル件数</p>
        </div>
        <p><?= number_format($other_total) ?>件</p>
      </li>
    </ul>
  </div>
</div>
<?php } */ ?>