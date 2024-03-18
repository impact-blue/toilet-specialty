<?php
  global $template_path;
  $phone_number = get_phone_number();
  $area_code = preg_replace('/-\d+.*/', '', $phone_number);
  $without_area_code = preg_replace('/^\d+/', '', $phone_number);
?>
<section class="new-cta">
  <?php if (!is_tax('sekou')) {?>
  <div class="achievement-banner">
    <p>
      <span class="bold">皆様のおかげで<span class="yellow">創業21年。<br class="is-tablet">累計100万件以上</span>のご相談を頂戴しております！</span>
    </p>
  </div>
  <?php } ?>
    <div class="is-sp sp-bottom">
      <div class="sp-bottom-wrap">
        <div class="ballon is-sp">
          <p><span class="emphasis">お急ぎ</span>の方は<br>お電話<br>ください！</p>
        </div>
        <div class="tel-imgs-wrap">
          <a class="tel-imgs tel-content" href="tel:<?= get_phone_number() ?>">
            <img class="icon" src="<?= $template_path ?>/img/icon-tel-green.png" width="31" height="20" alt="">
            <div class="phone-number">
              <p class="phone-number-text">通話料無料</p>
              <p class="phone-number-figure"><span><?= $area_code ?></span><?= $without_area_code ?></p>
            </div>
            <div class="call-ballon">
              <p><span class="emphasis">タップ</span>で<br><span class="emphasis">電話</span>する</p>
            </div>
          </a>
          <p class="tel-annotation">
            <?= get_tel_annotation()?>
          </p>
        </div>
      </div>
    </div>
  <div class="inner">
   <div class="ballon is-pc">
      <p>お急ぎの方は<br>お電話<br>ください！</p>
    </div>
    <div class="tel-contents">
      <div class="is-sp">
        <?php if(get_field('cta_text')) { ?>
          <p class="header"><span class="bold"><?php the_field('cta_text'); ?></span> <span>お電話一本ですぐにお伺いします！</span></p>
        <?php } else { ?>
          <p class="header"><span class="bold">水漏れ・つまり・修理</span> <span>お電話一本ですぐにお伺いします！</span></p>
        <?php } ?>
      </div>
      <svg class="reception-time is-sp" xmlns="http://www.w3.org/2000/svg" width="719" height="26" viewBox="0 0 719 26"><defs><style>.a{fill:#1a42aa;font-size:19.329px;font-family:HiraginoSans-W7, Hiragino Sans;}.b{fill:#f0033c;font-size:23.471px;}</style></defs><text class="a" transform="translate(0 21)"><tspan x="0" y="0">【受付時間】</tspan><tspan class="b" y="0">24</tspan><tspan y="0">時間</tspan><tspan class="b" y="0">365</tspan><tspan y="0">日対応 | お見積もり</tspan><tspan class="b" y="0">0円</tspan><tspan y="0" xml:space="preserve"> | 出張費</tspan><tspan class="b" y="0">0円</tspan><tspan y="0" xml:space="preserve"> | 深夜割増</tspan><tspan class="b" y="0">0円</tspan></text></svg>
      <div class="is-pc">
        <div class="tel-imgs">
          <img class="icon" src="<?= $template_path ?>/img/icon-tel-green_02.png" width="31" height="20" alt="">
          <div class="phone-number">
            <p class="phone-number-figure"><?= $area_code ?><?= $without_area_code ?></p>
          </div>
        </div>
        <p class="tel-annotation">
          <?= get_tel_annotation()?>
        </p>
        <p class="header"><span class="bold">トイレのトラブルなら<span>お電話一本</span>ですぐにお伺いします！</p>
      </div>
      <p class="reception-time bold is-pc">【受付時間】<span>24</span>時間<span>365</span>日対応 | お見積もり<span>0円</span> | 出張費<span>0円</span> | 深夜割増<span>0円</span></p>
    </div>
  </div>
</section>