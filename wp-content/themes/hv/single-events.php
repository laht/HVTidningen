<?php get_header(); ?>

<div id="content" class="grid-100 mobile-100 grid-parent">

	<section id="main" class="grid-66 grid-parent">
	
		<?php if(have_posts()) : ?>
			<?php while(have_posts()) : the_post(); ?>
				
				<article id="post-<?php the_id(); ?>" class="event grid-100 <?php echo implode(' ', get_post_class()); ?>">
				
					<header class="post-header">
						<h1><?php hv_event_title(); ?></h1>
					</header>
					
					<?php hv_event_map(); ?>
				
					<table class="event-table">
						<tr>
							<td><span class="bold">Plats</span></td>
							<td><?php hv_event_venue(); ?></td>
						</tr>
						<tr>
							<td><span class="bold">Startdatum</span></td>
							<td><?php hv_event_start('%d %B %Y - %H:%M'); ?></td>
						</tr>
						<tr>
							<td><span class="bold">Slutdatum</span></td>
							<td><?php hv_event_end('%d %B %Y - %H:%M'); ?></td>
						</tr>
						<tr>
							<td><span class="bold">Beskrivning</span></td>
							<td><?php hv_event_description(); ?></td>
						</tr>
					</table>							
				
				</article>
				
				<?php comments_template(); ?>
				
			<?php endwhile; ?>
		<?php endif; ?>
	
	</section>
	
	<?php get_sidebar('event'); ?>
	

</div>

<?php get_footer(); ?>