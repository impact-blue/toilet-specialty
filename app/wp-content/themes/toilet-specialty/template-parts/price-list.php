<?php
$get_posts_arr = [
  'post_type' => 'price_list',
  'posts_per_page' => -1,
];

$service_type_list = get_posts($get_posts_arr);

foreach ($service_type_list as $service_type) {
?>
<div class="price-table-list">
  <div class="price-table-header">
    <h2><?= $service_type->post_title ?></h2>
  </div>
  <table class="price-table">
    <thead>
      <tr>
        <th>作業内容</th>
        <th>作業時間目安</th>
        <th>作業料金目安</th>
      </tr>
    </thead>
    <tbody>
    <?php
    $price_table_list = get_field('price_table_list', $service_type->ID);
    foreach ($price_table_list as $price_table) {
    ?>
      <tr>
        <td><?= $price_table['work_description'] ?></td>
        <td><?= $price_table['about_time'] ?></td>
        <td><?= $price_table['about_repair_price'] ?></td>
      </tr>
    <?php
    }
    ?>
    </tbody>
  </table>
</div>
<?php
}
?>