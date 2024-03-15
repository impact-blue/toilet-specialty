<?php
$pref_name = get_pref_name();
$pref_id = get_pref_id($pref_name);
$base_name = get_field('base_name', $pref_id);
$base_tel = get_field('base_tel', $pref_id);
$base_address = get_field('base_address', $pref_id);
$base_time = get_field('base_time', $pref_id);
$post_id = get_the_ID();

// $area_name = "";
if (get_template_name() === 'page-pref.php') {
  $area_name = $pref_name;
} elseif (get_template_name() === 'single-area_detail.php') {
  $area_name = get_the_terms($post_id, 'area')[0]->name;
  $post_terms = get_the_terms($post_id, 'area');
  $pref_and_city_name = $post_terms[0]->name;
  $city_name = city_page_replacement_title($pref_and_city_name);
}

// var_dump($area_name);
if (!empty($base_name)) {
?>
<section class="baseInfo">
  <?php if (is_page_template('page-pref.php')) { ?>
    <h2 class="area-ttl"><?= $area_name ?>の<span>拠点情報</span></h2>
    <div class="area-info _base">
      <table>
        <tbody>
          <tr>
            <th>営業所</th>
          </tr>
          <tr>
            <td><?= $base_name ?></td>
          </tr>
          <tr>
            <th>電話番号</th>
          </tr>
          <tr>
            <td><a href="tel:<?= $base_tel ?>"><?= $base_tel ?></a></td>
          </tr>
          <tr>
            <th>住所</th>
          </tr>
          <tr>
            <td><?= $base_address ?></td>
          </tr>
          <tr>
            <th>受付日時</th>
          </tr>
          <tr>
            <td><?= $base_time ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  <?php } elseif (is_singular('area_detail')) { ?>
    <h2 class="baseInfo-ttl"><?= $city_name ?>の水道修理ルート拠点情報</h2>
    <div class="container">
      <table class="baseInfo-table">
        <thead>
          <tr>
            <th>営業所</th>
            <td><?= $base_name ?></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>電話番号</th>
            <td><a href="tel:<?= $base_tel ?>"><?= $base_tel ?></a></td>
          </tr>
          <tr>
            <th>住所</th>
            <td><?= $base_address ?></td>
          </tr>
          <tr>
            <th>受付日時</th>
            <td><?= $base_time ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  <?php } ?>
</section>
<?php } ?>