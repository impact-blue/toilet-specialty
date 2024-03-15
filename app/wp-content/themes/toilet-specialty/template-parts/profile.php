<?php
  $profile_posts = get_field('profile_connect1');
  if($profile_posts):
?>
  <?php foreach( $profile_posts as $val ): ?>
    <div class="profile">
      <p class="profile-ttl">監修者プロフィール</p>
      <div class="profile-inner">
        <div class="profile-wrap">
          <div class="profile-left">
            <div class="profile-pic"><img src="<?php the_field('profile_pic', $val->ID); ?>" alt=""></div>
            <?php $value = get_field('profile_link', $val->ID) ; if(empty($value)) : else:?>
              <div class="profile-btn is-pc"><a href="<?php the_field('profile_link', $val->ID); ?>"><?php the_field('profile_name', $val->ID); ?>公式ホームページ</a></div>
            <?php endif;?>
          </div>
          <div class="profile-right">
            <p class="profile-txt _name"><?php the_field('profile_name', $val->ID); ?></p>
            <p class="profile-txt _position"><?php the_field('profile_position', $val->ID); ?></p>
            <div class="profile-licence"><img src="<?php the_field('profile_licence', $val->ID); ?>" alt=""></div>
            <p class="profile-txt _intro"><?php the_field('profile_intro', $val->ID); ?></p>
          </div>
        </div>
        <?php $value = get_field('profile_link', $val->ID) ; if(empty($value)) : else:?>
            <div class="profile-btn is-sp"><a href="<?php the_field('profile_link', $val->ID); ?>"><?php the_field('profile_name', $val->ID); ?>公式ホームページ</a></div>
        <?php endif;?>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>