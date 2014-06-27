<?php get_header(); ?>

<div id="content" class="grid-100 mobile-100 grid-parent">

	<section id="main" class="grid-66 grid-parent">
	
		<?php if(have_posts()) : ?>
			<?php while(have_posts()) : the_post(); ?>
				
				<article id="post-<?php the_id(); ?>" class="grid-100 single-gallery <?php echo implode(' ', get_post_class()); ?>">				
					
					<header class="post-header">
						<h1><?php the_title(); ?></h1>
					</header>

					<div class="post-meta clearfix">
						<div class="category">
							<?php 
							$category = get_the_category(); 
							if($category[0]){
							echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';
							}
							?>
						</div>
						<div class="author">Av <?php the_author(); ?></div>
						<time class="time" datetime="<?php the_time(DATE_W3C); ?>"><?php the_time(get_option('date_format')); ?></time>
						<div class="tags">
							<?php the_tags('Taggar: <span class="tag">#', '</span><span class="tag">#', '</span>'); ?>
						</div>
					</div>					
					
					<?php
					if(function_exists('has_post_format') && has_post_format('gallery')) 
						gallery_post(get_the_content());
					else
						the_content();		
					?>								
				
				</article>
				
				<?php comments_template(); ?>
				
			<?php endwhile; ?>
		<?php endif; ?>
	
	</section>
	
	<?php get_sidebar('single'); ?>
	

</div>

<?php get_footer(); ?>