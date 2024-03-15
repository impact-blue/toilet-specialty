<?php
global $template_path;
$cards = [
  [
    'title' => 'トイレの水漏れ',
    'img' => 'mizumore.jpg',
    'link' => '/item_detail/toilet-trouble/',
    'basic-price' => '3300',
    'work-price' => '11000',
    'parts-price' => '0',
    'header-color' => 'blue'
  ],[
    'title' => 'トイレつまり',
    'img' => 'tsumari.jpg',
    'link' => '/item_detail/washroom-trouble/',
    'basic-price' => '3300',
    'work-price' => '5500',
    'parts-price' => '0',
    'header-color' => 'red'
  ],[
    'title' => 'トイレの水が流れない、止まらない',
    'img' => 'mizunagarenai.jpg',
    'link' => '/item_detail/suisen-trouble/',
    'basic-price' => '3300',
    'work-price' => '11000',
    'parts-price' => '0',
    'header-color' => 'cyan'
  ],[
    'title' => 'トイレ修理・交換',
    'img' => 'shuri-koukan.jpg',
    'link' => '/item_detail/suisen-trouble/',
    'basic-price' => '3300',
    'work-price' => '11000',
    'parts-price' => '0',
    'header-color' => 'light-orange'
  ]
];
?>
<section class="service">
  <div class="content sorted">
    <?php get_template_part('template-parts/discount-banner'); ?>
    <div class="inner">
      <div class="cards">
        <?php foreach ($cards as $key => $card) {
          $total_original_price = intval($card['basic-price']) + intval($card['work-price'])+ intval($card['parts-price']);
          $total_discounted_price = $total_original_price - 3000;
        ?>
          <div class="card">
            <div class="header bg-<?= $card['header-color'] ?> small">
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
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</section>