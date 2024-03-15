<?php
/*
Template Name: トイレのサービストップページ
*/
get_header();
$post_content = get_the_content();

?>
  <main class="area">
    <?php
    get_template_part('template-parts/hero');
    ?>
    <h1 class="top-ttl"><?php the_field('toilet-h1_text'); ?></h1>
    <?php
    get_template_part('template-parts/new', 'cta');
    get_template_part('template-parts/corona-measures');
    get_template_part('template-parts/caution');
    get_template_part('template-parts/service-toilet');
    ?>
    <?php if(!empty($post_content)){?>
    <div class="post-content">
      <div class="container">
        <?php the_content(); ?>
      </div>
    </div>
    <?php
    }
    ?>
    <?php
    get_template_part('template-parts/new', 'cta');
    get_template_part('template-parts/area-list');
    get_template_part('template-parts/service');
    ?>
  </main>
<?php get_footer(); ?>
