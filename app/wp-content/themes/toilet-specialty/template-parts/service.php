<?php
global $template_path;
$cards = [
  [
    'title' => 'トイレ',
    'img' => 'toilet.png',
    'link' => '/toilet-repair/',
    'basic-price' => '3300',
    'work-price' => '5500',
    'parts-price' => '0',
    'header-color' => 'blue'
  ],[
    'title' => '洗面所',
    'img' => 'washroom.png',
    'link' => '/item_detail/washroom-trouble/',
    'basic-price' => '3300',
    'work-price' => '5500',
    'parts-price' => '0',
    'header-color' => 'red'
  ],[
    'title' => '排水管',
    'img' => 'tube.png',
    'link' => '/item_detail/suisen-trouble/',
    'basic-price' => '3300',
    'work-price' => '5500',
    'parts-price' => '0',
    'header-color' => 'cyan'
  ],[
    'title' => 'キッチン',
    'img' => 'kichen.png',
    'link' => '/item_detail/kitchen-trouble/',
    'basic-price' => '3300',
    'work-price' => '5500',
    'parts-price' => '0',
    'header-color' => 'light-orange'
  ],[
    'title' => 'お風呂',
    'img' => 'bath.png',
    'link' => '/item_detail/ohuro-trouble-price/',
    'basic-price' => '3300',
    'work-price' => '5500',
    'parts-price' => '0',
    'header-color' => 'pink'
  ],[
    'title' => 'ポンプ',
    'img' => 'pump.png',
    'link' => '/item_detail/pump-trouble/',
    'basic-price' => '3300',
    'work-price' => '5500',
    'parts-price' => '0',
    'header-color' => 'green'
  ],[
    'title' => '水栓柱・散水栓',
    'img' => 'plug.png',
    'link' => '/item_detail/suisen-trouble/',
    'basic-price' => '3300',
    'work-price' => '5500',
    'parts-price' => '0',
    'header-color' => 'yellow'
  ],[
    'title' => '給湯器',
    'img' => 'water-heater.png',
    'link' => '/item_detail/water-heater-trouble/',
    'basic-price' => '3300',
    'work-price' => '8800',
    'parts-price' => '0',
    'header-color' => 'purple'
  ]
];
?>
<section class="service">
    <h2 class="bg-water-surface">サービス紹介</h2>
  <div class="content">
    <?php get_template_part('template-parts/discount-banner'); ?>
    <div class="inner">
      <div class="cards">
        <?php foreach ($cards as $key => $card) {
          $total_original_price = intval($card['basic-price']) + intval($card['work-price'])+ intval($card['parts-price']);
          $total_discounted_price = $total_original_price - 3000;
        ?>
          <div class="card">
            <div class="header bg-<?= $card['header-color'] ?>">
              <p class="header-txt"><span class="bold"><?= $card['title'] ?></span>のトラブル</p>
            </div>
            <img src="<?= $template_path ?>/img/trouble-<?= $card['img'] ?>" width="285" height="200" alt="<?= $card['title'] ?>">
            <div class="bottom">
              <div class="original-price">
                <div class="table-display">
                  <p class="row">
                    <span class="td">
                      基本料金 <span class="bold"><?= number_format($card['basic-price'])?></span>円&nbsp;
                    </span>
                    <span class="td">
                      + 作業料金&nbsp;</span>
                    <span class="td">
                      <span class="bold"><?= number_format($card['work-price'])?></span>円
                    </span>
                  </p>
                  <p class="row">
                    <span class="td"></span>
                    <span class="td txt-left">
                      + 部品代&nbsp;
                    </span>
                    <span class="td">
                      <span class="bold"><?= number_format($card['parts-price'])?></span>円
                    </span>
                  </p>
                </div>
                <p class="total-row">合計 <span class="bold"><?= number_format($total_original_price) ?></span>円</p>
                <p class="annotation">
                  （必要に応じて部品代かかります）
                </p>
              </div>
              <div class="discount-price">
                <p class="discount-amount">
                  <span class="name">web割引</span><span class="amount">3,000円</span>
                </p>
                <p class="discounted-total">
                  ⇒<span class="bold"><?= number_format($total_discounted_price)?></span>円(税込)
                </p>
              </div>
              <?php if (!(get_template_name() === 'single-area_detail.php')) { ?>
                <a class="detail" href="<?= $card['link'] ?>">詳細はこちら</a>
              <?php } ?>
            </div>
          </div>
        <?php } ?>
        <div class="card wide-card">
          <p class="text-wrapper">
            <span class="header bg-orange">飲食店・店舗のお客様</span>
            <span class="text">水道管の破裂・破損・凍結など、その他のトラブルもお任せ下さい</span>
          </p>
          <img src="<?= $template_path ?>/img/restaurant-service.png" width="307" height="200" alt="水道管">
        </div>
        <div class="card wide-card">
          <p class="text-wrapper">
            <span class="header bg-navy">その他</span>
            <span class="text">定期点なつまり・水漏れの点検サービスもご用意しております</span>
          </p>
          <img src="<?= $template_path ?>/img/other-service.png" width="307" height="215" alt="">
        </div>
      </div>
    </div>
  </div>
</section>