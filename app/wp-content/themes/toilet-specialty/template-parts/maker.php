<?php
global $template_path;
?>
<h2>メーカーやトイレの種類を気にせずお気軽にご相談ください</h2>
<p>自力でトイレのパーツ交換しようとする場合、各トイレメーカーの規格に沿った部品を選ぶ必要があります。<br>
トイレ修理の専門知識がない方にとっては、初めて聞くパーツの名前を覚えて、規格間違いがないように、ホームセンターで照らし合わせながら買うだけでも一苦労です。</p>
<p>特にトイレタンク内は、製造年数よっても必要になる異なるうえ、パーツ交換は手順を一つ間違えるだけでも、さらなる故障に繋がりかねません。</p>
<p>水道修理ルートでは、ホームセンターで取り扱っていないトイレ専門のパーツも取り揃えており、トラブルで必要な部品や材料はすべてこちらで用意いたします。デザイン性の強いメーカーや、古いタイプのトイレであっても安心してお任せください。</p>
<p>対応している主なトイレメーカーは以下の通りです。</p>

<div class="makers">
<?php
$makers = maker_img_and_alt_name();
$makers_series = makers_series();
$makers_series_withNumber = makers_series_withNumber();
foreach ($makers as $key => $maker) {
?>
  <?php if (!empty($makers_series[$key]) || !empty($makers_series_withNumber[$key])) { ?>
    <a href="#modal-<?= $key ?>">
      <img src="<?= $template_path ?>/img/<?= $key ?>.png" width="208" height="101" alt="<?= $maker ?>">
    </a>
    <div class="modal-wrapper" id="modal-<?= $key ?>">
      <a href="#!" class="overlay"></a>
      <div class="modal-window">
        <div class="content">
          <p class="title"><span class="maker"><?= $maker ?></span>の主なシリーズ</p>
          <div class="scroll-area">
            <?php if (!empty($makers_series_withNumber[$key])) {?>
            <table class="table">
              <tbody>
                <?php foreach($makers_series_withNumber[$key] as $series_name => $series_number) { ?>
                <tr>
                  <th><?= $series_name ?></th>
                  <td><?= $series_number ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php } ?>
            <ul class="list">
              <?php foreach ($makers_series[$key] as $series) { ?>
                <li><?= $series ?></li>
              <?php } ?>
            </ul>
            <p class="annotation">上記以外のシリーズにも対応しております。<br>詳しくはお問い合わせください。</p>
          </div>
        </div>
        <a href="#!" class="modal-close">×</a>
      </div>
    </div>
  <?php } else { ?>
    <img src="<?= $template_path ?>/img/<?= $key ?>.png" width="208" height="101" alt="<?= $maker ?>">
  <?php } ?>
<?php } ?>
</div>

<p><strong>※その他ジャニス、タカラスタンダードなどのメーカーや明記されていないメーカーの場合でも対応しております。</strong></p>
<p>また、対応しているトイレの種類は以下の通りです </p>
<ul>
  <li>組み合わせトイレ</li>
  <li>タンクレストイレ</li>
  <li>一体型トイレ</li>
</ul>
<p><strong>※その他のトイレの種類でも対応している場合がありますので、お気軽にご相談ください。</strong></p>

<h2>その他水回りの修理もお任せください</h2>
<p>その他にも水道修理ルートでは以下のような水道トラブルにも対応しております。</p>
<ul>
  <li>お風呂場の水の流れが悪い</li>
  <li>キッチンで水を流すと異音がする</li>
  <li>蛇口が取れてしまった</li>
  <li>トイレの水流が弱い</li>
  <li>排水溝から異臭がする</li>
</ul>
<p>「原因は分からないけれど、水回りのトラブルが発生してる」という場合でも、まずはトラブルの原因から解明いたします。<br>
また今後同じようなトラブルが起きないよう、正しい使い方や予防策についても丁寧にご説明いたします。</p>