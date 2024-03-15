<?php
/*
Template Name: 都道府県ページ
*/
get_header();

$pref_name = esc_html(get_pref_name());

// 都道府県ページに紐付けたい市区町ページを取得
$items = get_city_pages($pref_name);

// 拠点情報を取得
$base_name = get_field('base_name');
$base_tel = get_field('base_tel');
$base_address = get_field('base_address');
$base_time = get_field('base_time');
$post_content = get_the_content();

$post_id = get_the_ID();
$term_name = get_term_name($post_id, 'item');
?>
  <main class="area">
    <?php
    get_template_part('template-parts/hero');
    ?>
    <h1 class="top-ttl"><?php the_title(); ?></h1>
    <?php
    get_template_part('template-parts/new', 'cta');
    get_template_part('template-parts/corona-measures');
    get_template_part('template-parts/caution');
    get_template_part('template-parts/service-ranking');
    ?>
  <?php if(!empty($post_content)){?>
    <div id="toc_area">
      <div class="post-content">
        <div class="container">
          <div id="toc_container">
            <p class="toc_title_area">目次<span class="toc_toggle">[非表示]</span></p>
          </div>
          <?php the_content(); ?>
        </div>
      </div>
      <?php
      }
        get_template_part('template-parts/service-flow');
        get_template_part('template-parts/to-faq-and-customer-voice');
        get_template_part('template-parts/correspondence-area-banner');
        get_template_part('template-parts/top', 'questions');
      ?>
      <?php if ($items) { ?>
        <div class="correspondence-area">
          <h2 class="heading"><?= $pref_name ?>の対応エリア一覧</h2>
          <div class="container">
            <?php get_template_part('template-parts/zip-code/search'); ?>
            <?php
            foreach ($items as $item_name => $cities) {
              if($item_name == $term_name) {
              $heading_title = $pref_name . 'の' . $item_name . '修理';
              $cities_sortby_time_required = sort_city_pages_by_time_required($cities);
            ?>
            <div class="area-block">
              <h3 class="area-block-ttl"><?= $heading_title ?></h3>
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
            <?php }} ?>
            <p class="center">対応エリアは順次拡大中でございます。<br>こちらに記載がないエリアでも対応可能なことが多いため、まずはお気軽にお電話ください。</p>
          </div>
        </div>
      <?php } ?>
    </div>
    <?php
    get_template_part('template-parts/new', 'cta');
    ?>
  </main>
<?php get_footer(); ?>
