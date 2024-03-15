<?php
global $template_path;

$area_name = get_area_name();

$questions = '';

$item_name = '';
$post_id = get_the_ID();
$item_slug = get_term_slug($post_id, 'item');

if (is_home() || is_front_page()) {
  $questions = get_top_page_questions();
} elseif(is_page_template('page-pref.php') || is_singular('area_detail')) {
  $questions = get_area_page_questions();
}

$top_class = '';
if (
  is_front_page()
  || get_template_name() === 'page-pref.php'
  || is_singular('area_detail')) {
  $top_class = 'class="top-page-questions"';
}

if(is_singular('area_detail') || is_page_template('page-pref.php')) {
  if($item_slug == 'toilet' || $item_slug == '') {
    $item_name = 'トイレつまり修理・水道修理';
  } elseif($item_slug == 'water-pipe') {
    $item_name = '水道管の水漏れ・つまり修理';
  } elseif($item_slug == 'bath') {
    $item_name = 'お風呂の蛇口交換・水漏れ修理';
  }
} else {
  $item_name = 'トイレつまり修理・水道修理';
}

if ($questions) {
?>
  <div id="questions" <?= $top_class ?>>
    <div class="heading">
      <div class="container">
        <h2 class="questions-ttl">
          <?php if ($area_name) echo "{$area_name}で" ?><?= $item_name ?>に関するよくある質問
        </h2>
      </div>
    </div>
    <div class="contents">
      <div class="container">
        <div class="question-list">
          <div class="question-item">
            <div class="question-and-answer">
              <?php foreach ($questions as $key => $question) { ?>
                <div class="item">
                  <div class="question _top">
                    <span class="icon q-icon">Q</span>
                    <p><?= $question['question'] ?></p>
                    <div class="question-bars">
                      <div class="question-bar _top"></div>
                      <div class="question-bar _low <?php if(!$key) echo '_open' ?>"></div>
                    </div>
                  </div>
                  <div class="answer-wrap">
                    <div class="slide-item">
                      <div class="answer">
                        <span class="icon a-icon">A</span>
                        <p><?= $question['answer'] ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php
}
?>
