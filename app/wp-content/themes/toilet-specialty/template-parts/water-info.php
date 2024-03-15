<?php
  $post_id = get_the_ID();
  $post_terms = get_the_terms($post_id, 'area');
  $pref_and_city_name = $post_terms[0]->name;
  $city_name = city_page_replacement_title($pref_and_city_name);
  $pref_name = get_pref_name();

  if ($pref_name && get_field('water_info_address')) {
?>
<section class="water-info">
  <h2 class="water-info-ttl">水道修理ルートは<?= $pref_name ?>の<br>水道局指定業者です</h2>
  <p class="water-info-desc">水道の利用開始や使用中止の連絡、料金の確認などのお問い合わせについては水道局へご連絡ください</p>
  <h3 class="water-info-subttl"><span class="txt"><?= $city_name ?>の水道局情報</span></h3>
  <div class="water-info-wrap">
    <dl class="_border">
      <dt>・所在地：</dt>
      <dd><?php the_field('water_info_address'); ?></dd>
    </dl>
    <div class="water-info-map">
      <?php the_field('water_info_map'); ?>
    </div>
    <dl>
      <dt>・電話番号：</dt>
      <dd><?php the_field('water_info_tel') ?></dd>
    </dl>
    <p class="water-info-annotation _border">※水道修理ルート（クリーンライフ）の電話番号ではございません。</p>
    <?php if(get_field('water_info_train') || get_field('water_info_bus')) { ?>
    <dl>
      <dt>・アクセス：</dt>
    </dl>
      <?php if(get_field('water_info_train')) { ?>
      <dl class="water-info-access">
        <dt>電車：</dt>
        <dd><?php the_field('water_info_train'); ?></dd>
      </dl>
      <?php } ?>
      <?php if(get_field('water_info_bus')) { ?>
      <dl class="water-info-access">
        <dt>バス：</dt>
        <dd><?php the_field('water_info_bus'); ?></dd>
      </dl>
      <?php } ?>
    <?php } ?>
  </div>
</section>
<?php } ?>