<?php
global $template_path;

get_header();
?>
  <main id="front-page">
    <?php
    get_template_part('template-parts/hero');
    get_template_part('template-parts/caution');
    get_template_part('template-parts/auto-update-actual');
    get_template_part('template-parts/corona-measures');
    get_template_part('template-parts/crown');
    get_template_part('template-parts/top-admitted-number');
    get_template_part('template-parts/service');
    get_template_part('template-parts/new', 'cta-2');
    get_template_part('template-parts/beginners-guide');
    get_template_part('template-parts/reason-of-choose');
    get_template_part('template-parts/service-flow');
    get_template_part('template-parts/customer-voice');
    ?>

    <!--
    <section class="work-record">

    </section>
    -->

    <?php
    get_template_part('template-parts/top', 'questions');
    ?>
  </main>
<?php get_footer(); ?>
