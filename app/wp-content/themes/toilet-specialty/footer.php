<?php
global $template_path;
$uri = get_theme_file_uri();
$date = date('YmdHi', time());

// CTAの読み込み
if (
  is_singular(['item_detail', 'article_detail'])
  || is_post_type_archive(['item_detail', 'article_detail'])
  || is_page(['price', 'area'])
) {
  get_template_part('template-parts/new', 'cta');
}

if(
  is_front_page()
  || is_singular(['item_detail', 'article_detail' ,'sekou_detail'])
  || is_post_type_archive(['item_detail', 'article_detail' ,'sekou_detail'])
) {
// 対応エリア一覧
get_template_part('template-parts/area-list');
}
?>

  <footer id="footer">
    <div class="institutions <?php if(is_singular('area_detail')) echo "_area" ?>">
      <div class="inner">
        <div class="institution">
          <a href="https://www.caa.go.jp/">
            <img src="<?= $template_path ?>/img/consumer-affairs-agency.png" width="417" height="102" alt="消費者庁">
          </a>
          <p>悪徳商法に騙されないために</p>
        </div>
        <div class="institution">
          <a href="https://www.mhlw.go.jp/stf/seisakunitsuite/bunya/kenkou_iryou/kenkou/suido/index.html">
            <img src="<?= $template_path ?>/img/ministry-of-health-labour-and-welfare.png" width="417" height="102" alt="厚生労働省">
          </a>
          <p>適切な施工とトラブルにならないために</p>
        </div>
      </div>
    </div>
    <div class="foot">
      <div class="inner">
        <div class="column sp-column block">
          <a class="sp-header emphasis-header" href="tel:<?= get_phone_number() ?>">お急ぎの方へ</a>
        </div>
        <div class="column sp-column block">
          <a class="sp-header" href="/">ホーム</a>
        </div>
        <div class="header toggle-header"><a href="/">ホーム</a></div>
        <div class="column">
          <div class="block">
            <div class="header toggle-header">サービス紹介</div>
            <ul class="content left">
              <li><a href="/toilet-repair/">トイレの修理・交換</a></li>
              <li><a href="/item_detail/toilet-tumari/">トイレつまりの直し方</a></li>
              <li>キッチンの修理・交換</li>
              <li>お風呂の修理・交換</li>
              <li>洗面所の修理・交換</li>
              <li>排水管・排水口の修理・交換</li>
              <li>給湯器の修理・交換</li>
              <li>ポンプの修理・交換</li>
              <li>水栓柱・散水栓の修理・交換</li>
            </ul>
          </div>
        </div>
        <div class="column">
          <div class="block">
            <div class="header toggle-header">初めての方へ</div>
            <ul class="content">
              <li><a href="/price/">サービス料金</a></li>
              <li><a href="/questions/">よくあるご質問</a></li>
              <li><a href="/customer-voice/">お客様の声</a></li>
              <li><a href="/sekou/">水道修理ルートの施工事例</a></li>
            </う>
          </div>
          <div class="block company-block">
            <div class="header toggle-header">会社について</div>
            <ul class="content">
              <li><a href="/company/">会社案内</a></li>
              <li><a href="/sitemap/">サイトマップ</a></li>
            </ul>
          </div>
        </div>
        <div class="column">
          <div class="block">
            <div class="header toggle-header">その他</div>
            <ul class="content">
              <li><a href="/area/">対応エリア</a></li>
              <li><a href="https://www.caa.go.jp/">消費者庁</a></li>
              <li><a href="https://www.mhlw.go.jp/stf/seisakunitsuite/bunya/kenkou_iryou/kenkou/suido/index.html">厚生労働省</a></li>
              <li><a href="http://www.kokusen.go.jp/index.html">国民生活センター</a></li>
            </ul>
          </div>
          <div class="block contact-block">
            <a class="header" href="/contact/">無料見積り依頼フォーム</a>
          </div>
        </div>
        <p class="copyright is-pc">©️水道修理ルート</p>
      </div>
    </div>
    <div class="foot-cta is-sp">
      <div class="inner">
        <p class="header bold">お電話１本ですぐに駆けつけます！</p>
        <a class="tel-imgs tel-footer" href="tel:<?= get_phone_number() ?>">
          <img class="icon" src="<?= $template_path ?>/img/icon-tel-green.png" width="31" height="20" alt="">
          <img class="number" src="<?= $template_path ?>/img/cta-tel.png" width="471" height="61" alt="通話料無料 <?= get_phone_number() ?>">
          <div class="call-ballon">
            <p><span class="emphasis">タップ</span>で<br><span class="emphasis">電話</span>する</p>
          </div>
        </a>
        <p class="tel-annotation"><?= get_tel_annotation()?></p>
      </div>
      <svg class="reception-time" xmlns="http://www.w3.org/2000/svg" width="719" height="26" viewBox="0 0 719 26"><defs><style>.a{fill:#1a42aa;font-size:19.329px;font-family:HiraginoSans-W7, Hiragino Sans;}.b{fill:#f0033c;font-size:23.471px;}</style></defs><text class="a" transform="translate(0 21)"><tspan x="0" y="0">【受付時間】</tspan><tspan class="b" y="0">24</tspan><tspan y="0">時間</tspan><tspan class="b" y="0">365</tspan><tspan y="0">日対応 | お見積もり</tspan><tspan class="b" y="0">0円</tspan><tspan y="0" xml:space="preserve"> | 出張費</tspan><tspan class="b" y="0">0円</tspan><tspan y="0" xml:space="preserve"> | 深夜割増</tspan><tspan class="b" y="0">0円</tspan></text></svg>
    </div>
  </footer>

  <a href="tel:<?= get_phone_number() ?>" class="footer-banner is-sp tel tel-banner">
    <img src="<?= $template_path ?>/img/sp-banner.png?20220214" alt="フッターバナー">
  </a>

  <?php if (is_page('contact')) { ?>
    <script>
    // 電話番号のtype属性をtelに書き換え
    window.addEventListener('DOMContentLoaded', function() {
      const telInput = document.querySelector('.tel-input');
      telInput.type = 'tel';
    });

    // 入力したテキストをクリアする処理
    const clearBtn = document.getElementById('clear-btn');
    const texts = document.querySelectorAll('.row p input, .row p textarea');

    clearBtn.addEventListener('click', function() {
      Array.prototype.forEach.call(texts, function(text) {
        text.value = '';
      });
    });
    </script>
  <?php } ?>
  <?php wp_footer(); ?>
</body>
</html>

