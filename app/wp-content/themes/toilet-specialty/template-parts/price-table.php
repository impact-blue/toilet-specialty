<?php
  global $template_path;
  $item_name = get_item_name();
?>

<img src="<?= $template_path ?>/img/top-table-img.png?20210512" alt="あれ？「もっと安い料金を見たことあるけど・・・」" width="910" height="310" >
<div class="table-area">
  <div class="table-price-comparison">
    <?php if(is_page_template('page-pref.php')) { ?>
      <h3 class="white-text table-area-ttl"><?= $item_name ?>の修理の場合</h3>
    <?php } else { ?>
      <h3 class="white-text table-area-ttl">トイレ詰まりの修理の場合</h3>
    <?php } ?>
    <div class="table-area-icon">
      <div class="table-area-bar _top"></div>
      <div class="table-area-bar _low _open"></div>
    </div>
  </div>
  <div class="table-area-body">
    <table>
      <thead>
        <tr>
          <th></th>
          <th>水道修理ルート</th>
          <th>一般的な修理業者A</th>
        </tr>
      </thead>
      <tbody>
      <tr>
        <td>基本料金</td>
        <td>3,300円</td>
        <td class="td-red emphasis">1,000円</td>
      </tr>
      <tr>
        <td>作業料金</td>
        <td>5,500円</td>
        <td>8,800円</td>
      </tr>
      <tr>
        <td>出張費</td>
        <td>0円</td>
        <td>0円</td>
      </tr>
      <tr>
        <td>お見積り料金</td>
        <td>0円</td>
        <td>0円</td>
      </tr>
      <tr class="white-bg-tr">
        <td></td>
        <td class="center"><img src="<?= $template_path ?>/img/table-blue-arrow.png" width="39" height="17" alt=""></td>
        <td class="center"><img src="<?= $template_path ?>/img/table-glay-arrow.png" width="36" height="16" alt=""></td>
      </tr>
      <tr>
        <td>トータル</td>
        <td class="td-red emphasis red-border"><span>税込&nbsp;</span>5,800円</td>
        <td class="gray-bg-td"><span>税込&nbsp;</span>9,800円</td>
      </tr>
      <tr class="white-bg-tr">
        <td></td>
        <td class="td-red">WEB割引3,000円!!</td>
        <td></td>
      </tr>
      </tbody>
    </table>
    <p class="is-sp">WEB割引3,000円!!</p>
  </div>
</div>
