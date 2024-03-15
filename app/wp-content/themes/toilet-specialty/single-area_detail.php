<?php
get_header();

global $template_path;

$post_id = get_the_ID();
$area_taxonomy = get_term_slug($post_id, 'area');
$item_slug = get_term_slug($post_id, 'item');

// 対応エリア下部のテキストエリア
$footer_textarea = get_field('free_textarea');

// 出動時間
$time_required = get_time_required_by_city($post_id);

// 設定されているアイテムのタグと紐づく市区町村ページの一覧を取得
$pref_name = get_pref_name();
$item_name = get_term_name($post_id, 'item');
if($item_name) {
  $city_pages = get_city_pages($pref_name)[$item_name];
}
$is_toilet_item = $item_name === 'トイレ';
$the_title = preg_replace('/・/', '<span class="is-pc-inline">・</span><br class="is-sp">', get_the_title());

// 都道府県一覧取得
$pref_args = [
  'posts_per_page' => -1,
  'post_type' => 'page',
  'order' => 'ASC',
  'meta_key' => 'area_select',
  'orderby' => 'meta_value',
  'tax_query' => [
    [
      'taxonomy' => 'item',
      'field'    => 'slug',
      'terms'    => $item_slug
    ]
  ]
];

$pref_name_obj = get_prefname_obj($pref_args);

$is_city = $is_small_area = false;
$post_parent = get_post_parent();
if (is_null($post_parent)) {
  $is_city = true;
} else {
  $is_small_area = true;
}

if ($is_city) {
  $city_page_id = $post_id;

  $children_small_area_list = get_posts([
    'post_type' => 'area_detail',
    'posts_per_page' => -1,
    'post_parent' => $city_page_id,
  ]);
}

if ($is_small_area) {
  $post_parent = get_post_parent();
  $city_page_id = $post_parent->ID;

  $siblings_small_area_list = get_posts([
    'post_type' => 'area_detail',
    'posts_per_page' => -1,
    'post_parent' => $city_page_id,
    'exclude' => [$post_id],
  ]);
}

$parent_terms = get_the_terms($city_page_id, 'area');
$pref_and_city_name = $parent_terms[0]->name;
$city_name = city_page_replacement_title($pref_and_city_name);

if(is_singular('area_detail')) {
  if($item_slug == 'toilet') {
    $item_name = 'トイレつまり・水道修理';
  } elseif($item_slug == 'water-pipe') {
    $item_name = '水道管の水漏れ・つまり修理';
  } elseif($item_slug == 'bath') {
    $item_name = 'お風呂の蛇口交換・水漏れ修理';
  }
}

?>
  <main class="area-detail area">
    <?php get_template_part('template-parts/hero'); ?>
    <h1 class="top-ttl"><?= $the_title ?></h1>
    <?php
      get_template_part('template-parts/new', 'cta');
      if ($is_small_area) {
        get_template_part('template-parts/auto-update-actual');
      }
      get_template_part('template-parts/corona-measures');
      get_template_part('template-parts/service-ranking');
    ?>
    <div id="toc_area">
      <section class="post-content _area">
        <div id="toc_container">
          <p class="toc_title_area">目次<span class="toc_toggle">[非表示]</span></p>
        </div>
        <?php the_content(); ?>
        <?php
        if ($is_city) {
          get_template_part('template-parts/crown');
          get_template_part('template-parts/new', 'cta');
        }
        ?>
      </section>
      <?php
        get_template_part('template-parts/service-flow');
        if ($is_city) {
          get_template_part('template-parts/to-faq-and-customer-voice');
          get_template_part('template-parts/vendor-info');
          get_template_part('template-parts/profile');
        }
        get_template_part('template-parts/top', 'questions');
        if ($is_city) {
          get_template_part('template-parts/new', 'cta');
        }
        get_template_part('template-parts/correspondence-area-banner');
      ?>
      <section class="correspondence-area">
      <?php if ($is_city && !empty($children_small_area_list)) { ?>
        <div class="container">
          <div class="area-block _small-area">
          <h2 class="heading"><?= $city_name ?>の対応町村番地一覧</h2>
            <ul class="areas">
              <?php
              foreach ($children_small_area_list as $children_small_area_item) {
                $children_id = $children_small_area_item->ID;
              ?>
              <li>
              <a class="area-link" href="<?= get_the_permalink($children_id) ?>">
                  <?php the_field('small_area_page', $children_id); ?>
                </a>
              </li>
              <?php } ?>
            </ul>
          </div>
        </div>
      <?php } ?>
        <?php if ($is_small_area): ?>
          <h2 class="heading"><?php the_field('small_area_page'); ?>以外のトイレつまり・水道修理対応エリア一覧</h2>
        <?php else: ?>
          <h2 class="heading"><?= $city_name ?>以外の<?= $item_name ?>対応エリア一覧</h2>
        <?php endif; ?>
        <div class="container">
          <?php get_template_part('template-parts/zip-code/search'); ?>
            <?php if($is_small_area && !empty($siblings_small_area_list)) { ?>
              <div class="area-block">
                <h3 class="area-block-ttl"><?php the_field('small_area_page'); ?>以外の<?= $city_name ?>の対応エリア</h3>
                <ul class="areas">
                  <?php
                  foreach ($siblings_small_area_list as $siblings_small_area_item) {
                    $children_id = $siblings_small_area_item->ID;
                  ?>
                  <li>
                    <a class="area-link" href="<?= get_the_permalink($children_id) ?>">
                      <?php the_field('small_area_page', $children_id); ?>
                    </a>
                  </li>
                  <?php } ?>
                </ul>
              </div>
            <?php } ?>
            <?php if (isset($city_pages) && count($city_pages) > 1) { ?>
              <div class="area-block">
                <h3 class="area-block-ttl"><?= $city_name ?>以外の<?= $pref_name ?>の対応エリア</h3>
                <ul class="areas">
                  <?php
                  foreach ($city_pages as $city_page) {
                    $post_id = $city_page->ID;
                    $post_terms = get_the_terms($post_id, 'area');
                    $pref_and_city_name = $post_terms[0]->name;

                    if (city_page_replacement_title($pref_and_city_name) === $city_name) continue;
                  ?>
                  <li>
                    <a class="area-link" href="<?= get_the_permalink($post_id) ?>">
                      <?= city_page_replacement_title($pref_and_city_name) ?>
                    </a>
                  </li>
                  <?php } ?>
                </ul>
              </div>
            <?php } ?>
          <?php if ($pref_name_obj) { ?>
            <div class="mg-top">
            <?php foreach ($pref_name_obj as $area_name => $prefs) { ?>
              <div class="area-block">
                <h3 class="area-block-ttl"><?= $area_name . 'の水道修理対応エリア'?></h3>
                <ul class="areas">
                  <?php
                    foreach ($prefs as $pref) {
                    $pref_id = $pref->ID;
                    $pref_name = get_field('big_area_name', $pref_id);
                  ?>
                    <li>
                      <a class="area-modal-btn area-link" href="<?= get_the_permalink($pref->ID) ?>"><?= $pref_name ?></a>
                    </li>
                  <?php } ?>
                </ul>
              </div>
            <?php } ?>
            </div>
          <?php } ?>
        </div>
      </section>
      <?php
       if ($is_city) {
         get_template_part('template-parts/related-posts-in-page');
       }
      ?>
    </div>
    <?php if ($footer_textarea) { ?>
      <div class="post-content">
        <?= $footer_textarea ?>
      </div>
    <?php } ?>
  </main>
<?php get_footer(); ?>
