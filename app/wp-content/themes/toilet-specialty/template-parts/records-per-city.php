<?php
// 施工実績数
/*
$post_id = get_the_ID();
$records = get_records_per_city($post_id);
$pref_and_city_name = get_the_terms($post_id, 'area')[0]->name;
$city_name = city_page_replacement_title($pref_and_city_name);

if (!empty($records)) {
?>
<div class="construction-records">
  <h2><?= $city_name ?>の施工実績数</h2>
  <div class="records-center">
    <p class="records-total">
      <?= $pref_and_city_name ?>の実績数は<span class="number"><?= $records['total']?></span>件です。
    </p>
    <div class="records-panels-wrapper">
      <table class="records-panels">
        <tr>
          <td class="records-panel">
            <p class="number-wrapper">
              <span class="number"><?= $records['record']['toilet']?></span>件
            </p>
            <p class="name">
              トイレのつまり・水漏れ・交換
            </p>
          </td>
          <td class="records-panel">
            <p class="number-wrapper">
              <span class="number"><?= $records['record']['kitchen']?></span>件
            </p>
            <p class="name">
              キッチン・台所の水漏れ・交換
            </p>
          </td>
        </tr>
        <tr>
          <td class="records-panel">
            <p class="number-wrapper">
              <span class="number"><?= $records['record']['bath']?></span>件
            </p>
            <p class="name">
              浴室・洗面所のつまり・水漏れ・交換
            </p>
          </td>
          <td class="records-panel">
            <p class="number-wrapper">
              <span class="number"><?= $records['record']['sewage']?></span>件
            </p>
            <p class="name">
              下水のつまり・水漏れ・交換
            </p>
          </td>
        </tr>
      </table>
      <p class="annotation">※2021年4月1日～9月30日の施工実績数をまとめた数字になります。</p>
    </div>
  </div>
  <div class="records-areas">
    <p class="areas-ttl">
      過去に施工した<?= $pref_and_city_name ?>内のエリア
    </p>
    <p class="areas-box">
      <?= $records['areas']?>
    </p>
  </div>
</div>
<?php } ?>
*/
?>