<?php
global $template_path;
$post_id = get_the_ID();

if(get_field('small_area_page')) {
  $voice_post_id_list = get_customer_voice_linked_to_small_area($post_id);
  $city_page_id = get_post_parent()->ID;
  $parent_terms = get_the_terms($city_page_id, 'area');
  $pref_and_city_name = $parent_terms[0]->name;
  $city_name = city_page_replacement_title($pref_and_city_name);
  $small_area_name_ttl = get_field('small_area_page');
} elseif (is_singular('area_detail')) {
  $post_terms = get_the_terms($post_id, 'area');
  $area_taxonomy = get_term_slug($post_id, 'area');
  $item_slug = get_term_slug($post_id, 'item');
  $voice_post_id_list = get_customer_voice_linked_to_area($area_taxonomy, $item_slug); // お客様の声のPOSTが帰ってくる

  $pref_and_city_name = $post_terms[0]->name;
  $city_name = city_page_replacement_title($pref_and_city_name);

} elseif (is_page_template('page-pref.php')) {
  $pref_name = esc_html(get_pref_name());
  $pref_str_pattern = '/(都|府|県)$/u';
  $replace_pref_name = preg_replace($pref_str_pattern, '', $pref_name);
  $item_slug = get_term_slug($post_id, 'item');
  $voice_post_id_list = get_customer_voice_linked_to_pref($pref_name, $item_slug);  // お客様の声のPOST_IDが返ってくる
}

?>
<section id="customer-voice">
  <div class="customer-voice-container">
    <?php if(get_field('small_area_page')) { ?>
      <h2 class="area-ttl _voice"><?= $small_area_name_ttl ?>でご利用していただいた<span>お客様</span>の<span>声</span></h2>
    <?php } elseif(is_singular('area_detail')) { ?>
      <h2 class="customer-voice-ttl"><?= $city_name ?>での水道修理ルートの口コミ・評判</h2>
    <?php } ?>

    <?php
      foreach ($voice_post_id_list as $id) {
        // カスタムタクソノミーの名前を取得
        $area_name = get_term_name($id, 'area');

        // 小エリアページのIDとエリア名の取得
        if(get_field('is_small_area_voice', $id)) {
          $small_area_id = get_field('small_area_id', $id);
          $small_area_name = get_field('small_area_page', $small_area_id[0]);
        }

        // 人物画像を取得
        $human_img_obj = get_field_object('human_img' , $id);
        $human_img_value = $human_img_obj['value'];
        $human_img_label = $human_img_obj['choices'][$human_img_value];

        $customer_info = "$area_name " . get_field('customer_info', $id);

        if(get_field('is_small_area_voice', $id)) {
          $customer_info = "$area_name$small_area_name " . get_field('customer_info', $id);
        }

      ?>
      <div class="customer-voice-item <?php if(is_page_template('page-pref.php')) echo "_page" ?> _common">
        <div class="item-heading">
          <img class="human-icon" src="<?= $template_path ?>/img/<?= $human_img_value ?>" alt="<?= $human_img_label ?>">
          <div class="texts">
          <?php if(is_page_template('page-pref.php')) { ?>
            <p>
              <span class="person"><?= $customer_info ?>から頂いた口コミ</span>
              <span class="title"><?= get_the_title($id); ?></span>
            </p>
          <?php } else { ?>
            <h3>
              <span class="person"><?= $customer_info ?>から頂いた口コミ</span>
              <span class="title"><?= get_the_title($id); ?></span>
            </h3>
          <?php } ?>
          </div>
        </div>
        <div class="ratings">
          <div class="rate-box">
            <p class="rate-name">スタッフの対応</p>
            <p class="rate-star <?= get_field('staff_rating', $id); ?>"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></p>
          </div>
          <div class="rate-box">
            <p class="rate-name">水道修理の料金</p>
            <p class="rate-star <?= esc_html(get_field('price_rating', $id)); ?>"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></p>
          </div>
          <div class="rate-box">
            <p class="rate-name">お客様の満足度</p>
            <p class="rate-star <?= esc_html(get_field('satisfaction_rating', $id)); ?>"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></p>
          </div>
        </div>
        <div class="content"><?= get_field('customer_voice_content', $id) ?></div>
      </div>
      <?php } ?>
      <div class="voice-more-btn">もっと口コミを見る</div>
  </div>
</section>