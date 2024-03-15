<?php
global $template_path;
$vendor_posts = get_field('vendor_info_connect');
$area_name = get_area_name();
$post_id = get_the_ID();
$item_slug = get_term_slug($post_id, 'item');

if($vendor_posts) {
?>
<section class="vendor-info">
  <div class="vendor-info-inner">
    <h2 class="vendor-info-ttl"><?= $area_name ?>の水道局指定工事店をご紹介！</h2>
    <p class="vendor-info-desc"><?php the_field('vendor_txt'); ?></p>
    <?php foreach( $vendor_posts as $vendor_post ) {
      $vendor_name = get_field('vendor_name', $vendor_post->ID);
      $vendor_img = get_field('vendor_img', $vendor_post->ID);
      $vendor_url = get_field('vendor_url', $vendor_post->ID);
      $vendor_price = get_field('vendor_price', $vendor_post->ID);
      $vendor_price_waterpipe = get_field('vendor_price_waterpipe', $vendor_post->ID);
      $vendor_price_bath = get_field('vendor_price_bath', $vendor_post->ID);
      $vendor_tel = get_field('vendor_tel', $vendor_post->ID);
      $vendor_business_hours = get_field('vendor_business_hours', $vendor_post->ID);
      $vendor_cost = get_field('vendor_cost', $vendor_post->ID);
      $vendor_time = get_field('vendor_time', $vendor_post->ID);
      $vendor_formal_name = get_field('vendor_formal_name', $vendor_post->ID);

      $available_marks = [
        true => '◯',
        false => '×',
      ];

      $is_vendor_toilet = get_field('vendor_toilet', $vendor_post->ID);
      $is_vendor_kitchen = get_field('vendor_kitchen', $vendor_post->ID);
      $is_vendor_bath = get_field('vendor_bath', $vendor_post->ID);
      $is_vendor_washroom = get_field('vendor_washroom', $vendor_post->ID);
      $is_vendor_drain = get_field('vendor_drain', $vendor_post->ID);
      $is_vendor_pump = get_field('vendor_pump', $vendor_post->ID);
      $is_vendor_water_faucet = get_field('vendor_water_faucet', $vendor_post->ID);
      $is_vendor_water_heater = get_field('vendor_water_heater', $vendor_post->ID);
      $is_vendor_ditch = get_field('vendor_ditch', $vendor_post->ID);
      $is_vendor_pipe = get_field('vendor_pipe', $vendor_post->ID);
      $is_vendor_washing_machine = get_field('vendor_washing_machine', $vendor_post->ID);
    ?>
    <div class="vendor-info-wrap">
      <p class="vendor-info-name"><?= $vendor_name ?></p>
      <div class="vendor-info-img"><img src="<?= $vendor_img ?>" alt=""></div>
      <p class="vendor-info-url"><?= $vendor_url ?></p>
    </div>
    <div class="vendor-info-service">
      <p class="vendor-info-service-ttl">サービス内容</p>
        <table class="table-pc">
          <tr>
            <?php if($item_slug == 'toilet') { ?>
              <th>トイレつまり料金</th>
            <?php } elseif($item_slug == 'water-pipe') { ?>
              <th>水道管の水漏れ料金</th>
            <?php } elseif($item_slug == 'bath') { ?>
              <th>お風呂の蛇口交換料金</th>
            <?php } ?>
            <th>電話番号</th>
            <th>営業時間</th>
          </tr>
          <tr>
            <?php if($item_slug == 'toilet') { ?>
              <td><?= $vendor_price ?></td>
            <?php } elseif($item_slug == 'water-pipe') { ?>
              <td><?= $vendor_price_waterpipe ?></td>
            <?php } elseif($item_slug == 'bath') { ?>
              <td><?= $vendor_price_bath ?></td>
            <?php } ?>
            <td><?= $vendor_tel ?></td>
            <td><?= $vendor_business_hours ?></td>
          </tr>
          <tr>
            <th>出張・調査・見積もり費用</th>
            <th>最短到着時間</th>
            <th>会社名</th>
          </tr>
          <tr>
            <td><?= $vendor_cost ?></td>
            <td><?= $vendor_time ?></td>
            <td><?= $vendor_formal_name ?></td>
          </tr>
        </table>
        <table class="table-pc">
          <tr>
            <th>トイレ</th>
            <th>キッチン</th>
            <th>お風呂</th>
            <th>洗面所</th>
            <th>排水口<br>排水管</th>
            <th>ポンプ</th>
            <th>屋外水栓<br>散水栓</th>
            <th>給油器</th>
            <th>排水溝</th>
            <th>下水管</th>
            <th>洗濯機</th>
          </tr>
          <tr>
            <td><?= $available_marks[$is_vendor_toilet]; ?></td>
            <td><?= $available_marks[$is_vendor_kitchen]; ?></td>
            <td><?= $available_marks[$is_vendor_bath]; ?></td>
            <td><?= $available_marks[$is_vendor_washroom]; ?></td>
            <td><?= $available_marks[$is_vendor_drain]; ?></td>
            <td><?= $available_marks[$is_vendor_pump]; ?></td>
            <td><?= $available_marks[$is_vendor_water_faucet]; ?></td>
            <td><?= $available_marks[$is_vendor_water_heater]; ?></td>
            <td><?= $available_marks[$is_vendor_ditch]; ?></td>
            <td><?= $available_marks[$is_vendor_pipe]; ?></td>
            <td><?= $available_marks[$is_vendor_washing_machine]; ?></td>
          </tr>
        </table>
        <table class="table-sp">
          <tr>
            <th>トイレつまり料金</th>
            <th>電話番号</th>
          </tr>
          <tr>
            <td><?= $vendor_price ?></td>
            <td><?= $vendor_tel ?></td>
          </tr>
          <tr>
            <th>最短到着時間</th>
            <th>出張・調査<br>見積もり費用</th>
          </tr>
          <tr>
            <td><?= $vendor_business_hours ?></td>
            <td><?= $vendor_cost ?></td>
          </tr>
          <tr>
            <th>営業時間</th>
            <th>会社名</th>
          </tr>
          <tr>
            <td><?= $vendor_time ?></td>
            <td><?= $vendor_formal_name ?></td>
          </tr>
        </table>
        <table class="table-sp">
          <tr>
            <th>トイレ</th>
            <th>キッチン</th>
            <th>お風呂</th>
          </tr>
          <tr>
            <td><?= $available_marks[$is_vendor_toilet]; ?></td>
            <td><?= $available_marks[$is_vendor_kitchen]; ?></td>
            <td><?= $available_marks[$is_vendor_bath]; ?></td>
          </tr>
          <tr>
            <th>洗面所</th>
            <th>排水口<br>排水管</th>
            <th>ポンプ</th>
          </tr>
          <tr>
            <td><?= $available_marks[$is_vendor_washroom]; ?></td>
            <td><?= $available_marks[$is_vendor_drain]; ?></td>
            <td><?= $available_marks[$is_vendor_pump]; ?></td>
          </tr>
          <tr>
            <th>屋外水栓<br>散水栓</th>
            <th>給油器</th>
            <th>排水溝</th>
          </tr>
          <tr>
            <td><?= $available_marks[$is_vendor_water_faucet]; ?></td>
            <td><?= $available_marks[$is_vendor_water_heater]; ?></td>
            <td><?= $available_marks[$is_vendor_ditch]; ?></td>
          </tr>
          <tr>
            <th>下水管</th>
            <th>洗濯機</th>
          </tr>
          <tr>
            <td><?= $available_marks[$is_vendor_pipe];?></td>
            <td><?= $available_marks[$is_vendor_washing_machine];?></td>
          </tr>
        </table>
    </div>
    <?php } ?>
  </div>
</section>
<?php } ?>