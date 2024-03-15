<?php
$admitted_number = get_field('admitted_number');
if (is_page_template('page-pref.php')) {
  $area_name = get_pref_name();
} elseif (is_singular('area_detail') && !get_field('show_small_area')) {
  $post_id = get_the_ID();
  $post_terms = get_the_terms($post_id, 'area');
  $pref_and_city_name = $post_terms[0]->name;
  $area_name = city_page_replacement_title($pref_and_city_name);
} elseif (is_singular('area_detail') && get_field('show_small_area')) {
  $area_name = get_field('small_area_page');
}
if (!empty($admitted_number)) {
?>
<section class="admitted-number">
  <p class="admitted-ttl">水道修理ルート（クリーンライフ）は<br><?= $area_name ?>の水道局指定工事店です。</p>
  <table class="admitted-table">
    <tr class="admitted-row">
      <td class="admitted-tdata _top">市区町村（広域名）</td>
      <td class="admitted-tdata _top">指定事業者番号</td>
    </tr>
    <tr class="admitted-row">
      <td class="admitted-tdata _low"><?= $area_name ?></td>
      <td class="admitted-tdata _low">第<?= $admitted_number ?>号</td>
    </tr>
  </table>
</section>
<?php }?>