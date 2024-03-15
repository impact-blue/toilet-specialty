<?php
global $template_path;

// 施工事例コンテンツ
$construction_examples = get_field('construction_examples');

if ($construction_examples) {
  foreach ($construction_examples as $count => $construction_example) {
    $count++;
?>
  <div class="construction-examples-contents">
    <h2><?= $construction_example['heading'] ?></h2>
    <div class="slider-contents-wrapper">
      <div class="main-slider <?= 'main-slider-' . $count ?>">
        <?php
        foreach ($construction_example['slider_imgs'] as $slider_img) {
          $slider_img = $slider_img['slider_img'];
        ?>
          <div class="slide">
            <img src="<?= $slider_img['url'] ?>" alt="<?= $slider_img['alt'] ?>">
          </div>
          <?php } ?>
        </div>
        <div class="thumbnails-slider sp-slider <?= 'thumbnails-slider-' . $count ?>">
          <?php
        foreach ($construction_example['slider_imgs'] as $slider_img) {
          $slider_img = $slider_img['slider_img'];
          ?>
          <div class="slide-img">
            <img src="<?= $slider_img['url'] ?>" alt="<?= $slider_img['alt'] ?>">
          </div>
          <?php } ?>
        </div>
        <div class="text-area">
          <img class="man" src="<?= $template_path ?>/img/text-heading-man.png" alt="男性">
          <p><?= $construction_example['text'] ?></p>
        </div>
        <div class="thumbnails-slider pc-slider <?= 'thumbnails-slider-' . $count ?>">
          <?php
        foreach ($construction_example['slider_imgs'] as $slider_img) {
          $slider_img = $slider_img['slider_img'];
        ?>
        <div class="slide-img">
          <img src="<?= $slider_img['url'] ?>" alt="<?= $slider_img['alt'] ?>">
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php
  }
}
?>