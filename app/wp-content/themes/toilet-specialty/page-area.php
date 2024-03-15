<?php
/*
Template Name: 対応エリア一覧
*/
get_header();
$parent_id = get_the_ID();

$args = [
  'posts_per_page' => -1,
  'post_type' => 'page',
  'order' => 'ASC',
  'post_parent' => $parent_id,
  'meta_key' => 'area_select',
  'orderby' => 'meta_value',
  'tax_query' => [
    [
      'taxonomy' => 'item',
      'field'    => 'slug',
      'terms'    => 'toilet'
    ]
  ]
];

$pref_name_obj = get_prefname_obj($args);
?>
  <main>
    <section id="post-list" class="area-page">
      <h1 class="heading">対応エリア一覧</h1>
      <div class="container">
        <?php if ($pref_name_obj) { ?>
          <?php foreach ($pref_name_obj as $area_name => $prefs) { ?>
            <div class="area-block">
              <h2 class="area-block-ttl"><?= $area_name . 'の水道修理対応エリア'?></h2>
              <ul class="areas">
                <?php
                  foreach ($prefs as $pref) {
                  $pref_id = $pref->ID;
                  $pref_name = get_field('big_area_name', $pref_id);
                ?>
                <li>
                  <?php $cities = get_city_pages($pref_name)['トイレ']; ?>
                  <a class="area-modal-btn area-link"><?= $pref_name ?></a>
                  <div class="area-modal-wrapper">
                    <a class="area-modal-bg"></a>
                    <div class="area-modal area-block">
                      <a class="area-modal-close">×</a>
                      <p class="area-block-ttl">
                        <a href="<?= get_the_permalink($pref->ID) ?>">
                          <?= $pref_name ?>のトイレ修理
                        </a>
                      </p>
                      <ul class="areas">
                        <?php
                      foreach($cities as $city) {
                        $post_id = $city->ID;
                        $post_terms = get_the_terms($post_id, 'area');
                        $pref_and_city_name = $post_terms[0]->name;
                      ?>
                        <li>
                          <a class="area-link" href="<?= get_the_permalink($post_id) ?>">
                            <?= city_page_replacement_title($pref_and_city_name) ?>
                          </a>
                        </li>
                      <?php } ?>
                      </ul>
                    </div>
                  </div>
                </li>
                <?php } ?>
              </ul>
            </div>
          <?php } ?>
        <?php } ?>
      </div>
    </section>
  </main>
<?php get_footer(); ?>
