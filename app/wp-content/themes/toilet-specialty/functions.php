<?php

/* ------------------------------
 セットアップ
------------------------------ */
function init_setup() {
  // titleタグを出力
  add_theme_support('title-tag');

  // サムネイル画像を使用可能に
  add_theme_support('post-thumbnails');

  // メニューを有効にする
  add_theme_support('menus');

  // テーマカスタマイザーでのウィジェット再読み込み
  add_theme_support('customize-selective-refresh-widgets');

  // HTML5のサポート
  add_theme_support('html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
  ));

  // カスタムロゴ機能を使用可能にする
  add_theme_support('custom-logo', array(
    'height'      => 250,
    'width'       => 250,
    'flex-width'  => true,
    'flex-height' => true,
  ));

  // 環境別のGeocodingAPIのKeyを設定
  if (!defined('GEOCODE_API_KEY_PRD')) {
    define('GEOCODE_API_KEY_PRD', 'AIzaSyD0jHDGKsDvUYgnbFaWxr1bQEf7v_FFOIM');
  }
  if (!defined('GEOCODE_API_KEY_STG')) {
    define('GEOCODE_API_KEY_STG', 'AIzaSyCVlp5OM9C4zmLJ7DZoAs85u3VrXI5HSWM');
  }
  if (!defined('GEOCODE_API_KEY_DEV')) {
    define('GEOCODE_API_KEY_DEV', 'AIzaSyBMRpBsSX5W2WqrdrQO_o8PK5xrLXJfTOk');
  }
}
add_action('after_setup_theme', 'init_setup');

// フィードのタグのみを表示
function add_feed_tag() {
  $site_title = get_bloginfo('name');
  $site_url = home_url('/');
  $feed = '<link rel="alternate" type="application/rss+xml" title="'. $site_title .' &raquo; フィード" href="'. $site_url .'feed/" />'. "\n";
  echo $feed;
}
add_action('wp_head', 'add_feed_tag');

// header内でファビコンを出力
function set_favicon() {
  $favicon = '<link rel="shortcut icon" href="'.get_template_directory_uri().'/img/favicon.png">';
  echo $favicon;
}
add_action('wp_head', 'set_favicon');

// 存在しないページにアクセスされた時に勝手にリダイレクトされないようにする
function stop_redirect_canonical($redirect_url) {
  if (is_404()) return false;
}
add_action('redirect_canonical', 'stop_redirect_canonical');

// jsとcssを読み込む
function jsgt_styles() {
  $date = date('YmdHi', time());

  wp_enqueue_style('main', get_template_directory_uri() . '/dist/css/style.css', array(), $date);
  wp_enqueue_style('style', get_template_directory_uri() . '/style.css', array(), $date);
}
add_action('wp_enqueue_scripts', 'jsgt_styles');

// 不要なスタイル・スクリプトの読み込み停止
function dequeue_plugins_style() {
  wp_dequeue_style('wp-block-library');
  // wp-emoji-release.min.js
  wp_deregister_script('wp-embed');
  remove_action('wp_head', 'print_emoji_detection_script', 7);

  // WPのコアファイルのjQueryは管理画面以外読み込ませない
  if (!is_admin()) {
    wp_deregister_script('jquery');
  }
}
add_action('wp_enqueue_scripts', 'dequeue_plugins_style');

// テンプレートの名前を取得する
function get_template_name() {
  global $template;
  return basename($template);
}

// 抜粋のpタグを削除する
remove_filter('the_excerpt', 'wpautop');

// 特定ページを404へリダイレクトする
function pages_404() {
  $redirect_404 = array(
    'price_list',
    'cusutomer_voice',
    'area_manager_prof',
    'supervisor_prof'
  );
  if (in_array(get_post_type(), $redirect_404)) {
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
  }
}
add_action('template_redirect', 'pages_404');

/* ------------------------------
 SEO関連
------------------------------ */

// ページごとのデスクリプションを生成
function generate_description() {
  global $paged;

  $descriptions = [
    'customer_voice_description' => sprintf('お客様の声ページ（%dページ目）です。
    お近くの安心できる水道修理業者をお探しなら水道修理ルートへ！
    24時間いつでも有資格の作業員が駆け付けます。もちろん出張費やお見積りはすべて無料！
    トイレ・キッチン・お風呂・洗面所のトラブルでお困りの方は今すぐご連絡ください！', $paged),
    'item_archive_description' => '水回りトラブルの記事一覧ページです。
    お近くの安心できる水道修理業者をお探しなら水道修理ルートへ！
    24時間いつでも有資格の作業員が駆け付けます。もちろん出張費やお見積りはすべて無料！
    トイレ・キッチン・お風呂・洗面所のトラブルでお困りの方は今すぐご連絡ください！',
    'article_archive_description' => '水回りに関するお役立ち情報一覧ページです。
    お近くの安心できる水道修理業者をお探しなら水道修理ルートへ！
    24時間いつでも有資格の作業員が駆け付けます。もちろん出張費やお見積りはすべて無料！
    トイレ・キッチン・お風呂・洗面所のトラブルでお困りの方は今すぐご連絡ください！',
    'sekou_archive_description' => '施工事例一覧ページです。
    お近くの安心できる水道修理業者をお探しなら水道修理ルートへ！
    24時間いつでも有資格の作業員が駆け付けます。もちろん出張費やお見積りはすべて無料！
    トイレ・キッチン・お風呂・洗面所のトラブルでお困りの方は今すぐご連絡ください！',
  ];

  if (is_post_type_archive('article_detail')) {
    return $descriptions['article_archive_description'];
  } elseif(is_post_type_archive('item_detail')) {
    return $descriptions['item_archive_description'];
  } elseif(is_page('customer-voice')) {
    return $descriptions['customer_voice_description'];
  } elseif (is_post_type_archive('sekou_detail')) {
    return $descriptions['sekou_archive_description'];
  } else {
    return;
  }
}

// お客様の声ページに独自のタイトルタグを設定
function change_customer_page_title($title) {
  global $paged;

  $site_title = esc_html(get_bloginfo('name'));

  if (get_template_name() === 'page-customer-voice.php' && $paged > 0) {
    $page_title = esc_html(get_the_title());
    $title = "{$page_title}（{$paged}ページ目）｜{$site_title}";
  }

  return $title;
}
add_filter('wpseo_title', 'change_customer_page_title');

// お客様の声の2ページ目以降のデスクリプションの設定
function page_second_and_after_customer_voice_description($description) {
  global $paged;

  if (is_page('customer-voice') && $paged > 0) {
    $description = str_replace(["\r\n", "\r", "\n", ' '], '', generate_description());
    return $description;
  }

  return $description;
}
add_filter('wpseo_metadesc', 'page_second_and_after_customer_voice_description');

// お客様のお声ページに独自のcanonicalタグを設定
function change_customer_voice_canonical_tag($url) {
  global $paged;

  if (get_template_name() === 'page-customer-voice.php' && $paged > 0) {
    $url = "{$url}page/{$paged}/";
  }

  return $url;
}
add_filter('wpseo_canonical', 'change_customer_voice_canonical_tag');

// お客様の声のページネーションにrel="prev" rel="next"を追加
function customer_voice_page_add_rel_prev_and_next() {
  if (is_page('customer-voice')) {
    global $paged;

    $query_instance = get_customer_voice();

    $last_page_num = (int) $query_instance->max_num_pages;

    if ($paged === 0) {
      echo PHP_EOL . '<link rel="next" href="'. get_pagenum_link(2) .'">' . PHP_EOL;
    } elseif($paged === $last_page_num) {
      echo PHP_EOL . '<link rel="prev" href="'. get_pagenum_link($paged - 1) .'">' . PHP_EOL;
    } else {
      echo PHP_EOL . '<link rel="prev" href="'. get_pagenum_link($paged - 1) .'">' . PHP_EOL;
      echo '<link rel="next" href="'. get_pagenum_link($paged + 1) .'">' . PHP_EOL;
    }
  }
}
add_action('wp_head', 'customer_voice_page_add_rel_prev_and_next');

// 都道府県ページに独自のタイトルタグを設定
function change_area_page_title($title) {
  global $paged;
  $site_title = esc_html(get_bloginfo('name'));

  if (is_page_template('page-pref.php')) {
    $page_title = esc_html(get_the_title());
    $title = "{$page_title}｜{$site_title}";
  }

  return $title;
}
add_filter('wpseo_title', 'change_area_page_title');

// アイテム一覧・エリア一覧・お役立ち記事一覧・施工事例一覧に独自のタイトルタグを設定
function change_archive_title($title) {
  global $paged;

  $site_title = esc_html(get_bloginfo('name'));

  if (is_post_type_archive('item_detail')) {
    $title = "水回りトラブルの記事一覧｜{$site_title}";

    if ($paged > 0) {
      $title = "水回りトラブルの記事一覧（{$paged}ページ目）｜{$site_title}";
    }
  }

  if (is_post_type_archive('article_detail')) {
    $title = "お役立ち記事一覧｜{$site_title}";

    if ($paged > 0) {
      $title = "お役立ち記事一覧（{$paged}ページ目）｜{$site_title}";
    }
  }

  if (is_post_type_archive('sekou_detail')) {
    $title = "施工事例一覧｜{$site_title}";

    if ($paged > 0) {
      $title = "施工事例一覧（{$paged}ページ目）｜{$site_title}";
    }
  }

  if (is_tax('item')) {
    $item_tag_slug = get_query_var('item');
    $taxonomy_name = get_term_by('slug', $item_tag_slug, 'item')->name;
    $title = "{$taxonomy_name}の記事一覧|{$site_title}";

    if ($paged > 0) {
      $title = "{$taxonomy_name}の記事一覧（{$paged}ページ目）｜{$site_title}";
    }
  }

  if (is_tax('sekou')) {
    $sekou_tag_slug = get_query_var('sekou');
    $taxonomy_name = get_term_by('slug', $sekou_tag_slug, 'sekou')->name;
    $title = "{$taxonomy_name}の施工事例一覧|{$site_title}";

    if ($paged > 0) {
      $title = "{$taxonomy_name}の施工事例一覧（{$paged}ページ目）｜{$site_title}";
    }
  }


  return $title;
}
add_filter('wpseo_title', 'change_archive_title');

// アーカイブページのデスクリプション設定
function setting_archive_article_description() {
  global $paged;

  $description = str_replace(["\r\n", "\r", "\n", " "], '', generate_description());

  if (is_post_type_archive(['item_detail', 'article_detail', 'sekou_detail'])) {
    if ($paged > 0) {
      $description = str_replace('一覧ページです', "一覧ページ（{$paged}ページ目）です", $description);

      echo "\n" . '<meta name="description" content="' . $description . '" />';
    } else {
      echo "\n" . '<meta name="description" content="' . $description . '" />';
    }
  }
}
add_action('wp_head', 'setting_archive_article_description');

// Yoast SEOでJSON-LDの出力をしない
function yoast_no_json_ld() {
  return false;
}
add_filter( 'wpseo_json_ld_output', 'yoast_no_json_ld' );

// Yoast SEO 抜粋をカスタム
function custom_length_meta_desc() {
  $post_content = get_the_content();
  $strip_content = strip_tags($post_content);
  $strip_content = str_replace(PHP_EOL, '', $strip_content);
  $strip_content = preg_replace('/\[.*?\]/', '', $strip_content);

  $substr_content = mb_substr($strip_content, 0, 160);
  return $substr_content;
}

// Yoast SEO 抜粋に関する変数を追加
function plugin_custom_yoast_meta_desc_variable() {
  wpseo_register_var_replacement('%%custom_excerpt%%', 'custom_length_meta_desc', 'advanced', 'コンテンツの先頭から160文字を抜粋します');
}
add_action('wpseo_register_extra_replacements', 'plugin_custom_yoast_meta_desc_variable');

// Yoast SEO separatorの追加
function add_custom_separator($separators) {
  return array_merge($separators, ['｜']);
}
add_filter('wpseo_separator_options', 'add_custom_separator');

// Yoast SEO Separatorの前後に自動で空白が入るので削除
function trim_title_separator($title) {
  if (isset($title)) {
    $title = str_replace(' ｜ ', '｜', $title);
  }
  return $title;
}
add_filter('wpseo_title', 'trim_title_separator');

// Yoast SEO sitemapから除外するページを指定
function sitemap_exclude_pages() {
  $page_obj = get_page_by_path('area');
  $page_ids[] = $page_obj->ID;
  // フロントページが重複して出力されているので削除
  $page_ids[] = get_option('page_on_front');

  return $page_ids;
}
add_filter( 'wpseo_exclude_from_sitemap_by_post_ids', 'sitemap_exclude_pages' );

/* ------------------------------
 ファーストビュー
------------------------------ */
// 認定書の画像の切替
function switch_certification_img() {

  $base_img_path = esc_url(get_template_directory_uri()) . '/img';
  $post_title = get_the_title(get_the_ID());
  $img_path = $alt = $class_name = null;

  $default_class_name = 'default';
  $alt_tag_name = '複数';

  // エリア詳細かどうかチェックする
  if (is_singular('area_detail')) {
    // altに設定するエリア名を取得する
    if (preg_match("/(東京都|千葉市|横浜市|横浜市|名古屋市|京都市|神戸市)/u", $post_title, $match)) {
      $alt = $match[0];
    }

    if (preg_match('/^東京都/u', $post_title)) {
      $img_path = "{$base_img_path}/certification_tokyo.png?20210512";
    } else if (preg_match('/千葉市/u', $post_title)) {
      $img_path = "{$base_img_path}/certification_chiba.png?20210512";
    } else if (preg_match('/横浜市/u', $post_title)) {
      $img_path = "{$base_img_path}/certification_yokohama.png?20210512";
    } else if (preg_match('/名古屋市/u', $post_title)) {
      $img_path = "{$base_img_path}/certification_nagoya.png?20210512";
    } else if (preg_match('/京都市/u', $post_title)) {
      $img_path = "{$base_img_path}/certification_kyoto.png?20210512";
    } else if (preg_match('/神戸市/u', $post_title)) {
      $img_path = "{$base_img_path}/certification_kobe.png?20210512";
    } else {
      $img_path = "{$base_img_path}/certifications.png?20210512";
      $class_name = $default_class_name;
      $alt = $alt_tag_name;
    }
  } else {
    $img_path = "{$base_img_path}/certifications.png?20210512";
    $class_name = $default_class_name;
    $alt = $alt_tag_name;
  }

  ob_start();
  ?>
    <img class="certification-img <?= $class_name ?>" src="<?= $img_path ?>" width="80" height="110" alt="認定書 <?= $alt ?>">
  <?php
  $img_tag= ob_get_contents();
  ob_end_clean();

  return $img_tag;
}

// 認定書の番号の切替
function get_certificate_number($post_title) {
  // 分岐にあるエリアのみ〇〇号を表示する
  if (preg_match('/^東京都/u', $post_title)) {
    return '<span class="number">' . '（第9712号）' . '</span>';
  } else if (preg_match('/千葉市/u', $post_title)) {
    return '<span class="number">' . '（第448号）' . '</span>';
  } else if (preg_match('/横浜市/u', $post_title)) {
    return '<span class="number">' . '（第3008号）' . '</span>';
  } else if (preg_match('/名古屋市/u', $post_title)) {
    return '<span class="number">' . '（第1437号）' . '</span>';
  } else if (preg_match('/京都市/u', $post_title)) {
    return '<span class="number">' . '（第369号）' . '</span>';
  } else if (preg_match('/神戸市/u', $post_title)) {
    return '<span class="number">' . '（第71474号）' . '</span>';
  } else {
    return;
  }
}

/* ------------------------------
 管理画面に関するカスタマイズ
------------------------------ */
// カスタマイザーから編集可能な項目を削除
function remove_customize_section($wp_customize) {
  $wp_customize->remove_section('title_tagline');
  $wp_customize->remove_panel('nav_menus');
  $wp_customize->remove_section('static_front_page');
  $wp_customize->remove_section('custom_css');
}
add_action('customize_register', 'remove_customize_section', 99);

// エディターが不要な編集画面のエディターを非表示にする
add_filter('use_block_editor_for_post', function($use_block_editor, $post){
  if ($post->post_type === 'page') {
    // 非表示にしているページ
    // * よくある質問
    // * アイテム一覧
    // * エリア一覧
    // * 都道府県ページ
    // * お役立ち記事一覧
    // * お客様の声
    // * 料金ページ
    // * トップ
    $post_slugs = ['questions', 'item', 'area', 'article', 'customer-voice', 'price', 'front'];

    if (in_array($post->post_name, $post_slugs)) {
      remove_post_type_support('page', 'editor');
      return false;
    }
  }

  return $use_block_editor;
}, 10, 2);

// 詳細ページの編集画面にスタイルを適用
function wpdocs_theme_add_editor_styles() {
  add_editor_style('editor-style.css');
}
add_action('admin_init', 'wpdocs_theme_add_editor_styles');

/* ------------------------------
 テンプレート内で使用する関数
------------------------------ */
// 電話番号を返す
function get_phone_number() {
  return '0120-579-007';
}

// 電話番号に添える注意書きを返す
function get_tel_annotation() {
  return '※水道事務局（クリーンライフ）に繋がります';
}

/* ------------------------------
 トップページ
------------------------------ */

// 取扱メーカーの画像のファイル名とalt
function maker_img_and_alt_name() {
  return [
    'toto' => 'TOTO',
    'lixil'=> 'LIXIL',
    'inax' => 'INAC',
    'panasonic' => 'Panasonic',
    'paloma' => 'Paloma',
    'rinnai' => 'Rinnai',
    'noritz' => 'NORITZ',
    'cleanup' => 'クリナップ'
  ];
}

// モーダルウィンドウとして表示するメーカーの対応シリーズ
function makers_series() {
  return [
    'lixil' => [
      'アメージュZ',
      'サティス S/G/E',
      'アステオ',
      'Lセレクション  LC節水便器',
      'プレアス',
      'アメージュZA',
      'リフォレ'
    ],
    'panasonic' => [
      'アラウーノ',
      'アラウーノS160/S141',
      'アラウーノL150',
      'アラウーノS2',
      '新型アラウーノ',
      'アラウーノＶ',
      'NewアラウーノV',
      'Newアラウーノ'
    ]
  ];
}

// モーダルウィンドウとして表示するメーカーの対応シリーズ（型番つき）
function makers_series_withNumber() {
  return [
    'toto' => [
      'ピュアレスト QR' => 'CS232B, CS232BM, SH233BA, SH232BA, CS230B',
      'ピュアレスト EX' => 'CS400B, CS400BM, CS260B, CS325BPR, CS330B',
      'ピュアレスト MR' => 'CS215BPR, SH215BAS, CS215BP, SH215BAJS, S564',
      'GGシリーズ' => 'CS820B, CS870B, CS870BM, CS890B, CS820BH',
      'ネオレストRH / AH / DH' => 'CES9565R, CES9564, CES9564M, CES9564W, CES9565',
      'ZJ1/ZR1シリーズ' => 'CES9151, CES9150, CES9155M, CES9154M, CES9151P'
    ],
  ];
}

// よくある質問を取得
function get_page_questions() {
  $page_questions = [];

  $page_id = get_page_by_path('questions')->ID;
  $questions = get_field('questions', $page_id);

  foreach ($questions as $question) {
    $questions_repeater_field = $question['questions_repeater_field'];

    foreach ($questions_repeater_field as $field) {
      $page_questions[] = [
        'question' => $field['question'],
        'answer' => $field['answer'],
      ];
    }
  }
  return $page_questions;
}

// トップページに表示するよくある質問を取得
function get_top_page_questions() {
  $top_page_questions = [];

  if (is_home() || is_front_page()) {
    $page_id = get_page_by_path('questions')->ID;
    $questions = get_field('questions', $page_id);

    foreach ($questions as $question) {
      $questions_repeater_field = $question['questions_repeater_field'];

      foreach ($questions_repeater_field as $field) {
        if ($field['is_top_view']) {
          $top_page_questions[] = [
            'question' => $field['question'],
            'answer' => $field['answer'],
          ];
        }
      }
    }
  }
  return $top_page_questions;
}

// エリアページに表示するよくある質問を取得
function get_area_page_questions() {
  $area_page_questions = [];

  if (is_page_template('page-pref.php') || is_singular('area_detail')) {
    $area_name = get_area_name();
    $page_id = get_page_by_path('area_questions')->ID;
    $post_id = get_the_ID();
    $item_slug = get_term_slug($post_id, 'item');

    if($item_slug == 'toilet' || $item_slug == '') {
      $area_faqs = get_field('area_faqs', $page_id);
    } elseif($item_slug == 'water-pipe') {
      $area_faqs = get_field('area_faqs_waterpipe', $page_id);
    } elseif($item_slug == 'bath') {
      $area_faqs = get_field('area_faqs_bath', $page_id);
    }

    foreach ($area_faqs as $area_faq) {
      $area_question_replace = str_replace('{area_name}', $area_name , $area_faq['area_question']);
      $area_answer_replace = str_replace('{area_name}', $area_name , $area_faq['area_answer']);

      $area_page_questions[] = [
        'question' => $area_question_replace,
        'answer' => $area_answer_replace,
      ];
    }
  }
  return $area_page_questions;
}

// 各エリアページのエリア名を取得
function get_area_name() {
  $area_name = '';

  if (is_page_template('page-pref.php')) {
    $area_name = get_pref_name();
  } elseif (is_singular('area_detail')) {
    $post_id = get_the_ID();
    if (get_field('small_area_page')) {
      $area_name = get_field('small_area_page');
    } else {
      $pref_and_city_name = get_the_terms($post_id, 'area')[0];
      $pref_and_city_name = $pref_and_city_name->name;
      $area_name = city_page_replacement_title($pref_and_city_name);
    }
  }

  return $area_name;
}

/* ------------------------------
 CTA
------------------------------ */

// CTAで使用する独自のエンドポイントの設定
function add_rest_original_endpoint() {
  // パラメータにエンコードされた文字列を指定できるようにする
  register_rest_route('wp/custom/v1', '/find_area/(?P<area_name>[a-zA-Z0-9|%]+)', [
    'methods' => 'GET',
    'callback' => 'find_area',
  ]);
  register_rest_route('wp/custom/v1', '/find_area_and_detail/(?P<area_name>[a-zA-Z0-9|%]+)/(?P<item_name>[a-zA-Z0-9|%]+)', [
    'methods' => 'GET',
    'callback' => 'find_area_and_detail',
  ]);
  register_rest_route('wp/custom/v1', '/exec_geocoding_api/', [
    'methods' => 'POST',
    'callback' => 'exec_geocoding_api',
  ]);
}
add_action('rest_api_init', 'add_rest_original_endpoint');

// 現在地を元にエリア（都道府県 + 市区町村）を取得するためのエンドポイント
function find_area($data) {
  global $wpdb;

  $area_name = urldecode($data['area_name']);

  $query = $wpdb->prepare(
    "SELECT * FROM wp_terms WHERE name LIKE %s",
    '%' . $wpdb->esc_like($area_name) . '%'
  );

  $row = $wpdb->get_row($query);

  if (!$row) {
    $response = [
      'status' => false,
      'message' => 'パラメータに設定されたエリアはデータベースに登録されていません',
    ];
  } else {
    $response = [
      'status' => true,
      'data' => [
        'area_name' => $row->name,
      ]
    ];
  }

  return $response;
}

// アイテム詳細ページからリクエストが送られた時に使用するためのエンドポイント
function find_area_and_detail($data) {
  global $wpdb;

  $area_name = urldecode($data['area_name']);
  $item_name = urldecode($data['item_name']);

  $query = $wpdb->prepare(
    "SELECT * FROM wp_terms WHERE name LIKE %s",
    '%' . $wpdb->esc_like($area_name) . '%'
  );

  $row = $wpdb->get_row($query);

  if (!$row) {
    $response = [
      'status' => false,
      'message' => 'パラメータに設定されたエリアはデータベースに登録されていません',
    ];
  } else {
    // 関連記事がない時はnullが返ってくる
    $area_page_slug = get_area_page_obj($area_name, $item_name)[0]->post_name;

    $response = [
      'status' => true,
      'data' => [
        'area_name' => $row->name,
        'item_name' => $item_name,
        'area_page_slug' => $area_page_slug,
      ]
    ];
  }

  return $response;
}

// Google Geocoding APIを実行するエンドポイント
function exec_geocoding_api($data) {
  $latitude = empty($data['latitude']) ? false : $data['latitude'];
  $longitude = empty($data['longitude']) ? false : $data['longitude'];

  if (!is_numeric($latitude) || !is_numeric($longitude)) {
    return;
  }

  $domain_name = $_SERVER['HTTP_HOST'];
  if (0 === strpos($domain_name, 'localhost')) {
    $ApiKey = GEOCODE_API_KEY_DEV;
  } elseif ($domain_name === 'staging-jsgt.stg-s.snapup.jp') {
    $ApiKey = GEOCODE_API_KEY_STG;
  } else {
    $ApiKey = GEOCODE_API_KEY_PRD;
  }

  $url = "https://maps.google.com/maps/api/geocode/json?latlng={$latitude},{$longitude}&key={$ApiKey}";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Accept-Language: ja-JP'
  ));

  try {
    $output = curl_exec($ch);
  } catch (\Throwable $ex) {
    $output = 'APIのリクエストエラーが発生しました';
  }
  curl_close($ch);

  return $output;
}

// 現在地とアイテムにひもづく「アイテム × エリア」の記事を取得する
function get_area_page_obj($area_name, $item_name) {
  $args = [
    'post_type' => 'area_detail',
    'posts_per_page' => 1,
    'tax_query' => [
      [
        'taxonomy' => 'area',
        'field' => 'name',
        'terms' => $area_name,
      ],
      [
        'taxonomy' => 'item',
        'field' => 'name',
        'terms' => $item_name,
      ],
    ]
  ];

  $post_list = get_posts($args);

  return $post_list;
}

// CTAのショートコード
function cta_shortcode() {
  ob_start();
  get_template_part('template-parts/new', 'cta');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('CTA', 'cta_shortcode');

// 大きなCTAのショートコード
function cta_big_shortcode() {
  ob_start();
  get_template_part('template-parts/new', 'cta-2');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('CTA_big', 'cta_big_shortcode');

/* ------------------------------
 お客様の声
------------------------------ */

// お客様の声を取得する
function get_customer_voice() {
  global $paged;

  $args = [
    'post_type' => 'cusutomer_voice',
    'posts_per_page' => 10,
    'paged' => $paged,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
  ];

  $query_instance = new WP_Query($args);

  return $query_instance;
}

// カスタムタクソノミーのスラッグを取得
function get_term_slug($id, $taxonomy) {
  $term_slug = '';
  $term_list = get_the_terms($id, $taxonomy);

  if ($term_list) {
    $term_slug = $term_list[0]->slug;
  }

  return $term_slug;
}

// カスタムタクソノミーの名前を取得
function get_term_name($id, $taxonomy) {
  $term_name = '';
  $term_list = get_the_terms($id, $taxonomy);

  if ($term_list) {
    $term_name = $term_list[0]->name;
  }

  return $term_name;
}

/* ------------------------------
 アイテム一覧・エリア一覧
------------------------------ */

// ページネーションを出力
function archive_paginate() {
  global $wp_query;

  echo paginate_links([
    'total' => $wp_query->max_num_pages,
    'current' => max(1, get_query_var('paged')),
    'prev_text' => '＜ 前へ',
    'next_text' => '次へ ＞',
  ]);
}

// エリアページの子ページを取得し、地方ごとに分類した配列を生成する処理
function get_prefname_obj($args) {
  $area_posts = get_posts($args);

  if (!$area_posts) return;

  // エリア名の配列を生成する処理
  $sorted_pref_pages = [];

  foreach ($area_posts as $area_post) {
    $post_id = $area_post->ID;
    $field = get_field_object('area_select', $post_id);
    $value = get_field('area_select',  $post_id);

    $area_name = $field['choices'][$value];

    if (!isset($sorted_pref_pages[$area_name])) {
      $sorted_pref_pages[$area_name] = [];
    }

    $sorted_pref_pages[$area_name][] = $area_post;
  }

  return $sorted_pref_pages;
}

// アイテムページに表示するタグの一覧を生成
function get_item_tags() {
  $terms = get_terms('item');

  $term_list = [];

  foreach ($terms as $term) {
    $term_name = $term->name;

    // 親タームのみ行う処理
    if (!isset($term_list[$term_name]) && $term->parent === 0) {
      $term_list[$term_name] = [];

      $term_id = $term->term_id;
      $term_children = get_term_children($term_id, 'item');

      // 親に紐づく子タクソノミーが存在する時のみ処理を行う
      if (!is_wp_error($term_children) && !empty($term_children)) {
        foreach ($term_children as $child_id) {
          $term = get_term_by('id', $child_id, 'item');
          $term_link = get_term_link($child_id);

          $term_list[$term_name][] = [
            'term_link' => $term_link,
            'term_name' => $term->name
          ];
        }
      } else {
        unset($term_list[$term_name]);
      }
    }
  }

  return $term_list;
}

// 施工事例ページのタグを取得する

function get_sekou_tags() {
  $args = [
    'orderby' => 'id',
    'hide_empty' => false,
    'order' => 'ASC'
  ];
  $terms = get_terms('sekou', $args);
  return $terms;
}

// 施工事例ページの指定タグ以外の記事一覧を取得する
function get_sekou_other_articles($tag_slug) {
  $args = [
    'post_type' => 'sekou_detail',
    'post_status' => 'publish',
    'posts_per_page' => 6,
    'tax_query' => [
      [
        'taxonomy' => 'sekou',
        'field' => 'slug',
        'terms' => $tag_slug,
        'operator' => 'NOT IN',
      ],
    ]
  ];
  $other_articles = new WP_query($args);

  return $other_articles;
}

/* ------------------------------
 都道府県ページ
------------------------------ */

// 都道府県ページ・エリア詳細に紐付けたい市区町ページを取得
function get_city_pages($pref_name) {
  global $wpdb;

  $rows = $wpdb->get_results(
    $wpdb->prepare(
      "SELECT p.* FROM wp_posts AS p
        JOIN wp_term_relationships AS r
          ON p.ID=r.object_id
        JOIN wp_terms AS t
          ON r.term_taxonomy_id=t.term_id
        JOIN wp_postmeta AS meta
          ON p.ID = meta.post_id
        WHERE p.post_status='publish'
          AND p.post_type='area_detail'
          AND p.post_parent=0
          AND t.name LIKE %s
          AND meta.meta_key='city_page_ruby'
          ORDER BY meta.meta_value ASC",
      $wpdb->esc_like($pref_name) . '%'
    )
  );

  $sorted_city_posts = [];

  foreach ($rows as $row) {
    $city_page_id = $row->ID;

    // エリア詳細ページに紐づくアイテムタグのオブジェクトを取得する
    $terms = get_the_terms($city_page_id, 'item');

    foreach ($terms as $term) {
      // 親タクソノミーの時のみ処理を行う
      if ($term->parent === 0) {
        $item_name = $term->name;

        if (!isset($sorted_city_posts[$item_name])) {
          $sorted_city_posts[$item_name] = [];
        }

        $sorted_city_posts[$item_name][] = $row;
      }
    }
  }

  return $sorted_city_posts;
}

// 記事タイトルの整形
function city_page_replacement_title($pref_and_city_name) {
  // エリア詳細に紐づくエリアのタクソノミーから、市区町村名のみを抜きだす
  $city_name = preg_replace('/(東京都|北海道|(京都|大阪)府|.{2,3}県)/u', '', $pref_and_city_name, 1);
  return $city_name;
}

// 都道府県と紐づくお客様の声を表示
function get_customer_voice_linked_to_pref($pref, $item_slug) {
  global $wpdb;
  // 該当都道府県の口コミIDを取得
  $query = "
  SELECT
    ID
  FROM
    wp_posts t1
  INNER JOIN wp_term_relationships t2 ON
    t1.ID = t2.object_id
  INNER JOIN wp_terms t3 ON
    t2.term_taxonomy_id = t3.term_id
  INNER JOIN wp_term_relationships t4 ON
    t1.ID = t4.object_id
  INNER JOIN wp_terms t5 ON
    t4.term_taxonomy_id = t5.term_id
  WHERE
    t1.post_type = 'cusutomer_voice' AND
    t1.post_status = 'publish' AND
    t3.name LIKE '%$pref%' AND
    t5.slug = '$item_slug'
  ORDER BY
    t1.post_date
  DESC
  ";
  $results = $wpdb->get_results($query);
  $results_simplified = [];
  foreach($results as $result) {
    array_push($results_simplified, $result->ID);
  }
  return $results_simplified;
}

// 出動時間別に市区町村ページデータを並び替える
function sort_city_pages_by_time_required($city_pages) {
  $cities_sortby_time_required = [];
  $cities_other = [];
  foreach($city_pages as $city_page) {
    $city_id = $city_page->ID;
    $time_required = get_time_required_by_city($city_id);
    if (empty($time_required)) {
      $cities_other[] = $city_id;
    } else {
      $sort_label = $time_required['value'] . ':' . $time_required['label'];
      $cities_sortby_time_required[$sort_label][] = $city_id;
    }
  }

  if (empty($cities_sortby_time_required)) {
    return;
  }
  ksort($cities_sortby_time_required);

  $cities_sortby_time_required_key_fixed = [];
  foreach($cities_sortby_time_required as $key => $value) {
    $replaced_key = preg_replace("/^\d+:/", "", $key);
    $cities_sortby_time_required_key_fixed[$replaced_key] = $value;
  }

  $cities_sortby_time_required_key_fixed['その他対応エリア'] = $cities_other;

  return $cities_sortby_time_required_key_fixed;
}

/* ------------------------------
 エリア詳細（市区町村ページ）
------------------------------ */

// エリア詳細と紐づくお客様の声を表示できる
function get_customer_voice_linked_to_area($area_taxonomy, $item_slug) {
  $args = [
    'post_type' => 'cusutomer_voice',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
    'tax_query' => [
      [
        'taxonomy' => 'area',
        'field' => 'slug',
        'terms' => $area_taxonomy,
      ],
      [
        'taxonomy' => 'item',
        'field' => 'slug',
        'terms' => $item_slug,
      ],
    ]
  ];

  $voice_id_list = get_posts($args);
  $city_voice_id_list = [];
  foreach ($voice_id_list as $voice_id_post) {
    $city_voice_id_list[] = $voice_id_post->ID;
  }

  return $city_voice_id_list;
}

// 小エリア詳細と紐づくお客様の声を表示できる
function get_customer_voice_linked_to_small_area($post_id) {
  $args = [
    'post_type' => 'cusutomer_voice',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
    'meta_key' => 'small_area_id',
    'meta_value' => '"'.$post_id.'"',
	  'meta_compare' => 'LIKE',
    'fields' => 'ids'
  ];

  $voice_id_list = get_posts($args);

  return $voice_id_list;
}

// エリア詳細の記事から都道府県名のみを抜きだす
function get_pref_name() {
  $pref_str_pattern = '/(東京都|北海道|(?:京都|大阪)府|.{2,3}県)/u';

  // 都道府県ページ
  if (is_page_template('page-pref.php')) {
    $pref_name = get_field('big_area_name');
    return $pref_name;
  }

  // 市区町村ページ
  if (is_singular('area_detail') && !get_field('show_small_area')) {
    $post_id = get_the_ID();
    $post_terms = get_the_terms($post_id, 'area');
    $city_term_name = $post_terms[0]->name;
    preg_match($pref_str_pattern, $city_term_name, $match);
  }

  // 小エリアページ
  if (is_singular('area_detail') && get_field('show_small_area')) {
    $parent_id = get_post_parent()->ID;
    $parent_terms = get_the_terms($parent_id, 'area');
    $small_city_term_name = $parent_terms[0]->name;
    preg_match($pref_str_pattern, $small_city_term_name, $match);
  }

  if (empty($match)) return;

  $pref_name = $match[0];

  if (!is_string($pref_name)) return;

  return $pref_name;
}

// 都道府県名から都道府県ページのIDを取得
// 親ページが対応エリア一覧ページかつ、都道府県名が一致するページのIDを取り出す
function get_pref_id($pref_name) {
  $area_page_id = get_page_by_path('area', OBJECT)->ID;
  $args = [
    'post_type' => 'page',
    'post_status' => 'publish',
    'post_parent' => $area_page_id,
    'meta_key' => 'big_area_name',
    'meta_value' => $pref_name,
    'posts_per_page' => 1
  ];
  $pref_page = get_posts($args);

  if(isset($pref_page[0]->ID)) {
    return $pref_page[0]->ID;
  }
}

// 都道府県ページを取得
function get_pref_page($area_page_id) {

  $pref_name = get_pref_name();
  $post_id = get_the_ID();

  if(is_singular('area_detail') && get_field('show_small_area')) {
    $item_slug = 'toilet';
  } else {
    $item_slug = get_term_slug($post_id, 'item');
  }

  $row = get_posts([
    'posts_per_page' => 1,
    'post_type' => 'page',
    'post_parent' => $area_page_id,
    'meta_query' => [
      [
        'key' => 'big_area_name',
        'value' => $pref_name,
      ]
    ],
    'tax_query' => [
      [
        'taxonomy' => 'item',
        'field'    => 'slug',
        'terms'    => $item_slug
      ]
    ]
  ]);

  $post_id = $row[0]->ID;

  return [
    'pref_name' => $pref_name,
    'post_id' => $post_id,
  ];
}

// エリア詳細のパンクずをカスタマイズ
function breadcrumb_customize($bcn_obj) {
  $post_id = get_the_ID();
  $item_slug = get_term_slug($post_id, 'item');

  if($item_slug == 'toilet' || is_singular('area_detail') && get_field('show_small_area')) {
    $text_per_item = 'のトイレのつまり・水漏れ修理';
  } elseif($item_slug == 'water-pipe') {
    $text_per_item = 'の水道管の水漏れ・つまり修理';
  } elseif($item_slug == 'bath') {
    $text_per_item = 'のお風呂の蛇口交換・水漏れ修理';
  }

  if (is_singular('area_detail')) {

    // エリアページを取得
    $area_page_id = get_page_by_path('area', OBJECT)->ID;

    // 都道府県ページを取得
    $pref_page = get_pref_page($area_page_id);
    $pref_name = $pref_page['pref_name'];
    $pref_page_id = $pref_page['post_id'];


    if (!isset($area_page_id) || !isset($pref_page_id)) return;

    // 都道府県ページのパンくずオブジェクトを生成する
    $pref_page_url = get_the_permalink($pref_page_id);
    $pref_name .= $text_per_item;
    $pref_page_bcn_obj = new bcn_breadcrumb($pref_name, '', [], $pref_page_url, null, true);

    // サイトタイトルのパンくずのオブジェクトのみを退避させる
    $site_title_bcn_obj = array_pop($bcn_obj->breadcrumbs);

    $pref_name = get_pref_name();

    if(get_field('small_area_page')) {
      $parent_id = get_post_parent()->ID;
      $post_terms = get_the_terms($parent_id, 'area');
      $city_area_url = get_the_permalink($parent_id);
      $city_area_name = $post_terms[0]->name;
      $city_area_name_replace = str_replace($pref_name, '', $city_area_name);
      $city_area_bcn_obj = new bcn_breadcrumb($city_area_name_replace, '', [], $city_area_url, null, true);
      $city_area_bcn_obj->set_title($city_area_name_replace . 'のトイレのつまり・水漏れ修理');

      $small_area_name = get_field('small_area_page');
      $small_area_bcn_obj = new bcn_breadcrumb($small_area_name, '', [], null, true);
      $small_area_bcn_obj->set_title($small_area_name . 'のトイレのつまり・水漏れ修理');

      $bcn_obj->breadcrumbs[] = $small_area_bcn_obj;
      $bcn_obj->breadcrumbs[] = $city_area_bcn_obj;
      $bcn_obj->breadcrumbs[] = $pref_page_bcn_obj;
      $bcn_obj->breadcrumbs[] = $site_title_bcn_obj;
      array_shift($bcn_obj->breadcrumbs);
    } else {
      $post_id = get_the_ID();
      $post_terms = get_the_terms($post_id, 'area');
      $city_area_name = $post_terms[0]->name;
      $city_area_name_replace = str_replace($pref_name, '', $city_area_name);
      $city_area_bcn_obj = new bcn_breadcrumb($city_area_name_replace, '', [], null, true);
      $city_area_bcn_obj->set_title($city_area_name_replace . $text_per_item);

      $bcn_obj->breadcrumbs[] = $city_area_bcn_obj;
      $bcn_obj->breadcrumbs[] = $pref_page_bcn_obj;
      $bcn_obj->breadcrumbs[] = $site_title_bcn_obj;
      array_shift($bcn_obj->breadcrumbs);
    }
  } elseif (get_template_name() === 'page-pref.php') {
    // パンくずの都道府県ページを取り出す
    $pref_page_bcn_obj = array_shift($bcn_obj->breadcrumbs);
    array_shift($bcn_obj->breadcrumbs);

    // タイトルの変更
    $pref_name = get_pref_name();
    $pref_page_bcn_obj->set_title($pref_name . $text_per_item);

    // パンくずの都道府県ページを再設定
    array_unshift($bcn_obj->breadcrumbs, $pref_page_bcn_obj);
  } elseif (is_singular(['item_detail' ,'article_detail'])) {
    if(get_field('parent_article')) {
      // 記事一覧ページを取り出す
      $site_title_bcn_obj = array_pop($bcn_obj->breadcrumbs);
      array_pop($bcn_obj->breadcrumbs);

      // CMSから自ページのパンくずのタイトル変更
      if(get_field('breadcrumbs_field')) {
        $breadcrumbs_field = get_field('breadcrumbs_field');
        $bcn_obj->breadcrumbs[0]->set_title($breadcrumbs_field);
      }

      // CMSから親ページのパンくずを生成
      $parent_article_id = get_field('parent_article')[0]->ID;
      $parent_article_title = get_the_title($parent_article_id);
      $parent_article_url = get_the_permalink($parent_article_id);
      $parent_article_bcn_obj = new bcn_breadcrumb($parent_article_title, '', [], $parent_article_url, null, true);
      $bcn_obj->breadcrumbs[] = $parent_article_bcn_obj;

      // CMSから親ページのパンくずのタイトル変更
      if(get_field('breadcrumbs_field', $parent_article_id)) {
        $breadcrumbs_field = get_field('breadcrumbs_field', $parent_article_id);
        $parent_article_bcn_obj->set_title($breadcrumbs_field);
      }

      // トップページの投稿ID
      $top_page_id = 47;

      // 親ページの投稿タイプを判別
      $parent_article_post_type = get_post_type($parent_article_id);

      // 親ページが記事ページだった場合に記事一覧ページを追加
      if($parent_article_post_type !== 'page' && !get_field('parent_article', $parent_article_id)) {
        $parent_article_post_type_name = get_post_type_object($parent_article_post_type)->labels->name;
        $parent_article_post_type_url = get_post_type_archive_link($parent_article_post_type);
        $article_type_bcn_obj = new bcn_breadcrumb($parent_article_post_type_name, '', [], $parent_article_post_type_url, null, true);
        $bcn_obj->breadcrumbs[] = $article_type_bcn_obj;
      }

      // 親ページがトップページ以外の固定ページだった場合にトップページを追加
      if($parent_article_id !== $top_page_id && !get_field('parent_article', $parent_article_id)) {
        $bcn_obj->breadcrumbs[] = $site_title_bcn_obj;
      }

      // CMSから最上の親ページのパンくずを生成
      if(get_field('parent_article', $parent_article_id)) {
        $parent_page_id = get_field('parent_article', $parent_article_id)[0]->ID;
        $parent_page_title = get_the_title($parent_page_id);
        $parent_page_url = get_the_permalink($parent_page_id);
        $parent_page_bcn_obj = new bcn_breadcrumb($parent_page_title, '', [], $parent_page_url, null, true);
        $bcn_obj->breadcrumbs[] = $parent_page_bcn_obj;

        // 親ページがトップページ以外の固定ページだった場合にトップページを追加
        if($parent_page_id !== $top_page_id) {
          $bcn_obj->breadcrumbs[] = $site_title_bcn_obj;
        }
      }
    } elseif(get_field('breadcrumbs_field')) {
      $breadcrumbs_field = get_field('breadcrumbs_field');
      $bcn_obj->breadcrumbs[0]->set_title($breadcrumbs_field);
    }
  }
}
add_action('bcn_after_fill', 'breadcrumb_customize');

// 該当市区町村の施工実績数データを取得
function get_records_per_city($city_id) {
  $area_taxonomy_obj = get_the_terms($city_id, 'area');

  $records_page = get_page_by_path('records-per-city');
  $records_rows = get_field('records_per_city', $records_page->ID);
  $records = [];
  foreach($records_rows as $records_row) {
    if ($records_row['city_term'] === $area_taxonomy_obj[0]->term_id) {
      $record = [
        'toilet' => $records_row['records_toilet'],
        'kitchen' => $records_row['records_kitchen'],
        'bath' => $records_row['records_bath'],
        'sewage' => $records_row['records_sewage'],
      ];
      $records_areas = $records_row['area_list_txt'];
      $records_total = array_sum($record);
      $records = [
        'record' => $record,
        'total' => $records_total,
        'areas' => $records_areas
      ];
      break;
    }
  }
  return $records;
}
// 該当市区町村の出動時間を取得
function get_time_required_by_city($city_id) {
  $time_required = [];
  $term_obj = get_the_terms($city_id, 'area');
  if (!$term_obj) return;
  $time_page = get_page_by_path('city-time-required');
  $time_rows = get_field('city_time_required', $time_page->ID);
  $time_required = "";
  foreach($time_rows as $time_row) {
    if ($time_row['city_term'] === $term_obj[0]->term_id) {
      $time_required = $time_row['city_time'];
      break;
    }
  }
  return $time_required;
}
// エリア詳細に挿入するショートコード
function trouble_shortcode() {
  $template_path = esc_url(get_template_directory_uri());
  $phone_number = get_phone_number();

  $html = cta_shortcode();
  $html .= <<<EOM

<section class="section-1 no-trouble">
  <div class="container">
    <div class="heading">
      <img class="left man-img" src="{$template_path}/img/man-1.png" width="309" height="528" alt="男性">
      <div class="right">
        <img class="no-trouble-img" src="{$template_path}/img/no-trouble-1.png?20210512" width="551" height="125" alt="トラブルは絶対にあり得ません！">
        <p class="text">トラブルを起こさない<br class="is-sp">自信があるから、<br>
          お渡しする名刺には<br class="is-sp">専用クレーム窓口の電話番号を<br class="is-sp">記載しています。</p>
      </div>
    </div>
    <div class="text-area">
      <div class="text-box">
        <div class="text-container">
          <span class="sub-heading">お近くのエリア担当者からのメッセージ</span>
          <div class="heading">お近くで安い水道修理業者をお探しなら、<br class="is-pc">
          地域最安値を目指す水道修理ルートへ!</div>
          <p>お近くで安い水道修理業者をお探しなら、水道修理ルートにおまかせください。<br>
          地域最安値を目指す私たちは、最低5,500円～の格安料金に加えて、出張料金や見積もり費用も完全無料で承ります。<br>
          ご依頼は24時間受け付けておりますので、深夜や早朝の水道のつまり・水漏れトラブルにも対応可能です。<br>
          また、最短15分で駆け付けるスピーディーな対応もお近くのお客様から評判をいただける理由の一つ。<br>
          水道のつまりや水漏れだけでなく、悪臭や赤水、お湯が出ないなども<br>
          お気軽にお近くの水道修理ルートまでお問い合わせください。</p>
        </div>
      </div>
    </div>
  </div>
</section>
EOM;

  return $html;
}
add_shortcode('trouble', 'trouble_shortcode');

// エリア詳細に挿入するショートコード
function bottakuri_shortcode() {
  ob_start();
  get_template_part('template-parts/caution');
  get_template_part('template-parts/crown');
  get_template_part('template-parts/new', 'cta');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('bottakuri', 'bottakuri_shortcode');

// 吹き出しのショートコード
function fukidashi_shortcode($attr, $content) {
  $template_path = esc_html(get_template_directory_uri());

  $html = <<<EOM
  <div class="balloon">
    <div class="faceicon"><img src="{$template_path}/img/men-fukidashi.png" alt=""></div>
    <div class="chatting">
      <div class="talk-box">{$content}</div>
    </div>
  </div>
EOM;
  return $html;
}
add_shortcode('fukidashi', 'fukidashi_shortcode');

// 料金表のショートコード
// すべての料金表を出力
function price_all_shortcode() {
  ob_start();
  get_template_part('template-parts/price-list');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('price_all', 'price_all_shortcode');

//トイレのみの料金表を出力
function price_toilet_shortcode() {
  ob_start();
  get_template_part('template-parts/price-list', 'toilet');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('price_toilet', 'price_toilet_shortcode');

// 写真つきのトイレ料金パーツを出力
function price_toilet_with_img_shortcode() {
  ob_start();
  get_template_part('template-parts/price-list', 'with-img');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('price_toilet_with_img', 'price_toilet_with_img_shortcode');

// 申込の流れのショートコード
function service_flow_shortcode() {
  ob_start();
  get_template_part('template-parts/service-flow');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('service_flow', 'service_flow_shortcode');
// 支払い方法のショートコード
function payment_method_shortcode() {
  $template_path = esc_html(get_template_directory_uri());

  $html = <<<EOM
  <div id="price">
    <h2>お支払い方法</h2>
    <div class="contents">
      <div class="payment-method">
        <p>お支払い時に持ち合わせが無くても大丈夫です！水道修理ルートでは各種クレジットカード決済やコンビニ後払いなども対応しております！</p>
        <div class="imgs">
          <img class="img-top" src="{$template_path}/img/price-label-2.png" alt="コンビニ後払い対応">
          <img class="img-bottom" src="{$template_path}/img/header-credit-card-info.png?20210512" alt="各種クレジットカードOK">
        </div>
      </div>
    </div>
  </div>
EOM;

  return $html;
}
add_shortcode('payment_method', 'payment_method_shortcode');

// メーカーについて ショートコード
function maker_shortcode() {
  ob_start();
  get_template_part('template-parts/maker');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('maker', 'maker_shortcode');
// 三冠のショートコード
function crown_shortcode() {
  ob_start();
  get_template_part('template-parts/crown');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('crown', 'crown_shortcode');

// 対応エリア一覧のショートコード
function correspondence_area_shortcode() {
  ob_start();
  get_template_part('template-parts/city-correspondence-area');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('area', 'correspondence_area_shortcode');

// 施工事例コンテンツのショートコード
function construction_example_shortcode() {
  ob_start();
  get_template_part('template-parts/sekou-jirei');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('seko_jirei', 'construction_example_shortcode');

// 工務店情報のショートコード
function shop_info_shortcode() {
  ob_start();
  get_template_part('template-parts/shop-info');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('shop_info', 'shop_info_shortcode');

// 許可番号のショートコード
function admitted_number_shortcode() {
  ob_start();
  include('template-parts/admitted-number.php');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('admitted_number', 'admitted_number_shortcode');

// 対応エリアのショートコード

// 拠点情報のショートコード
function base_info_shortcode() {
  ob_start();
  include('template-parts/base-info.php');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('base_info', 'base_info_shortcode');

// 施工実績数のショートコード
function records_shortcode() {
  ob_start();
  include('template-parts/records-per-city.php');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('records', 'records_shortcode');

// 口コミのショートコード
function voice_shortcode() {
  ob_start();
  include('template-parts/voice.php');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('voice', 'voice_shortcode');


// 水道修理ルートが選ばれる理由
function beginners_guide_shortcode() {
  ob_start();
  include('template-parts/reason-of-choose.php');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('beginners_guide', 'beginners_guide_shortcode');


// 安すぎる価格表示にご注意ください。ショートコード
function cheap_price_shortcode() {
  ob_start();
  include('template-parts/caution.php');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('cheap_price', 'cheap_price_shortcode');




/* ------------------------------
 アイテム詳細・お役立ち記事詳細
------------------------------ */

// item_detailのみ 目次の下にCTAを設置
function add_cta_under_toc($content) {
  if (get_template_name() == 'single-item_detail.php') {
    $cta_html = do_shortcode('[CTA]');
    $replace_str = '$1' . $cta_html;
    return preg_replace('/(<div id=\"toc_container\" class=\"no_bullets\">.*?<\/div>)/', $replace_str, $content);
  }
  return $content;
}
// Plugin Table-of-content-plus の後に実行
add_filter( 'the_content', 'add_cta_under_toc', 101 );

// 設定されている親タクソノミーと子の関係にあるタクソノミーを全て取得
function get_item_and_article_related_tags($post_id) {
  if (is_singular(['item_detail', 'article_detail'])) {
    $terms = get_the_terms($post_id, 'item');

    // 親タクソノミーと子タクソノミーのみが設定されていない場合もリターンする
    if (!$terms && count($terms) === 2) return;

    $current_term_id  = array_pop($terms)->term_taxonomy_id;
    $parent_term_id = get_term($current_term_id, 'item')->parent;

    // 親タクソノミーが複数設定された場合も処理を中断する
    if ($parent_term_id === 0) return;

    $term_children_ids = get_term_children($parent_term_id, 'item');

    // 子のタクソノミーが1つしか存在しない場合は変数の割り当てを解除
    foreach ($term_children_ids as $key => $term_id) {
      if ($term_id === $current_term_id) {
        unset($term_children_ids[$key]);
      }
    }

    return [
      'parent_term_id' => $parent_term_id,
      'current_term_id' => $current_term_id,
      'term_children_ids' => $term_children_ids,
    ];
  }
}

// 関連記事を取得する
function get_item_and_article_related_posts($item_name, $per_page = -1) {
  $own_id = get_the_ID();
  $args = [
    'post_type' => ['item_detail', 'article_detail'],
    'post_status' => 'publish',
    'posts_per_page' => $per_page,
    'post__not_in' => [$own_id],
    'tax_query' => [
      [
        'taxonomy' => 'item',
        'field' => 'name',
        'terms' => $item_name,
      ],
    ]
  ];

  $query_instance = new WP_Query($args);

  return $query_instance;
}


/* ------------------------------
 アイテムタグ一覧ページ
------------------------------ */

// パンくずから不要な要素を削除する
function item_tag_list_breadcrumb_customize($bcn_obj) {
  // タグ一覧のパンくずは以下の構造になっている
  // 例: 水道修理ルート > アイテム一覧 > お風呂 > お風呂のつまり
  $breadcrumb_items = 4;

  if (is_tax('item') && count($bcn_obj->breadcrumbs) === $breadcrumb_items) {
    unset($bcn_obj->trail[1]);
    unset($bcn_obj->trail[2]);
  }
}
add_action('bcn_after_fill', 'item_tag_list_breadcrumb_customize');

/* ------------------------------
 検索結果
------------------------------ */

// 検索対象をアイテム詳細・エリア詳細・その他記事のみに限定
function search_filter( $query ) {
  if (!is_admin() && $query->is_main_query()) {
    if ($query->is_search) {
      $post_types = ['item_detail', 'area_detail', 'article_detail'];
      $query->set('post_type', $post_types);
    }
  }
}
add_action( 'pre_get_posts','search_filter' );

/* ------------------------------
更新日付順ソートを追加
------------------------------ */

//記事一覧にカラムを追加
function add_posts_column($columns) {
  $columns['last_modified']	= '最終更新日';
  return	$columns;
}
add_filter( 'manage_posts_columns', 'add_posts_column',20 );

//最終更新日の取得と表示
function add_posts_column_value($column_name, $post_id) {
  if ( 'last_modified' == $column_name ) {
      $date		= get_the_modified_date('Y年n月j日 g:i A');
      $show_date	= '最終更新日'.'<br />'.$date;

      echo	$show_date;
  }
}
add_action( 'manage_item_detail_posts_custom_column', 'add_posts_column_value', 10, 2 );
add_action( 'manage_area_detail_posts_custom_column', 'add_posts_column_value', 10, 2 );
add_action( 'manage_cusutomer_voice_posts_custom_column', 'add_posts_column_value', 10, 2 );
add_action( 'manage_article_detail_posts_custom_column', 'add_posts_column_value', 10, 2 );
add_action( 'manage_price_list_posts_custom_column', 'add_posts_column_value', 10, 2 );
add_action( 'manage_sekou_detail_posts_custom_column', 'add_posts_column_value', 10, 2 );

//並び替えを可能にする
function add_posts_column_sortable( $columns ) {
	$columns['last_modified'] = 'modified';
	return $columns;
}
add_filter( 'manage_edit-item_detail_sortable_columns', 'add_posts_column_sortable' );
add_filter( 'manage_edit-area_detail_sortable_columns', 'add_posts_column_sortable' );
add_filter( 'manage_edit-cusutomer_voice_sortable_columns', 'add_posts_column_sortable' );
add_filter( 'manage_edit-article_detail_sortable_columns', 'add_posts_column_sortable' );
add_filter( 'manage_edit-price_list_sortable_columns', 'add_posts_column_sortable' );
add_filter( 'manage_edit-sekou_detail_sortable_columns', 'add_posts_column_sortable' );

//エリア監修者情報表示
function areaManager() {
  $is_pref_page = is_page_template('page-pref.php');
  $is_city_page = is_singular('area_detail');

  if (!$is_pref_page && !$is_city_page) {
    return;
  }

  $area_manager_posts = get_field('area_manager_connect');
  if($area_manager_posts) {
      $area_manager_pic = get_field('area_manager_pic' ,$area_manager_posts[0]);
      $area_manager_name = get_field('area_manager_name' ,$area_manager_posts[0]);
      $area_manager_position = get_field('area_manager_position' ,$area_manager_posts[0]);
      $area_manager_intro = get_field('area_manager_intro' ,$area_manager_posts[0]);

      if ($is_pref_page) {
        $pref_name = get_pref_name();
        $area_name = $pref_name;
      } elseif ($is_city_page) {
        $post_id = get_the_ID();
        $post_terms = get_the_terms($post_id, 'area');
        $pref_and_city_name = $post_terms[0]->name;
        $city_name = city_page_replacement_title($pref_and_city_name);
        $area_name = $city_name;
      }

      $area_html = '<div class="area-manager"><div class="area-manager-inner">';
      $area_html .= '<h2 class="area-manager-ttl">'.$area_name.'のエリア担当者</h2>';
      $area_html .= '<div class="area-manager-pic"><img src="'.$area_manager_pic.'" alt=""></div>';
      $area_html .= '<div class="area-manager-wrap">';
      $area_html .= '<p class="area-manager-txt _name">'.$area_manager_name.'</p>';
      $area_html .= '<p class="area-manager-txt _position">'.$area_manager_position.'</p>';
      $area_html .= '<p class="area-manager-txt _intro">'.$area_manager_intro.'</p>';
      $area_html .= '</div></div></div>';
      return $area_html;
  }
}
add_shortcode('area_manager', 'areaManager');


//市区町村配下ページの料金表示
function areaPrice() {
  $post_id = get_the_ID();
  $item_slug = get_term_slug($post_id, 'item');

  $get_posts_arr = [
    'post_type' => 'price_list',
    'item' => $item_slug
  ];

  if(is_singular('area_detail') && get_field('show_small_area')) {
    $get_posts_arr = [
      'post_type' => 'price_list',
      'p' => 1463,
    ];
  }
  $service_type_list = get_posts($get_posts_arr);

  if (get_template_name() === 'page-pref.php') {
    $area_name = get_pref_name();
  } elseif(is_singular('area_detail') && !get_field('show_small_area')) {
    $post_id = get_the_ID();
    $post_terms = get_the_terms($post_id, 'area');
    $pref_and_city_name = $post_terms[0]->name;
    $area_name = city_page_replacement_title($pref_and_city_name);
  } elseif(is_singular('area_detail') && get_field('show_small_area')) {
    $area_name = get_field('small_area_page');
  }

  ob_start();
  if (get_template_name() !== 'page-pref.php') {
    get_template_part('template-parts/price-formula');
  }
  $html = ob_get_contents();
  $html .= '<div class="price-table-list"><div class="price-table-header">';
  if($item_slug == 'toilet') {
    $html .= '<h2 class="area-ttl _low">'.$area_name.'の<span>トイレつまり修理</span>や<span>その他サービスの料金</span></h2>';
  } elseif($item_slug == 'water-pipe') {
    $html .= '<h2 class="area-ttl _low">'.$area_name.'の<span>水道管の水漏れ・つまり修理</span>や<span>その他サービスの料金</span></h2>';
  } elseif($item_slug == 'bath') {
    $html .= '<h2 class="area-ttl _low">'.$area_name.'の<span>お風呂の蛇口交換・水漏れ修理</span>や<span>その他サービスの料金</span></h2>';
  }
  if(is_singular('area_detail') && get_field('show_small_area')) {
    $html .= '<h3 class="area-ttl _low">トイレ修理<span>サービス</span>と<span>作業料金</span>目安</h3>';
  }
  $html .= '</div><table class="price-table"><thead><tr><th>作業内容</th><th>作業時間目安</th><th>作業料金目安</th></tr></thead>';

  foreach ($service_type_list as $service_type) {
    $price_table_list = get_field('price_table_list', $service_type->ID);
    foreach ($price_table_list as $price_table) {
      $html .= '<tr>';
      $html .= '<td>'.$price_table['work_description'].'</td>';
      $html .= '<td>'.$price_table['about_time'].'</td>';
      $html .= '<td>'.$price_table['about_repair_price'].'</td>';
      $html .= '</tr>';
    }
  }

  $html .= '</table></div><p class="text-center black">※上記サービスの作業時間・料金に関しては'.$area_name.'エリアでの一例になります。</p>';
  ob_end_clean();

  return $html;
}
add_shortcode('area_price', 'areaPrice');

//市区町村配下ページの料金の画像表示
function payMethod() {
  ob_start();
  get_template_part('template-parts/pay-method');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('pay_method', 'payMethod');

//市区町村配下ページの関連フィールドの適用
function registerParentCityToCityPost($post_id) {
  if (get_post_type($post_id) !== 'area_detail') return;

  if (get_field('show_small_area', $post_id)) {
    $parent_city_ID = get_field('area_parent' , $post_id );
    $parent_id = $parent_city_ID[0];
  } else {
    $parent_id = 0;
  }

  remove_action( 'acf/save_post', 'registerParentCityToCityPost' );
  wp_update_post([
    'ID' => $post_id,
    'post_parent' => $parent_id,
  ]);
  add_action( 'acf/save_post', 'registerParentCityToCityPost' );
};

add_action( 'acf/save_post', 'registerParentCityToCityPost' );

// 料金比較コンテンツのショートコード
function PriceTable() {
  ob_start();
  get_template_part('template-parts/price-table');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('price_table', 'PriceTable');

// 料金比較コンテンツのショートコード
function WaterInfo() {
  ob_start();
  get_template_part('template-parts/water-info');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('water_info', 'WaterInfo');

// WPデフォルトのsitemap.xmlをオフに
add_filter( 'wp_sitemaps_enabled', '__return_false' );

// リライトルールの書き替え
function authorUrlRewrite() {
  add_rewrite_rule('^sitemap_index\.xml$', 'index.php?feed=sitemap', 'top');
  add_rewrite_rule('^page-sitemap\.xml$', 'index.php?feed=page-sitemap', 'top');
  add_rewrite_rule('^area-sitemap\.xml$', 'index.php?feed=area-sitemap', 'top');
  add_rewrite_rule('^item-sitemap\.xml$', 'index.php?feed=item-sitemap', 'top');
  add_rewrite_rule('^article-sitemap\.xml$', 'index.php?feed=article-sitemap', 'top');
  add_rewrite_rule('^sekou-sitemap\.xml$', 'index.php?feed=sekou-sitemap', 'top');
  add_rewrite_rule('^area-municipalities-sitemap\.xml$', 'index.php?feed=area-municipalities-sitemap', 'top');
  add_rewrite_rule('^area-address-sitemap\.xml$', 'index.php?feed=area-address-sitemap', 'top');
}
add_action('init', 'authorUrlRewrite');

// 通常のsitemap.xml
function my_do_feed_sitemap() {
  load_template(get_template_directory() . '/sitemap_index.php');
}
add_action('do_feed_sitemap', 'my_do_feed_sitemap');

// 固定ページのxml
function my_do_feed_page_sitemap() {
  load_template(get_template_directory() . '/page_sitemap.php');
}
add_action('do_feed_page-sitemap', 'my_do_feed_page_sitemap');

// 大エリアページのxml
function my_do_feed_big_area_sitemap() {
  load_template(get_template_directory() . '/area_sitemap.php');
}
add_action('do_feed_area-sitemap', 'my_do_feed_big_area_sitemap');

// 水回りトラブルのxml
function my_do_feed_item_sitemap() {
  load_template(get_template_directory() . '/item_sitemap.php');
}
add_action('do_feed_item-sitemap', 'my_do_feed_item_sitemap');

// お役立ち記事のxml
function my_do_feed_article_sitemap() {
  load_template(get_template_directory() . '/article_sitemap.php');
}
add_action('do_feed_article-sitemap', 'my_do_feed_article_sitemap');

// 施工事例一覧のxml
function my_do_feed_sekou_sitemap() {
  load_template(get_template_directory() . '/sekou_sitemap.php');
}
add_action('do_feed_sekou-sitemap', 'my_do_feed_sekou_sitemap');

// 中エリアページのxml
function my_do_feed_area_municipalities_sitemap() {
  load_template(get_template_directory() . '/area_municipalities_sitemap.php');
}
add_action('do_feed_area-municipalities-sitemap', 'my_do_feed_area_municipalities_sitemap');

// 小エリアページのxml
function my_do_feed_area_address_sitemap() {
  load_template(get_template_directory() . '/area_address_sitemap.php');
}
add_action('do_feed_area-address-sitemap', 'my_do_feed_area_address_sitemap');

function PrefAdmittedNumber() {
  ob_start();
  get_template_part('template-parts/top-admitted-number');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('pref_admitted_number', 'PrefAdmittedNumber');

function SekouInterlock() {
  ob_start();
  get_template_part('template-parts/sekou-interlock');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('sekou_interlock', 'SekouInterlock');

function PrefSmallareaCorrespondence() {
  ob_start();
  get_template_part('template-parts/pref-smallarea-correspondence');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('postcode_arealist', 'PrefSmallareaCorrespondence');

// 特定の投稿タイプのみアーカイブページを作成
function hide_customer_pre_get_posts($query) {
  if(is_tax()) {
    $query->set('post_type', ['item_detail', 'article_detail', 'sekou_detail']);
  }
}
add_action('pre_get_posts', 'hide_customer_pre_get_posts');

function AreaSurvey() {
  ob_start();
  get_template_part('template-parts/area-survey');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('area_survey', 'AreaSurvey');

// 水回りトラブル・お役立ち情報記事一覧の並び順をソート
function change_archive_sort($query) {
  if (is_admin() || !$query->is_main_query()) {
    return;
  }

  if(is_post_type_archive(['item_detail', 'article_detail'])) {
    $query->set( 'orderby', 'modified');
  }

}
add_action('pre_get_posts', 'change_archive_sort');

// 水回りトラブル・お役立ち情報記事の管理画面の並び順をソート
function change_admin_sort($query) {
  if(is_admin()) {
    $post_type = $query->query['post_type'];
    if($post_type == 'item_detail' || $post_type == 'article_detail') {
      $query->set('orderby','modified');
      $query->set('order','DESC');
    }
  }
}
add_filter('pre_get_posts', 'change_admin_sort');

// 対応実績件数 自動更新のショートコード
function AutoUpdateActual() {
  ob_start();
  get_template_part('template-parts/auto-update-actual');
  $html = ob_get_contents();
  ob_end_clean();
  return $html;
}
add_shortcode('auto_update_actual', 'AutoUpdateActual');

// エリア担当者からのメッセージのショートコード
function AreaMessage() {

  $area_name = get_area_name();
  $this_month = date('n月');
  $last_month = date('n月', strtotime('-1 month'));

  $number_of_add = [
    '01' => 3900, // 12月の実績
    '02' => 4800, // 1月の実績
    '03' => 4200, // 2月の実績
    '04' => 4300, // 3月の実績
    '05' => 4000, // 4月の実績
    '06' => 3400, // 5月の実績
    '07' => 3600, // 6月の実績
    '08' => 4100, // 7月の実績
    '09' => 4500, // 8月の実績
    '10' => 4600, // 9月の実績
    '11' => 3700, // 10月の実績
    '12' => 3800  // 11月の実績
  ];

  $month = date('m');

  $number_of_add_toilet = 0;

  $area_population = get_field('area_population');
  $area_population_total = 0;

  // 中エリアの投稿取得
  /*
  $args = [
    'posts_per_page' => -1,
    'post_type' => 'area_detail',
    'meta_key' => 'show_small_area',
    'meta_value' => 0,
    'meta_compare' => '='
  ];
  
  $area_posts = get_posts($args);
  
  foreach ($area_posts as $area_post) {
    $area_population_all = get_field('area_population', $area_post->ID);
    $area_population_total += $area_population_all;
  }
  */

  // 4つのサービスの件数
  /*
  if(is_singular('area_detail')) {
    $number_of_add_toilet = round($area_population / $area_population_total * $number_of_add[$month] * 0.4);

  } elseif(is_page_template('page-pref.php')) {
    $cities = get_city_pages($area_name)['トイレ'];
    foreach($cities as $city) {
      // 中エリアそれぞれの人口取得
      $area_population = get_field('area_population', $city->ID);

      // 大エリア用の中エリア4つのサービスの件数
      $number_of_add_toilet += round($area_population / $area_population_total * $number_of_add[$month] * 0.4);
    }
  }
  */

  //$html = '<p>'.$area_name.'では'.$last_month.'にトイレ関連のトラブルを'.$number_of_add_toilet.'件対応させていただきまして、多くのお客様から満足していただいております。多くの問い合わせをしていただきありがとうございます。'.$this_month.'もお客様のトイレつまりや水漏れなどのトラブルにお困りごとに対して誠意をもって対応させていただきますので、お気軽にご連絡ください！</p>';
  $html = '<p>'.$area_name.'では多くのお客様から満足していただいております。多くの問い合わせをしていただきありがとうございます。'.$this_month.'もお客様のトイレつまりや水漏れなどのトラブルにお困りごとに対して誠意をもって対応させていただきますので、お気軽にご連絡ください！</p>';
  return $html;
}
add_shortcode('area_message', 'AreaMessage');

// 今年を表示するショートコード
function ThisYear() {
  $date = date('Y年');
  return $date;
}
add_shortcode('this_year', 'ThisYear');

// 今月を表示するショートコード
function ThisMonth() {
  $date = date('n月');
  return $date;
}
add_shortcode('this_month', 'ThisMonth');

// 今日を表示するショートコード
function Today() {
  $date = date('j日');
  return $date;
}
add_shortcode('today', 'Today');

// 去年を表示するショートコード
function LastYear() {
  $date = date('Y年', strtotime('-1 year'));
  return $date;
}
add_shortcode('last_year', 'LastYear');

// 先月を表示するショートコード
function LastMonth() {
  $date = date('n月', strtotime('-1 month'));
  return $date;
}
add_shortcode('last_month', 'LastMonth');

// 各エリアページのアイテム名を取得
function get_item_name() {
  $item_name = '';
  $post_id = get_the_ID();
  $item_slug = get_term_slug($post_id, 'item');

  if($item_slug == 'toilet') {
    $item_name = 'トイレつまり';
  } elseif($item_slug == 'water-pipe') {
    $item_name = '水道管の水漏れ・つまり';
  } elseif($item_slug == 'bath') {
    $item_name = 'お風呂の蛇口交換・水漏れ';
  }

  return $item_name;
}