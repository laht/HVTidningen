<?php get_header(); ?>

<div id="content" class="grid-100 mobile-100 grid-parent">

	<section id="main" class="tv-posts grid-100 grid-parent">	

		<div id="tv-posts">
			<?php query_posts('category_name=tv'); ?>
			<?php if(have_posts()) : ?>
				
				<div class="posts-cont">
				
					<?php while(have_posts()) : the_post(); ?>
					
						<article id="post-<?php the_id(); ?>" class="post <?php echo implode(' ', get_post_class()); ?> clearfix">
							
							<?php if(has_post_thumbnail() && function_exists('has_post_format') && !has_post_format('gallery')) : ?>								
								<div class="tv-thumbnail">
									<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
								</div>
							<?php endif; ?>

							<div class="tv-meta">
								<div class="tv-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
								<time class="time" datetime="<?php the_time(DATE_W3C); ?>"><?php the_time(get_option('date_format')); ?></time>
							</div>
																	
						</article>
					
					<?php endwhile; ?>
				
				</div>
				
			<?php endif; ?>
		</div>

	</section>

</div>

<?php get_footer(); ?>


