<?php
global $template_path;
$cards = [
  [
    'title' => '安心の<span class="carmine">水道局<br>指定工事店</span>',
    'description' => '近年、無免許無許可で作業を行なっている業者もいますが、水道修理ルートは創業21年、累計対応件数100万件以上の実績がある優良企業です。',
    'img_size' => 126
  ],[
    'title' => 'お見積もり、出張費、<br class="pc-br">深夜割増、キャンセル料<span class="carmine">0円</span>',
    'description' => 'お見積もり後の追加料金も頂いておりません。他者より1円でも高い場合はお気軽にご相談下さいませ。',
    'img_size' => 134
  ],[
    'title' => '<span class="carmine">24</span>時間<br><span class="carmine">365日</span>受付対応',
    'description' => '水道トラブルはいつ起こるかわかりません。急なご依頼にも迅速に対応出来るように24時間365日体制で受付しております。',
    'img_size' => 132
  ],[
    'title' => 'HP限定割引!<br>最大<span class="carmine">3,000円OFF</span>',
    'description' => 'お電話の際に「ホームページを見た」とお伝え頂けましたら、作業料金から割引させていただきます。',
    'img_size' => 137
  ],[
    'title' => '充実の<br><span class="carmine">アフターフォロー</span>',
    'description' => '1〜3年の無料点検・無料保証制度 付きなので安心！',
    'img_size' => 125
  ],[
    'title' => '<span class="carmine">クレジットカード・<br>後払い</span>対応',
    'description' => 'お支払い方法は、現金、スマホ決済、クレジットカード、後払いなど、お客様のご都合に合わせてお選び頂いております。',
    'img_size' => 121
  ],[
    'title' => '<span class="carmine">PL保険</span><br>加入業者',
    'description' => '万が一の時の事故や損害に備えて保険に加入しているので安心です。',
    'img_size' => 125
  ],[
    'title' => '<span class="carmine">クーリング・オフ</span><br>制度対応',
    'description' => '一定期間内であれば契約を解除する事が可能。自信があるからこそご提供している制度になります！',
    'img_size' => 129
  ],
];

if(!is_front_page()) {
  $reason_txt = 'トイレつまり';
  $sentence = [
    [
      'title' => '出張費や見積もり費・深夜早朝料金が無料',
      'description' => '多くのトイレつまり修理業者では出張費や見積もり費・深夜早朝割増などがありません。また、キャンセル料の有無や極端に安すぎないかもチェックしましょう。',
    ],[
      'title' => '豊富な技術力と実績数',
      'description' => 'トイレつまり修理などのトイレトラブル修理を行うには豊富な知識と技術力が必要でとても大事です。また、実際に対応した件数（実績数）が多いほど信頼できる業者です。',
    ],[
      'title' => '作業見積もりが明確で説明がある',
      'description' => '作業見積もりに対し何にどのくらい料金が掛かるかの内訳がしっかりしていて、料金に対する説明がしっかりあるかは要チェックです。',
    ],[
      'title' => '水道指定工事店である',
      'description' => '水道局指定とは各自治体の水道局から認められた工事店であり、トイレつまり修理などの水道修理に関する国家資格保持者が在籍していることを意味しております。',
    ],
  ];
} else {
  $reason_txt = '水道';
  $sentence = [
    [
      'title' => '出張費や見積もり費・深夜早朝料金が無料',
      'description' => '多くの水道修理業者では出張費や見積もり費・深夜早朝割増などがありません。また、キャンセル料の有無や極端に安すぎないかもチェックしましょう。',
    ],[
      'title' => '豊富な技術力と実績数',
      'description' => '水道修理を行うには豊富な知識と技術力が必要でとても大事です。また、実際に対応した件数（実績数）が多いほど信頼できる業者です。',
    ],[
      'title' => '作業見積もりが明確で説明がある',
      'description' => '作業見積もりに対し何にどのくらい料金が掛かるかの内訳がしっかりしていて、料金に対する説明がしっかりあるかは要チェックです。',
    ],[
      'title' => '水道指定工事店である',
      'description' => '水道局指定とは各自治体の水道局から認められた工事店であり、水道修理に関する国家資格保持者が在籍していることを意味しております。',
    ],
  ];
}

$area_name = get_area_name();

?>

<section class="reason-of-choose">
    <h2 class="bg-water-surface _area"><?php if ($area_name) echo "{$area_name}で" ?><?= $reason_txt ?>修理依頼が初めての方へ</h2>
  <div class="content _area">
    <h3 class="sub-header bold"><?= $reason_txt ?>修理業者の選び方</h3>
    <p class="subttl bold"><?= $reason_txt ?>修理業者を選ぶときにチェックしておきたい4つのポイント！</p>
    <ol class="inner _top">
      <?php
      foreach ($sentence as $key => $text) {
        $key++;
      ?>
        <li class="card _top">
          <div class="num _top"><?= $key ?></div>
          <p class="header bold _top"><?= $text['title'] ?></p>
          <p class="description _top"><?= $text['description'] ?></p>
        </li>
      <?php
      }
      ?>
    </ol>
  </div>
  <div class="content _low">
    <h3 class="sub-header bold">水道修理ルートが選ばれる理由</h3>
    <ol class="inner">
      <?php
      foreach ($cards as $key => $card) {
        $key++;
      ?>
        <li class="card">
          <div class="icon">
            <div class="num white bg-light-orange"><?= $key ?></div>
            <img src="<?= $template_path ?>/img/reason-of-choose-<?= $key ?>.png" width="<?= $card['img_size'] ?>" height="<?= $card['img_size'] ?>" alt="">
          </div>
          <p class="header bold"><?= $card['title'] ?></p>
          <p class="description"><?= $card['description'] ?></p>
        </li>
      <?php
      }
      ?>
    </ol>
  </div>
</section>