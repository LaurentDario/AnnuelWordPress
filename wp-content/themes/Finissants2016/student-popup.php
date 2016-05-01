<div class="student-popup<?php echo (is_single() ? ' is-opened' : '');?>">
  <div class="student-popup--content cf">
    <div class="student-popup--close"><i class="fa fa-times" aria-hidden="true"></i></div>
    <div class="m-all t-all d-1of4 column-fixed">
      <?php if(is_single()): ?>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
          <div class="student">
            <div class="student--avatar"><?php the_post_thumbnail('large'); ?></div>
            <h1 class="h2"><?php the_title(); ?></h1>
            <div class="student--content"><?php the_content(); ?></div>
            <div class="project is-hidden--mobile">
              <div class="project--name h3"><?php echo get_post_meta(get_the_ID(),'project_name_1', true); ?></div>
              <div class="project--credits"><?php echo get_post_meta(get_the_ID(),'project_credits_1', true); ?></div>
              <div class="project--description"><?php echo get_post_meta(get_the_ID(),'project_description_1', true); ?></div>
            </div>
          </div>
        <?php endwhile; endif; ?>
      <?php else: ?>
        <div class="student">
          <div class="student--avatar"></div>
          <h1 class="h2"></h1>
          <div class="student--content"></div>
          <div class="project is-hidden--mobile">
            <div class="project--name h3"></div>
            <div class="project--credits"></div>
            <div class="project--description"></div>
          </div>
        </div>
      <?php endif; ?>
    </div>
    <div class="m-all t-3of4 d-3of4 projects">
      <div class="project project--one" data-project="1">
        <div class="project--name is-hidden--desktop"><?php echo get_post_meta(get_the_ID(),'project_name_1', true); ?></div>
        <div class="project--credits is-hidden--desktop"><?php echo get_post_meta(get_the_ID(),'project_credits_1', true); ?></div>
        <div class="project--description is-hidden--desktop"><?php echo get_post_meta(get_the_ID(),'project_description_1', true); ?></div>
        <?php $images = get_post_meta(get_the_ID(),'project_images_1'); ?>
        <?php $video = get_post_meta(get_the_ID(),'project_video_1', true); ?>
        <div class="project--images">
          <?php foreach($images as $image): ?>
            <div class="project--image"><?php echo wp_get_attachment_image($image, 'full-size'); ?></div>
          <?php endforeach; ?>
        </div>
        <div class="project--video"><?php echo wp_oembed_get($video); ?></div>
      </div>
      <div class="project project--two" data-project="2">
        <div class="project--name is-hidden--desktop"><?php echo get_post_meta(get_the_ID(),'project_name_2', true); ?></div>
        <div class="project--credits is-hidden--desktop"><?php echo get_post_meta(get_the_ID(),'project_credits_2', true); ?></div>
        <div class="project--description is-hidden--desktop"><?php echo get_post_meta(get_the_ID(),'project_description_2', true); ?></div>
        <?php $images = get_post_meta(get_the_ID(),'project_images_2'); ?>
        <?php $video = get_post_meta(get_the_ID(),'project_video_2', true); ?>
        <div class="project--images">
          <?php foreach($images as $image): ?>
            <div class="project--image"><?php echo wp_get_attachment_image($image, 'full-size'); ?></div>
          <?php endforeach; ?>
        </div>
        <div class="project--video"><?php echo wp_oembed_get($video); ?></div>
      </div>
    </div>
  </div>
</div>