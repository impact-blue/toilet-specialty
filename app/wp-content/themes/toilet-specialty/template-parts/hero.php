<?php
global $template_path;

if (get_field('show_small_area')) {
  $small_area_name = get_field('small_area_page');
  $small_area_name_length = mb_strlen($small_area_name);
} elseif (is_page_template('page-pref.php')) {
  $pref_name = get_pref_name();
  $pref_name_length = mb_strlen($pref_name);
} elseif (is_singular('area_detail')) {
  $post_id = get_the_ID();
  $post_terms = get_the_terms($post_id, 'area');
  $pref_and_city_name = $post_terms[0]->name;
  $city_name = city_page_replacement_title($pref_and_city_name);
  $city_name_length = mb_strlen($city_name);
}

?>

<section class="hero">
  <?php if (get_field('show_small_area')) { ?>
    <div class="area-badge">
    <span class="badge-span chars-<?= $small_area_name_length ?>"><?php the_field('small_area_page'); ?></span>
    </div>
  <?php } elseif  (isset($pref_name)) { ?>
    <div class="area-badge">
    <span class="badge-span chars-<?= $pref_name_length ?>"><?= $pref_name ?></span>
    </div>
  <?php } elseif (isset($city_name)) { ?>
    <div class="area-badge">
    <span class="badge-span chars-<?= $city_name_length ?>"><?= $city_name ?></span>
    </div>
  <?php } ?>
  <?php if (is_page('toilet-repair')) {?>
  <div class="relative is-pc">
    <img class="hero-img" src="<?= $template_path ?>/img/toilet_hero_pc.png" width="1440" height="779" alt="最短15分出張費無料で駆けつけます！">
  </div>

  <div class="is-sp">
    <div class="relative sp-fv-top">
      <img class="hero-img" src="<?= $template_path ?>/img/toilet_hero_sp.png" width="375" height="978" alt="最短15分出張費無料で駆けつけます！">
    </div>
  </div>
  <?php } else {?>
  <div class="relative is-pc">
    <img class="hero-img" src="<?= $template_path ?>/img/hero.jpg?20210906" width="1440" height="779" alt="最短15分出張費無料で駆けつけます！">
  </div>

  <div class="is-sp">
    <div class="relative sp-fv-top">
      <img class="hero-img" src="<?= $template_path ?>/img/sp-hero.jpg?20210906" width="375" height="978" alt="最短15分出張費無料で駆けつけます！">
    </div>
  </div>
  <?php } ?>
</section>
