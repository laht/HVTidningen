<?php get_header(); ?>

<div id="content" class="grid-100 mobile-100 grid-parent">

	<section id="main" class="grid-100">
	
		<header class="category-header">
			<h1>Bildspel</h1>
		</header>
	
		<?php if(have_posts()) : ?>
			<?php while(have_posts()) : the_post(); ?>
				
				<article id="post-<?php the_id(); ?>" class="<?php echo implode(' ', get_post_class()); ?>">
				
					<?php if(has_post_thumbnail()) : ?>
						<div class="gallery-thumbnail">
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
						</div>
					<?php endif; ?>
					
					<div class="gallery-meta">
						<div class="gallery-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
						<time class="time" datetime="<?php the_time(DATE_W3C); ?>"><?php the_time(get_option('date_format')); ?></time>
						<!--<div class="gallery-imagecount"><?php echo 'Antal bilder: ' . post_attachment_count($post->ID); ?> -->						
					</header>
				
				</article>
				
			<?php endwhile; ?>
			
			<div class="clear"></div>
		<?php endif; ?>

	</section>

</div>

<?php get_footer(); ?>


