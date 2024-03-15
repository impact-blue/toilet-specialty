<?php
/*
Plugin Name: json-ld-custom
Plugin URI: https://impact-blue.co.jp
Description: 構造化データを出力するためのプラグインです
Version: 1.0.2
Author: 株式会社インパクトブルー
Author URI: https://impact-blue.co.jp
*/

// 構造化データの表示
function insert_json_ld() {
  global $post;

  if(is_singular(['item_detail', 'article_detail'])) {
    return;
  }

  $site_title = esc_html(get_bloginfo('name'));
  $post_url = esc_html(get_permalink());
  $author_data = get_userdata($post->post_author);

  $payload['@context'] = 'http://schema.org/';
  $payload['@type'] = 'WebSite';
  $payload['name'] = $site_title;
  $payload['author'] = array(
    '@type' => 'Person',
    'name' => $author_data->display_name,
  );
  $payload['dateModified'] = $post->post_modified;
  $payload['datePublished'] = $post->post_date;
  $payload['inLanguage'] = 'jp';
  $payload['Publisher'] = array(
    '@type' => 'Organization',
    'name' =>  '株式会社 クリーンライフ',
  );

  $is_item_detail = is_post_type_archive('item_detail');
  $is_area_detail = is_post_type_archive('area_detail');
  $is_article_detail = is_post_type_archive('article_detail');

  // アイテム一覧・エリア一覧
  if ($is_item_detail || $is_area_detail || $is_article_detail) {
    $archive_page_link = get_post_type_archive_link(get_post_type());

    $payload['headline'] = post_type_archive_title('', false);
    $payload['url'] = $archive_page_link;
    $payload['mainEntityOfPage'] = array(
      '@type' => 'WebPage',
      '@id' => $archive_page_link,
    );
  } else {
    $payload['headline'] = $post->post_title;
    $payload['url'] = $post_url;
    $payload['mainEntityOfPage'] = array(
      '@type' => 'WebPage',
      '@id' => $post_url,
    );
  }

  echo '<script type="application/ld+json">' .json_encode($payload, JSON_UNESCAPED_UNICODE). '</script>';
}
add_action('wp_head', 'insert_json_ld');

// サイトリンク検索ボックスの表示
function site_link_search_box() {
  $home_url = home_url('/');

  $script_tag = <<<EOM
\n<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "url": "{$home_url}",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "{$home_url}?s={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>\n
EOM;

  echo $script_tag;
}
add_action('wp_head', 'site_link_search_box');

// トップページに出力するよくある質問の構造化データ
function questions_json_ld() {
  if (is_page_template('page-questions.php')) {
    $questions = get_page_questions();
  } elseif(is_home() || is_front_page()) {
    $questions = get_top_page_questions();
  } elseif(is_page_template('page-pref.php') || is_singular('area_detail')) {
    $questions = get_area_page_questions();
  }

  $page_questions = [];

  if(isset($questions)) {
    foreach ($questions as $question) {
      $page_questions[] = [
        '@type' => 'Question',
        'name' => $question['question'],
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => $question['answer'],
        ]
      ];
    }
  }

  if (empty($page_questions)) return;

  $main_entity = json_encode($page_questions);

  $script_tag = <<<EOM
\n<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": {$main_entity}
}
</script>\n
EOM;

  echo $script_tag;
}
add_action('wp_head', 'questions_json_ld');

// 口コミと料金の構造化データ
function localbusiness_json_ld() {
  // トップ・お客さまの声・エリアページのみ
  if (!is_home() && !is_front_page() && !is_page('customer-voice') && !is_page_template('page-pref.php') && !is_singular('area_detail')) {
    return;
  }

  global $paged;
  $site_title = esc_html(get_bloginfo('name'));
  $page_title = esc_html(get_the_title());

  // 各ページのタイトル取得
  if(is_home() || is_front_page()) {
    $title = '"'."トイレつまり・水漏れ／水回りの修理なら24時間365日受付の水道修理ルート".'"';
  } elseif($paged > 0) {
    $title = '"'."{$page_title}（{$paged}ページ目）｜{$site_title}".'"';
  } else {
    $title = '"'."{$page_title}｜{$site_title}".'"';
  }

  if(!get_field('small_area_page')) {
    // 口コミのID取得
    $args = [
      'post_type' => 'cusutomer_voice',
      'posts_per_page' => -1,
      'fields' => 'ids',
    ];
    if(is_page_template('page-pref.php')) {
      $pref_name = get_pref_name();
      $cities = get_city_pages($pref_name)['トイレ'];
      $pref_and_city_name = [];

      foreach($cities as $city) {
        $city_id = $city->ID;
        $post_terms = get_the_terms($city_id, 'area');
        $pref_and_city_name[] = $post_terms[0]->name;
      }
    } elseif (is_singular('area_detail')) {
      $post_id = get_the_ID();
      $post_terms = get_the_terms($post_id, 'area');
      $pref_and_city_name = $post_terms[0]->name;
    }

    if (isset($pref_and_city_name) && !empty($pref_and_city_name)) {
      $args['tax_query'][] = [
        'taxonomy' => 'area',
        'field' => 'slug',
        'terms' => $pref_and_city_name,
      ];
    }

    $ids = get_posts($args);

    // 口コミの合計数を変数に格納
    if(!empty($ids)) {
      $num_posts = count($ids);
    }

    // 平均評価数の計算
    global $wpdb;
    $ids_string = implode(',', $ids);
    $query = "SELECT * FROM $wpdb->postmeta WHERE post_id IN ($ids_string) AND meta_key IN ('staff_rating', 'price_rating', 'satisfaction_rating')";
    $rows = $wpdb->get_results($query);

    $rate_sum = 0;
    foreach ($rows as $row) {
      $rate_sum += intval(str_replace('rating-', '', $row->meta_value));
    }

    // 口コミの平均評価数を変数に格納
    $average = round($rate_sum / 3 / $num_posts, 1);

    // 口コミを配列に格納
    $aggregate_rating_array = [
      '@type' => 'AggregateRating',
      'ratingValue' => $average,
      'reviewCount' => $num_posts,
    ];

    // トップページ・お客さまの声・大・中エリアページの時のみ口コミを表示
    $aggregate_rating_encode = json_encode($aggregate_rating_array, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    $aggregate_rating = ",\n" .'  "aggregateRating":' .$aggregate_rating_encode;
  } else {
    $aggregate_rating = '';
  }

  // エリアページの時のみ料金を表示
  if(is_page_template('page-pref.php') || is_singular('area_detail')) {
    $area_structured_data = ",\n  " .'"priceRange": "3,300~"';
  } else {
    $area_structured_data = '';
  }


  $script_tag = <<<EOM
\n<script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@type":"LocalBusiness",
  "name":{$title}{$aggregate_rating}{$area_structured_data}
}
</script>\n
EOM;

  echo $script_tag;
}
add_action('wp_head', 'localbusiness_json_ld');

// 水回りトラブル・お役立ち記事一覧の記事構造化データ
function article_item_json_ld() {
  if(!is_singular(['item_detail', 'article_detail'])) {
    return;
  }

  $home_url = home_url('/');
  $post_url = get_permalink();
  $post_title = get_the_title();

  if(get_field('article_structured_img')) {
    $article_structured_img = get_field('article_structured_img');

    $article_structured_img_array = [
      '@type' => 'ImageObject',
      'url' => $article_structured_img,
    ];

    $article_structured_encode = json_encode($article_structured_img_array, JSON_UNESCAPED_SLASHES);
    $article_image = "," . '"image": '. $article_structured_encode;
  } else {
    $article_image = '';
  }


  $script_tag = <<<EOM
\n<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "NewsArticle",
  "headline": "{$post_title}",
  "mainEntityOfPage": {
    "@type":"WebPage",
    "@id":"{$post_url}"
  },
  "author": {
    "@type": "Person",
    "name": "水道修理ルート記事編集部"
  },
  "publisher": {
    "@type": "Organization",
    "name": "水道修理ルート",
    "url": "{$home_url}"
  }{$article_image}
}
</script>\n
EOM;

  echo $script_tag;
}
add_action('wp_head', 'article_item_json_ld');

// 水回りトラブル・お役立ち記事一覧のハウツー構造化データ
function howto_json_ld() {
  if(!is_singular(['item_detail', 'article_detail']) || !get_field('show_structured_data')) {
    return;
  }

  $structured_data_name = get_field('structured_data_name');
  $structured_data_description = get_field('structured_data_description');
  $structured_data_totaltime = get_field('structured_data_totaltime');
  $structured_data_repeat = get_field('structured_data_repeat');

  $structured_field = [];

  foreach($structured_data_repeat as $field) {
    $structured_field[] = [
      '@type' => 'HowToStep',
      'name' => $field['structured_data_step_name'],
      'text' => $field['structured_data_text'],
      'image' => [
        '@type' => 'ImageObject',
        'url' => $field['structured_data_img']
      ]
    ];
  }

  $structured_field_encode = json_encode($structured_field, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

  $script_tag = <<<EOM
\n<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "HowTo",
  "name": "{$structured_data_name}",
  "description": "{$structured_data_description}",
  "step": {$structured_field_encode},
  "totalTime": "{$structured_data_totaltime}"
}
</script>\n
EOM;

  echo $script_tag;
}
add_action('wp_head', 'howto_json_ld');