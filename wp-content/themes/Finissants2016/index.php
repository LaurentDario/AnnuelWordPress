<?php get_header(); ?>

	<?php require_once('student-popup.php'); ?>

			<div id="content">

				<div id="inner-content" class="cf">
						<main id="main" class="m-all t-all d-all cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
							<?php
								$args = array( 'post_type' => 'student', 'posts_per_page' => -1, 'orderby' => 'rand' );
								$loop = new WP_Query( $args );
							if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post(); ?>

								<?php
									$categories = get_the_category(get_the_ID());
									$category = $categories[0];
								?>
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf menu-item-'.$category->term_id ); ?> role="article" data-slug="<?php echo $post->post_name; ?>" data-id="<?php echo $post->ID; ?>">

								<img src="<?php the_post_thumbnail_url('home-portrait'); ?>">
								<header class="article-header">
									<div class="h2 entry-title">
										<div class="vertical-align">
											<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
												<?php the_title(); ?>
											</a>
										</div>
									</div>
								</header>

							</article>


							<?php endwhile; ?>

									<?php bones_page_navi(); ?>

							<?php else : ?>

									<article id="post-not-found" class="hentry cf">
											<header class="article-header">
												<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
										</header>
											<section class="entry-content">
												<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the index.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>


						</main>

					<?php //get_sidebar(); ?>

				</div>

			</div>


<?php get_footer(); ?>
