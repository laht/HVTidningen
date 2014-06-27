<?php get_header(); ?>

<section id="main" class="front-page grid-66">

	<?php if(function_exists('hv_slideshow')) : ?>
		<div id="slideshow-container" class="grid-100">
			
			<section id="hv-slideshow" class="slideshow">	
				<?php hv_slideshow('bildspel'); ?>
			</section>
		
		</div>
	<?php endif; ?>

	<div class="front-page-posts grid-100">
		<?php query_posts('category_name=nyheter,notiser'); ?>
		<?php if(have_posts()) : ?>
			
			<div class="posts-cont">
			
				<?php while(have_posts()) : the_post(); ?>
				
					<article id="post-<?php the_id(); ?>" class="archive <?php echo implode(' ', get_post_class()); ?> clearfix">
					
						<?php if(has_post_thumbnail() && function_exists('has_post_format') && !has_post_format('gallery')) : ?>
							<div class="post-thumbnail">
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large'); ?></a>
							</div>
						<?php endif; ?>
						
						<header class="post-header">
							<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
						</header>
						
						<div class="post-meta">
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
						</div>
						
						<?php the_excerpt(); ?>
					
					</article>
				
				<?php endwhile; ?>
			
			</div>
			
		<?php endif; ?>
	</div>

</section>

<div id="secondary" class="grid-33 mobile-33">

	<?php if(function_exists('hv_facebook')) : ?>
		<section id="hv-facebook" class="front-page-widget grid-100">
			<?php hv_facebook(); ?>
		</section>
	<?php endif; ?>

	<?php if(function_exists('hv_twitter')) : ?>
		<section id="hv-twitter" class="front-page-widget grid-100">
			<?php hv_twitter(); ?>
		</section>
	<?php endif; ?>
	
	<?php if(function_exists('hv_rss')) : ?>
		<section id="hv-rss" class="front-page-widget grid-100">
			<?php hv_rss(); ?>
		</section>
	<?php endif; ?>
	
</div>

<?php get_footer(); ?>