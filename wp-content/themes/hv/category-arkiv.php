<?php get_header(); ?>

<div id="content" class="grid-100 mobile-100 grid-parent">

	<section id="main" class="archive-posts grid-75 grid-parent">
		
		<div id="archive" class="archive-div">
			<header class="category-header">
				<h1>Arkiv</h1>
			</header>

			<div id="archive-posts">
				<?php query_posts('posts_per_page=-1&category_name=arkiv') ?>
				<?php if(have_posts()) : ?>
					<?php while(have_posts()) : the_post(); ?>
						
						<article id="post-<?php the_id(); ?>" class="grid-100 <?php echo implode(' ', get_post_class()); ?>">
						
							<?php if(has_post_thumbnail()) : ?>
								<div class="post-thumbnail">
									<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
								</div>
							<?php endif; ?>
							
							<header class="post-header">
								<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							</header>
							
							<?php the_content(); ?>
						
						</article>
						
					<?php endwhile; ?>
				<?php endif; ?>
			</div>
		</div>		

	</section>	

	<?php if(function_exists('hv_maps')) : ?>
		<div id="map-container" class="archive-div">
			<div id="map-canvas" style="height:500px;">
				<?php hv_maps(); ?>
			</div>	
		</div>		
	<?php endif; ?>

</div>

<?php get_footer(); ?>


