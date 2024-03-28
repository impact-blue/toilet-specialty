<?php
global $template_path;
$phone_number = get_phone_number();
$area_code = preg_replace('/-\d+.*/', '', $phone_number);
$without_area_code = preg_replace('/^\d+/', '', $phone_number);
?>

<section class="hero">
  <div class="hero-container">
    <p class="hero-head"><span class="label">作業員待機中</span><span class="color first">15時43分</span>現在、近くの作業員が<span class="color">最短15分〜</span>でお伺いできます。</p>
  </div>
  <div class="hero-bg"></div>
  <div class="hero-wrap">
    <div class="hero-tel hero-btn"><a href=""><?= $area_code ?><?= $without_area_code ?></a></div>
    <div class="hero-contact hero-btn"><a href="/contact/">お問い合わせ</a></div>
  </div>
</section>
