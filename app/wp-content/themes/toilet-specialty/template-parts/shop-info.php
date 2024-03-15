<?php
$shop_ttl = get_field('shop_ttl');
$shop_info_list = get_field('shop_info');
$shop_info_count = 0;
?>
<div class="shop-info" >
  <h3 class="shop-info-ttl"><span class="txt"><?= $shop_ttl ?></span></h3>
  <div class="shop-info-content">
    <?php
    foreach($shop_info_list as $shop_info) {
      $shop_info_count++;
    ?>
    <div class="shop-info-item">
      <p class="shop-info-name"><?= $shop_info_count ?>. <?= $shop_info['shop_name'] ?></p>
      <div class="shop-info-map">
        <?= $shop_info['shop_map']?>
      </div>
      <p class="shop-info-desc">
        <?= $shop_info['shop_txt'] ?>
      </p>
      <table class="table1">
        <thead>
          <tr><th colspan="2">店舗情報</th></tr>
        </thead>
        <tbody>
          <tr>
            <th>店名</th>
            <td><?= $shop_info['shop_name'] ?></td>
          </tr>
          <tr>
            <th>営業時間</th>
            <td><?= $shop_info['shop_hour'] ?></td>
          </tr>
          <tr>
            <th>電話番号</th>
            <td><?= $shop_info['shop_tel'] ?></td>
          </tr>
          <tr>
            <th>住所</th>
            <td><?= $shop_info['shop_address'] ?></td>
          </tr>
          <tr>
            <th>最寄り駅・アクセス</th>
            <td><?= $shop_info['shop_access'] ?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <?php }?>
  </div>
</div>