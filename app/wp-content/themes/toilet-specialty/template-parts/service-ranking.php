<?php
global $template_path;
$cards = [
  '1' => [
    'title' => 'トイレの重度なつまり',
    'img' => 'tsumari01.png',
    'link' => '/item_detail/washroom-trouble/',
    'price' => [
      'basic-price' => 3300,
      'work-price' => 11000,
      'parts-price' => 0,
    ],
    'header-color' => 'red'
  ],
  '2' => [
    'title' => 'トイレの軽度なつまり',
    'img' => 'tsumari02.jpg',
    'link' => '/item_detail/washroom-trouble/',
    'price' => [
      'basic-price' => 3300,
      'work-price' => 5500,
      'parts-price' => 0,
    ],
    'header-color' => 'pink'
  ],
  '3' => [
    'title' => 'トイレの水漏れ',
    'img' => 'mizumore.jpg',
    'link' => '/item_detail/toilet-trouble/',
    'price' => [
      'basic-price' => 3300,
      'work-price' => 11000,
      'parts-price' => 0,
    ],
    'header-color' => 'blue'
  ],
  '4' => [
    'title' => 'トイレの水が流れない、止まらない',
    'img' => 'mizunagarenai.jpg',
    'link' => '/item_detail/suisen-trouble/',
    'price' => [
      'basic-price' => 3300,
      'work-price' => 11000,
      'parts-price' => 0,
    ],
    'header-color' => 'cyan'
  ],
  '5' => [
    'title' => 'トイレの便器・部品交換',
    'img' => 'shuri-koukan.jpg',
    'link' => '/item_detail/suisen-trouble/',
    'price' => [
      'basic-price' => 3300,
      'work-price' => 11000,
      'parts-price' => 0,
    ],
    'header-color' => 'light-orange'
  ],
  '6' => [
    'title' => '水道管01',
    'img' => 'tsumari01.png',
    'link' => '/item_detail/suidoukan_01/',
    'price' => [
      'basic-price' => 0000,
      'work-price' => 00000,
      'parts-price' => 0,
    ],
    'header-color' => 'red'
  ],
  '7' => [
    'title' => '水道管02',
    'img' => 'tsumari02.jpg',
    'link' => '/item_detail/suidoukan_02/',
    'price' => [
      'basic-price' => 0000,
      'work-price' => 0000,
      'parts-price' => 0,
    ],
    'header-color' => 'pink'
  ],
  '8' => [
    'title' => 'お風呂01',
    'img' => 'mizumore.jpg',
    'link' => '/item_detail/ohuro_01/',
    'price' => [
      'basic-price' => 0000,
      'work-price' => 00000,
      'parts-price' => 0,
    ],
    'header-color' => 'blue'
  ],
  '9' => [
    'title' => 'お風呂02',
    'img' => 'mizunagarenai.jpg',
    'link' => '/item_detail/ohuro_02/',
    'price' => [
      'basic-price' => 0000,
      'work-price' => 00000,
      'parts-price' => 0,
    ],
    'header-color' => 'cyan'
  ],
];

$area_name = get_area_name();

$ranking_num = get_field('ranking_num');

if($ranking_num) {
  $ranking_num_convert = strval($ranking_num);
  $ranking_num_array = array_map('trim', explode(',', $ranking_num_convert));

  $web_discount_price = 3000;

  foreach($ranking_num_array as $key) {
    if(isset($cards[$key])) {
      $cards_ranking[$key] = $cards[$key];
    }
  }
}
?>
<?php if(get_field('ranking_num')) { ?>
<section class="service _ranking">
  <div class="content sorted">
    <?php get_template_part('template-parts/discount-banner'); ?>
    <h2 class="bg-water-surface _ranking"><?= $area_name ?>エリアでお問い合わせが多いトラブル</h2>
    <div class="inner">
      <div class="cards _ranking">
        <?php
        foreach ($cards_ranking as $key => $card) {
          $total_original_price = array_sum($card['price']);
          $total_discounted_price = $total_original_price - $web_discount_price;
        ?>
          <div class="card _ranking">
            <div class="header bg-<?= $card['header-color'] ?> small">
              <p class="header-txt"><span class="bold"><?= $card['title'] ?></span>のトラブル</p>
            </div>
            <img src="<?= $template_path ?>/img/trouble-<?= $card['img'] ?>" width="285" height="200" alt="<?= $card['title'] ?>">
            <div class="bottom">
              <div class="original-price">
                <div class="table-display">
                  <p class="row">
                    <span class="td">
                      基本料金 <span class="bold"><?= number_format($card['price']['basic-price'])?></span>円&nbsp;
                    </span>
                    <span class="td">
                      + 作業料金&nbsp;</span>
                    <span class="td">
                      <span class="bold"><?= number_format($card['price']['work-price'])?></span>円
                    </span>
                  </p>
                  <p class="row">
                    <span class="td"></span>
                    <span class="td txt-left">
                      + 部品代&nbsp;
                    </span>
                    <span class="td">
                      <span class="bold"><?= number_format($card['price']['parts-price'])?></span>円
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
                  <span class="name">web割引</span><span class="amount"><?= number_format($web_discount_price); ?>円</span>
                </p>
                <p class="discounted-total">
                  ⇒<span class="bold"><?= number_format($total_discounted_price)?></span>円(税込)
                </p>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</section>
<?php } ?>