<?php
/**
* pagesTemplate Name: お問い合わせ
*/

get_header();
?>

<main id="contact">
  <div class="heading-bg"></div>

  <div class="contents">
    <div class="container">
      <div class="heading">
        <div class="left">
          <img class="heading-img" src="<?= $template_path ?>/img/contact-heading.png" width="674" height="310" alt="深夜や休日でも最短15分出張費0円で駆けつけます">
          <div class="left-bottom">
            <img class="info-img" src="<?= $template_path ?>/img/contact-info.png" width="289" height="63" alt="クレカOK!24時間365日対応OK!">
            <a class="call-tap tel-contact" href="tel:<?= get_phone_number() ?>">
              <img class="tel-img" src="<?= $template_path ?>/img/contact-tel-yellow-banner.png" width="385" height="66" alt="<?= get_phone_number() ?>">
              <p class="tel-annotation"><?= get_tel_annotation()?></p>
            </a>
          </div>
        </div>
        <img class="woman-img" src="<?= $template_path ?>/img/contact-woman.png" width="316" height="426" alt="電話する女性">
      </div>
    </div>
    <div class="contact-form container">
      <h1 class="contact-heading">お問い合わせフォーム</h1>
      <div class="contact-inner container">
        <?php if (have_posts()) { ?>
          <?php while (have_posts()) { the_post(); ?>
            <?php the_content(); ?>
          <?php } ?>
        <?php } ?>
      </div>
    </div>
  </div>
</main>

<?php get_footer(); ?>
