<?php get_header(); ?>

<div id="content" class="grid-100 mobile-100 grid-parent">

	<section id="main" class="grid-66 grid-parent">
	
		<?php if(have_posts()) : ?>
			<?php while(have_posts()) : the_post(); ?>
				
				<article id="post-<?php the_id(); ?>" class="grid-100 archive <?php echo implode(' ', get_post_class()); ?> clearfix">
				
					<?php if(has_post_thumbnail() && function_exists('has_post_format') && !has_post_format('gallery')) : ?>
						<div class="post-thumbnail">
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large'); ?></a>
						</div>
					<?php endif; ?>
					
					<header class="post-header">
						<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
					</header>
					
					<div class="post-meta">
						<div class="author">Av <?php the_author(); ?></div>
						<time class="time" datetime="<?php the_time(DATE_W3C); ?>"><?php the_time(get_option('date_format')); ?></time>
					</div>
					
					<?php the_excerpt(); ?>
				
				</article>
				
			<?php endwhile; ?>
			
				<div class="post-pagination">
					<div class="previous"><?php next_posts_link( 'Äldre inlägg' ); ?></div>
					<div class="next"><?php previous_posts_link( 'Nyare inlägg' ); ?></div>
				</div>
				
		<?php endif; ?>
	
	</section>
	
	<?php get_sidebar('archive'); ?>

</div>

<?php get_footer(); ?>