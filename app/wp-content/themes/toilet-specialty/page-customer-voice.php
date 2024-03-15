<?php
/**
* pagesTemplate Name: お客様のお声
*/
get_header();

$query_instance = get_customer_voice();
?>
  <main>
    <section id="customer-voice">
      <div class="heading">
        <div class="container customer-voice-container">
          <div class="customer-voice-heading">
            <img class="humans" src="<?= $template_path ?>/img/customer-voice-human.jpg" alt="お客様の声ページの人物画像">
            <h1 class="text-center">
              <span class="sub-heading">水道修理ルートをご利用いただいた</span>
              <span class="text">お客様からの<span class="sp-big-text">声</span></span>
            </h1>
            <span class="big-text">声</span>
          </div>
        </div>
      </div>
      <div class="container customer-voice-container">
        <?php
        if ($query_instance->have_posts()) {
          while ($query_instance->have_posts()) {
            $query_instance->the_post();

            // カスタムタクソノミーの名前を取得
            $id = $query_instance->ID;
            $area_name = get_term_name($id, 'area');
            $item_name = get_term_name($id, 'item');

            // 小エリアページのIDとエリア名の取得
            if(get_field('is_small_area_voice')) {
              $small_area_id = get_field('small_area_id');
              $small_area_name = get_field('small_area_page', $small_area_id[0]);
            }

            // サブタイトルのテキストの生成
            $sub_title = $area_name . $item_name;

            if(get_field('is_small_area_voice')) {
              $sub_title = $area_name . $small_area_name . $item_name;
            }

            // 人物画像を取得
            $human_img_obj = get_field_object('human_img');
            $human_img_value = $human_img_obj['value'];
            $human_img_label = $human_img_obj['choices'][$human_img_value];

            $customer_info = "$area_name " . get_field('customer_info', $id);

            if(get_field('is_small_area_voice')) {
              $customer_info = "$area_name$small_area_name " . get_field('customer_info', $id);
            }
        ?>
        <div class="customer-voice-item">
          <p class="item-info">
            <?php if (get_field('is_small_area_voice')) { ?>
              <a href="<?= get_the_permalink($small_area_id[0]) ?>"><?= $sub_title ?>修理</a>についてお困りの方はこちら
            <?php } else { ?>
              <?= $sub_title ?>修理についてお困りの方はこちら
            <?php } ?>
          </p>

          <div class="item-heading">
            <img class="human-icon" src="<?= $template_path ?>/img/<?= $human_img_value ?>" alt="<?= $human_img_label ?>">
            <div class="texts">
              <h2>
                <span class="person"><?= $customer_info ?>から頂いた口コミ</span>
                <span class="title"><?= the_title(); ?></span>
              </h2>
            </div>
          </div>
          <div class="ratings">
            <div class="rate-box">
              <p class="rate-name">スタッフの対応</p>
              <p class="rate-star <?= get_field('staff_rating', $id); ?>"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></p>
            </div>
            <div class="rate-box">
              <p class="rate-name">水道修理の料金</p>
              <p class="rate-star <?= esc_html(get_field('price_rating', $id)); ?>"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></p>
            </div>
            <div class="rate-box">
              <p class="rate-name">お客様の満足度</p>
              <p class="rate-star <?= esc_html(get_field('satisfaction_rating', $id)); ?>"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></p>
            </div>
          </div>
          <div class="content"><?= get_field('customer_voice_content', $id) ?></div>
        </div>
        <?php
          }
        }
        wp_reset_postdata(); ?>
        <div class="paginate">
          <?php
            echo paginate_links([
              'total'   => $query_instance->max_num_pages,
              'current' => max(1, get_query_var('paged')),
              'prev_text' => '＜ 前へ',
              'next_text' => '次へ ＞',
            ]);
          ?>
        </div>
      </div>
    </section>
  </main>
<?php get_footer(); ?>
