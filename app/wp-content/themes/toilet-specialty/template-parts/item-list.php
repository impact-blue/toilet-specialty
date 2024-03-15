<?php 
global $template_path; 

$base_item_page_url = site_url('/') . 'item_detail';
?>
<div class="items">
  <div class="item">
    <img class="item-img" src="<?= get_the_post_thumbnail_url(49) ?>" width="296" height="157" alt="トイレのつまり">
    <div class="item-container">
      <h3>トイレのつまり</h3>
      <p class="text">水の流れが悪い・そもそも詰まっていて流れない・水を流した時に変な音がするなどトイレのつまりに関する原因や解消法はこちら。</p>
      <a href="<?= get_the_permalink(49) ?>">詳しくみる</a>
    </div>
  </div>
  <div class="item">
    <img class="item-img" src="<?= get_the_post_thumbnail_url(448) ?>" width="296" height="157" alt="トイレの臭い">
    <div class="item-container">
      <h3>トイレの臭い</h3>
      <p class="text">トイレから発生する嫌な臭い、普段からお手入れはちゃんとしているのに臭いが全く取れないなど、トイレの異臭関連でお困りの方はこちら。</p>
      <a href="<?= get_the_permalink(448) ?>">詳しくみる</a>
    </div>
  </div>
  <div class="item">
    <img class="item-img" src="<?= get_the_post_thumbnail_url(34) ?>" width="296" height="157" alt="トイレの水漏れ">
    <div class="item-container">
      <h3>トイレの水漏れ</h3>
      <p class="text">トイレの便器やタンクから水が漏れているなど、トイレの水漏れによるトラブルにお困りではありませんか？トイレの水漏れにたいする応急処置やトラブル解消法はこちら。</p>
      <a href="<?= get_the_permalink(34) ?>">詳しくみる</a>
    </div>
  </div>
  <div class="item">
    <img class="item-img" src="<?= get_the_post_thumbnail_url(457) ?>" width="296" height="157" alt="蛇口の交換">
    <div class="item-container">
      <h3>蛇口の交換</h3>
      <p class="text">蛇口の交換時期や交換する時に確認するべきポイント、また自分で交換する場合に必要な道具や手順などをご紹介しています。</p>
      <a href="<?= get_the_permalink(457) ?>">詳しくみる</a>
    </div> 
  </div>
  <div class="item">
    <img class="item-img" src="<?= get_the_post_thumbnail_url(463) ?>" width="296" height="157" alt="蛇口の水漏れ">
    <div class="item-container">
      <h3>蛇口の水漏れ</h3>
      <p class="text">キッチン・洗面台の蛇口の水漏れにお困りではございませんか。水漏れの原因の調べ方や蛇口のタイプ別に出来る水漏れ解消法をご紹介。</p>
      <a href="<?= get_the_permalink(463) ?>">詳しくみる</a>
    </div>
  </div>
  <div class="item">
    <img class="item-img" src=" <?= get_the_post_thumbnail_url(449) ?>" width="296" height="157" alt="お風呂のつまり">
    <div class="item-container">
      <h3>お風呂のつまり</h3>
      <p class="text">お風呂の排水溝のつまり、水の流れが悪いなどでお困りではありませんか。排水溝のつまりの原因や解消法についてもご紹介。</p>
      <a href="<?= get_the_permalink(449) ?>">詳しくみる</a>
    </div>
  </div>
  <div class="item">
    <img class="item-img" src="<?= get_the_post_thumbnail_url(453) ?>" width="296" height="157" alt="お風呂の臭い">
    <div class="item-container">
      <h3>お風呂の臭い</h3>
      <p class="text">お風呂の排水溝からの異臭についてお困りではございませんか。臭いの原因や掃除・解消方法をご紹介。</p>
      <a href="<?= get_the_permalink(453) ?>">詳しくみる</a>
    </div>
  </div>
</div>
