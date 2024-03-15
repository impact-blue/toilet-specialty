<?php
global $template_path;
?>
<section class="cta">
  <div class="container normal-cta">
    <div class="cta-contents">
      <img class="cta-icon" src="<?= $template_path ?>/img/cta-icon.png" alt="お住まいの地域へ最短15分でお伺い可能です！">
      <div class="pattern-1">
        <?php if (is_front_page()) { ?>
          <p>水道トラブルでお困りの場合はお気軽にご連絡ください。<br>
        <?php } else { ?>
          <p>解決できない場合は水道修理ルートにご連絡ください。<br>
        <?php } ?>
        <span class="big-text">「<span class="area-name"></span>」</span>へは<span class="about">最短</span><span class="big-text">15分</span>でお伺い可能です！</p>
      </div>

      <div class="pattern-2">
        <?php if (is_front_page()) { ?>
          <p>水道トラブルでお困りの場合はお気軽にご連絡ください。<br>
        <?php } else { ?>
          <p>解決できない場合は水道修理ルートにご連絡ください。<br>
        <?php } ?>
        <span class="big-text">お住まいの地域</span>へ最短<span class="big-text">15分</span>でお伺い可能です！</p>
      </div>

      <div class="btn-area">
        <a class="cta-btn tel-btn call-tap" href="tel:<?= get_phone_number() ?>">
          <img src="<?= $template_path ?>/img/cta-btn.png" alt="今すぐ無料電話">
        </a>
      </div>

    </div>
  </div>

  <div class="container tablet-cta">
    <div class="cta-contents">
      <div class="top">
        <img class="cta-icon" src="<?= $template_path ?>/img/cta-icon.png" alt="お住まいの地域へ最短15分でお伺い可能です！">
        <?php if (is_front_page()) { ?>
          <p>水道トラブルでお困りの場合は<br>水道修理ルートにご連絡ください。</p>
        <?php } else { ?>
          <p>解決できない場合は<br>水道修理ルートにご連絡ください。</p>
        <?php } ?>
      </div>

      <div class="bottom">
        <div class="pattern-1">
          <p class="text">
            <span class="big-text">「<span class="area-name"></span>」</span>へは<br><span class="about">最短</span><span class="big-text">15分</span>でお伺い可能です！
          </p>
        </div>
        <div class="pattern-2">
          <p class="text">
            <span class="big-text">お住まいの地域</span>へ<br>最短<span class="big-text">15分</span>でお伺い可能です！
          </p>
        </div>
      </div>

      <div class="btn-area">
        <a class="cta-btn tel-btn call-tap" href="tel:<?= get_phone_number() ?>">
          <img src="<?= $template_path ?>/img/cta-btn-sp.png" alt="今すぐ無料電話">
        </a>
      </div>

    </div>
  </div>
</section>
