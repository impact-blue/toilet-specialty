<?php
global $template_path;
$light_orange = 'bg-light-orange';
$dark_blue = 'bg-dark-blue';
$service_flow_text = get_field('service_flow_text');

if($service_flow_text) {
  $first_cards_cms = [
    'title' => 'お問い合わせ',
    'description' => $service_flow_text
  ];
} else {
  $first_cards_cms = [
    'title' => 'お問い合わせ',
    'description' => 'お電話、メール、チャットにてお気軽にご相談くださいませ。'
  ];
}

$first_cards = [
  $first_cards_cms,
  [
    'title' => '現地調査',
    'description' => '水漏れ、故障原因を調査します。現地調査は無料で実施しておりますのでご安心下さいませ。'
  ],[
    'title' => 'お見積り提示',
    'description' => 'お見積りをご提示させて頂きます。お見積りと作業内容にご納得頂いてはじめて作業へと移ります。'
  ]
];
$second_cards = [
  [
    'title' => '作業開始',
    'description' => '経験豊富なスタッフがスピーディー且つ丁寧に作業させて頂きます。'
  ],[
    'title' => '作業完了・ご精算',
    'description' => '作業完了後、作業箇所をご確認頂き問題ございませんでしたら、ご精算をさせて頂きます。'
  ]
];
?>
<section class="service-flow-2">
  <div class="inner">
    <h2 class="royal-blue service-flow-ttl">お問い合わせから作業完了までの流れ</h2>
    <div class="content">
      <div class="first-half-wrapper">
        <h3 class="service-flow-phrase">ご相談からお見積もりは<span class="carmine">無料</span>です！</h3>
        <p class="annotation">※キャンセルの場合も、費用は発生いたしません。</p>
        <p class="annotation">※万が一何かご不明点が発生した場合は弊社お客様相談室にご相談ください。</p>
        <div class="first-half">
        <?php
        foreach ($first_cards as $key => $card) {
          $key++;
        ?>
          <div class="card">
            <div class="icon">
              <div class="num bg-light-orange"><?= $key ?></div>
              <img src="<?= $template_path ?>/img/service-flow-<?= $key ?>.png" width="117" height="117" alt="<?= $card['title'] ?>"/>
            </div>
            <div>
              <p class="header bold"><?= $card['title'] ?></p>
              <p class="description"><?= $card['description'] ?></p>
            </div>
          </div>
        <?php
        }
        ?>
        </div>
      </div>
      <div class="second-half">
      <?php
      foreach ($second_cards as $key => $card) {
        $key += count($first_cards) + 1;
      ?>
        <div class="card">
          <div class="icon">
            <div class="num bg-dark-blue"><?= $key ?></div>
            <img src="<?= $template_path ?>/img/service-flow-<?= $key ?>.png" width="117" height="117" alt="<?= $card['title'] ?>"/>
          </div>
          <div>
            <p class="header bold"><?= $card['title'] ?></p>
            <p class="description"><?= $card['description'] ?></p>
          </div>
        </div>
      <?php
      }
      ?>
      </div>
    </div>
  </div>
</section>