<?php
global $template_path;
$page_area = get_page_by_path('area');
$parent_id = $page_area->ID;

$args = [
  'posts_per_page' => -1,
  'post_type' => 'page',
  'order' => 'ASC',
  'post_parent' => $parent_id,
  'meta_key' => 'area_select',
  'orderby' => 'meta_value',
];

$pref_name_obj = get_posts($args);
?>
<div class="result">
  <div class="popup-window">
    <div class="upper-box">
      <div class="searched-zip-code">
        <img src="<?= $template_path ?>/img/search-icon.png" width="35" height="35" alt="">
        <span class="zip-code"></span>
      </div>
      <div class="address">
        <span class="result-zip-code"></span>
        <span class="result-area"></span>
        <span class="result-handle"></span>
      </div>
      <div class="error">
        <span class="error-message">対応エリア範囲外になります。</span>
      </div>
    </div>
    <div class="lower-box">
      <span>深夜や休日でも最短<span class="accent"><span class="num">15</span>分</span><br>出張費<span class="accent"><span class="num">0</span>円</span>でかけつけます！<br>修理や料金に関するトラブル一切なしだから安心</span>
      <span class="is-pc cta-tel">
        ※お急ぎの方はお電話よりお気軽にご相談ください！<br>
        <img src="<?= $template_path ?>/img/tel-icon.png" width="25" height="17" alt=""><?= get_phone_number(); ?>
      </span>
      <p class="is-pc tel-annotation">
        <?= get_tel_annotation()?>
      </p>
      <div class="is-pc cta-btn">
        <a href="/contact/">お問い合わせする<br><span class="min-text">（お問い合わせページに移動します）</span></a>
      </div>
      <div class="is-sp cta-btn">
        <a href="tel:<?= get_phone_number(); ?>">電話でお問い合わせする<br><span class="min-text">（発信 <?= get_phone_number(); ?>）</span></a>
      </div>
      <p class="is-sp tel-annotation">
        <?= get_tel_annotation()?>
      </p>
    </div>
    <div class="close-btn"></div>
  </div>

<div class="pref-list">
  <?php if ($pref_name_obj) { ?>
  <ul>
    <?php foreach ($pref_name_obj as $pref) {
      $pref_id = $pref->ID;
      $pref_name = get_field('big_area_name', $pref_id);
    ?>
      <li><?= $pref_name ?></li>
    <?php } ?>
  </ul>
  <?php } ?>
</div>