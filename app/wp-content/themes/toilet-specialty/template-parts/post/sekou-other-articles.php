<?php if ($other_articles->have_posts()){?>
<section class="other-articles">
  <div class="container">
    <h2 class="heading">その他施工事例一覧</h2>
    <ul class="post-list">
      <?php
      while ($other_articles->have_posts()) {
        $other_articles->the_post();
      ?>
      <li class="post-item">
        <p class="ttl"><?= the_title() ?></p>
        <?php if (has_post_thumbnail()) { ?>
            <?= the_post_thumbnail(); ?>
        <?php } ?>
        <div class="desc">
          <a class="more" href="<?= esc_url(get_the_permalink()); ?>">詳しく見る</a>
        </div>
        </li>
        <?php
        }
        wp_reset_postdata();
        ?>
    </ul>
    <p class="simple-link">
      <a href="/sekou/">施工事例一覧へ >></a>
    </p>
  </div>
</section>
<?php } ?>
