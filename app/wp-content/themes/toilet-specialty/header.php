<?php
global $template_path;
$template_path = esc_url(get_template_directory_uri());
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
    <div class="header-flex">
      <div class="header-logo"></div>
      <div class="header-right">
        <div class="header-price header-btn"><a href="/price/">料金</a></div>
        <div class="header-area header-btn"><a href="/area/">対応エリア</a></div>
        <div class="header-contact header-btn"><a href="/contact/">お問い合わせ</a></div>
      </div>
    </div>
    <ul class="header-list">
      <li class="header-item"><a href="/">ホーム</a></li>
      <li class="header-item"><a href="/sekou/">施工事例一覧</a></li>
      <li class="header-item"><a href="/article/">お役立ちコラム</a></li>
      <li class="header-item"><a href="/customer-voice/">お客様の声</a></li>
      <li class="header-item"><a href="/questions/">よくある質問</a></li>
      <li class="header-item"><a href="">お急ぎの方へ</a></li>
    </ul>
  </div>
</header>

<?php if (!is_front_page() && function_exists('bcn_display')) { ?>
  <div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
    <?php bcn_display(); ?>
  </div>
<?php } ?>
