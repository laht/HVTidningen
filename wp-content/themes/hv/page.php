<?php get_header(); ?>

<div id="content" class="grid-100 mobile-100 grid-parent">

	<section id="main" class="grid-75 grid-parent">
	
		<?php if(have_posts()) : ?>
			<?php while(have_posts()) : the_post(); ?>
				
				<article id="post-<?php the_id(); ?>" class="grid-100 <?php echo implode(' ', get_post_class()); ?>">
				
					<?php if(has_post_thumbnail()) : ?>
						<div class="post-thumbnail">
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
						</div>
					<?php endif; ?>
					
					<header class="post-header">
						<h1><?php the_title(); ?></h1>
					</header>
					
					<?php the_content(); ?>
				
				</article>
				
			<?php endwhile; ?>
		<?php endif; ?>
	
	</section>

</div>

<?php get_footer(); ?>


