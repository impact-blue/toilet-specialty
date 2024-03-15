<?php

global $template_path;
$args = [
  'post_type' => 'cusutomer_voice',
  'posts_per_page' => -1,
  'post_status' => 'publish',
  'meta_key' => 'show_customer_voice',
  'meta_value' => true,
];

$query_instance = new WP_Query($args);

?>
<section id="customer-voice" class="_top">
    <h2 class="customer-voice-top-ttl">お客様の声</h2>
  <div class="container customer-voice-container customer-voice-slider">
    <?php
    if ($query_instance->have_posts()) {
      while ($query_instance->have_posts()) {
        $query_instance->the_post();

        // カスタムタクソノミーの名前を取得
        $id = $query_instance->ID;
        $area_name = get_term_name($id, 'area');
        $item_name = get_term_name($id, 'item');

        $item_terms = get_the_terms($id, 'item');
        foreach((array)$item_terms as $item_term) {
          if(isset($item_term->name)) {
            $item_children_name = $item_term->name;
          }
        }

        // 小エリアページのIDとエリア名の取得
        if(get_field('is_small_area_voice')) {
          $small_area_id = get_field('small_area_id');
          $small_area_name = get_field('small_area_page', $small_area_id[0]);
        }

        // 関連するエリアページのスラッグを取得
        if(isset(get_area_page_obj($area_name, $item_name)[0])) {
          $area_page_id = get_area_page_obj($area_name, $item_name)[0]->ID;
        }

        // 人物画像を取得
        $human_img_obj = get_field_object('human_img');
        $human_img_value = $human_img_obj['value'];
        $human_img_label = $human_img_obj['choices'][$human_img_value];

        $customer_info = "$area_name " . get_field('customer_info', $id);

        if(get_field('is_small_area_voice')) {
          $customer_info = "$area_name$small_area_name " . get_field('customer_info', $id);
        }
    ?>
    <div class="customer-voice-item _top">
      <div class="customer-voice-tag"><?= $item_children_name ?></div>
      <div class="item-heading">
        <img class="human-icon" src="<?= $template_path ?>/img/<?= $human_img_value ?>" alt="<?= $human_img_label ?>">
        <div class="texts">
          <span class="person"><?= $customer_info ?>から頂いた口コミ</span>
          <span class="title"><?= the_title(); ?></span>
        </div>
      </div>
      <div class="content"><?= get_field('customer_voice_content', $id) ?></div>
    </div>
    <?php
      }
    }
    wp_reset_postdata(); ?>
  </div>
</section>