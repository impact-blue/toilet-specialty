<?php
global $template_path;
$template_path = esc_url(get_template_directory_uri());

$date = date('YmdHi', time());

$area_name = '';

if (get_template_name() === 'page-pref.php') {
  $area_name = esc_html(get_the_title()) . 'の';
} else if (get_template_name() === 'single-area_detail.php') {
  $area_name = get_term_name(get_the_ID(), 'area') . 'の';
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" >
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-M6H5P6J');</script>
  <!-- End Google Tag Manager -->
  <script type="text/javascript" src="<?= $template_path . '/dist/app.js' . '?ver=' . $date ?>" async></script>
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M6H5P6J"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div id="layer"></div>
<header id="header">
  <div class="header-inner">
    <?php
    // ロゴのタグの分岐
    if (is_home() || is_front_page()) {
      $tag_start = '<h1 class="header-site-info">';
      $tag_end = '</h1>';
    } else {
      $tag_start = '<div class="header-site-info">';
      $tag_end = '</div>';
    }
    ?>
    <?= $tag_start ?>
    <a class="logo" href="<?= site_url('/'); ?>">
      <img src="<?= $template_path ?>/img/logo.png?20210512" width="400" height="91" alt="水回りトラブル・修理ならお任せください。<?= bloginfo('name'); ?>">
    </a>
    <?= $tag_end ?>

    <div class="tel-cta is-pc">
      <p>【水トラブルのことなら】どんな小さなことでもお気軽にご相談下さい！</p>
      <span class="tel-free">通話料無料</span>
      <div class="tel-wrapper">
        <img src="<?= $template_path ?>/img/icon-tel-green.png" width="31" height="20" alt="">
        <span class="tel"><?= get_phone_number() ?></span>
      </div>
      <p class="tel-annotation"><?= get_tel_annotation()?></p>
      <p class="emphasis-text">【受付時間】<span>24</span>時間<span>365</span>日対応 | お見積もり<span>0円</span> | 出張費<span>0円</span> | 深夜割増<span>0円</span></p>
    </div>

    <div class="contact-form is-pc">
      <a href="/contact/">
        <img src="<?= $template_path ?>/img/contact-form.png" width="275" height="40" alt="無料見積もりフォームへ">
      </a>
      <div class="discount">
        <img src="<?= $template_path ?>/img/hp-only-discount-text.png" width="240" height="72" alt="HP限定割！最大3000円割引！">
      </div>
    </div>

    <div id="sp-header">
      <a href="/contact/">
        <img src="<?= $template_path ?>/img/mail.png" width="48" height="32" alt="">
        <span>無料見積もり<br>フォーム</span>
      </a>
      <div id="sp-nav-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="45" height="28.49" viewBox="0 0 45 28.49">
          <line class="nav-line" x1="0" y1="1.5" x2="45" y2="1.5" stroke="#1b43ab"/>
          <line class="nav-line" x1="0" y1="14.24" x2="45" y2="14.24" stroke="#1b43ab"/>
          <line class="nav-line" x1="0" y1="26.98" x2="45" y2="26.98" stroke="#1b43ab"/>
        </svg>
        <span>メニュー</span>
      </div>
    </div>
  </div>
</header>

<nav id="nav">
  <ul class="nav-list" itemscope itemtype="https://schema.org/SiteNavigationElement">
    <li class="ac-trigger is-pc">
      <a href="<?= esc_url(home_url('/')) ?>">ホーム</a>
      <div class="ac-content">
        <a class="ac-menu" href="/toilet-repair/">
        トイレの修理・交換
        </a>
        <a class="ac-menu" href="/item_detail/toilet-tumari/">
        トイレのつまりの直し方
        </a>
      </div>
    </li>
    <li class="is-sp ac-head">
      <p><span itemprop="name">ホーム</span></p>
      <div class="ac-icon"></div>
    </li>
    <div class="ac-body">
      <div class="ac-body-item">
        <a href="<?= esc_url(home_url('/')) ?>">ホーム</a>
      </div>
      <div class="ac-body-item">
        <a href="/toilet-repair/">トイレの修理・交換</a>
      </div>
      <div class="ac-body-item">
        <a href="/item_detail/toilet-tumari/">トイレのつまりの直し方</a>
      </div>
    </div>
    <li>
      <a itemprop="url" href="/price/">
        <span itemprop="name">料金</span>
      </a>
    </li>
    <li>
      <a itemprop="url" href="/area/">
        <span itemprop="name">対応エリア</span>
      </a>
    </li>
    <?php
      $term_list = get_sekou_tags();
      $page_id = get_page_by_path('sekou')->ID;
    ?>
    <?php if ($term_list) { ?>
      <li class="ac-trigger is-pc">
        <a itemprop="url" href="/sekou/">
          <span itemprop="name">施工事例一覧</span>
        </a>
        <div class="ac-content">
          <?php foreach ($term_list as $term) { ?>
            <a class="ac-menu" href="<?= get_term_link($term->term_id); ?>">
              <?= $term->name; ?>
            </a>
          <?php } ?>
        </div>
      </li>
    <?php } ?>
    <li class="is-sp ac-head">
      <p><span itemprop="name">施工事例一覧</span></p>
      <div class="ac-icon"></div>
    </li>
    <?php if ($term_list) { ?>
      <div class="ac-body">
        <div class="ac-body-item">
          <a href="/sekou/">施工事例一覧</a>
        </div>
        <?php foreach ($term_list as $term) { ?>
          <div class="ac-body-item">
            <a href="<?= get_term_link($term->term_id); ?>">
              <?= $term->name; ?>
            </a>
          </div>
        <?php } ?>
      </div>
    <?php } ?>
    <li class="ac-trigger is-pc">
      <p>水回り<br class="is-pc">お役立ち情報</p>
      <div class="ac-content">
        <a class="ac-menu" href="/item/">
          トラブル解消法
        </a>
        <a class="ac-menu" href="/article/">
          お役立ち情報
        </a>
      </div>
    </li>
    <li class="is-sp">
      <a itemprop="url" href="/item/">
        <span itemprop="name">水回りトラブル解消法</span>
      </a>
    </li>
    <li class="is-sp">
      <a itemprop="url" href="/article/">
        <span itemprop="name">水回り関連のお役立ち情報</span>
      </a>
    </li>
    <li>
      <a itemprop="url" href="/customer-voice/">
        <span itemprop="name">お客様の声</span>
      </a>
    </li>
    <li>
      <a itemprop="url" href="/questions/">
        <span itemprop="name">よくある質問</span>
      </a>
    </li>
    <li>
      <a id="hurryBtn" itemprop="url" href="javascript:onEmergencyLinkClick('<?= get_phone_number() ?>');">
        <span>お急ぎの方へ</span>
        <img src="<?= $template_path ?>/img/pictogram-dash.png" width="32" height="22" alt="">
      </a>
    </li>
    <li id="close-li">メニューを閉じる</li>
  </ul>
</nav>

<?php if (!is_front_page() && function_exists('bcn_display')) { ?>
  <div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
    <?php bcn_display(); ?>
  </div>
<?php } ?>
