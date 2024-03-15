<?php get_header(); ?>
  <main id="single-detail">
    <h1 class="item-title">
      <img src="<?= $template_path ?>/img/men-title.png" width="260" height="192" alt="男性">
      <span><?php the_title() ?></span>
    </h1>
    <?php if(!get_field('hide_release_date')) { ?>
      <div class="date-area _article">最終更新日:<time datetime="<?php the_modified_date('Y-m-d') ?>" itemprop="dateModified"><?php the_modified_date('Y/m/d') ?></time> / 公開日:<time datetime="<?php the_time('Y-m-d');?>" itemprop="datePublished"><?php the_time('Y/m/d');?></time></div>
    <?php } ?>
    <section class="post-content">
      <?php
        the_content();
        get_template_part('template-parts/profile');
        get_template_part('template-parts/post/related', 'posts');
      ?>
    </section>
  </main>
<?php get_footer(); ?>