<?php if(have_posts()) : ?>
	<?php while(have_posts()) : the_post(); ?>
		
		<article id="post-<?php the_id(); ?>" class="grid-100 <?php echo implode(' ', get_post_class()); ?>">
		
			<?php if(has_post_thumbnail()) : ?>
				<div class="post-thumbnail">
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
				</div>
			<?php endif; ?>
			
			<header class="post-header">
				<h1><!--<a href="<?php the_permalink(); ?>">--><?php the_title(); ?><!--</a>--></h1>
			</header>
			
			<?php the_excerpt(); ?>
			
			<div class="post-meta">
				<time datetime="<?php the_time(DATE_W3C); ?>"><?php the_time(get_option('date_format')); ?></time>
				<a href="<?php the_permalink(); ?>#comments"><?php comments_number('', ' - 1 kommentar', ' - % kommentarer'); ?></a>
			</div>
		
		</article>
		
	<?php endwhile; ?>
<?php endif; ?>