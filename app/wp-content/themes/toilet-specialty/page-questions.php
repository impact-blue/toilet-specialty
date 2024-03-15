<?php
/**
* pagesTemplate Name: よくある質問
*/
get_header();

// よくある質問のカスタムフィールドを取得
$questions = get_field('questions', get_the_ID());
?>
  <main id="questions">
    <div class="heading">
      <div class="container">
        <img class="question-mark-img" src="<?= $template_path ?>/img/question-mark.jpg" alt="はてなマーク">
        <h1><?php the_title(); ?></h1>
      </div>
    </div>

    <div class="contents">
      <div class="container">
        <ul class="question-nav-heading">
          <?php foreach ($questions as $key => $question) { ?>
            <li class="question-nav-item" onclick="document.querySelector('#faq-<?= $key ?>').scrollIntoView({ behavior:'smooth' })">
              <?= $question['heading'] ?>
            </li>
          <?php } ?>
        </ul>

        <div class="question-list">
          <?php
          foreach ($questions as $key => $question) {
            $questions_repeater_field = $question['questions_repeater_field'];
          ?>
            <div id="faq-<?= $key ?>" class="question-item">
              <h2 class="question-heading"><?= $question['heading'] ?></h2>
              <div class="question-and-answer">
                <?php foreach ($questions_repeater_field as $field) { ?>
                  <dl class="item">
                    <dt class="question">
                      <span class="icon q-icon">Q</span>
                      <p><?= $field['question'] ?></p>
                    </dt>
                    <dd class="slide-item">
                      <div class="answer">
                        <span class="icon a-icon">A</span>
                        <p><?= $field['answer'] ?></p>
                      </div>
                    </dd>
                  </dl>
                <?php } ?>
              </div>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
    </div>
  </main>
<?php get_footer(); ?>
