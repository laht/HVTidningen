<?php

function hv_comment_action($comment, $args, $depth) {
	
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
	
	global $post;
	?>
	
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
		
			<div class="comment-avatar">
				<?php echo get_avatar($comment, '50'); ?>
			</div>
		
			<header class="comment-meta comment-author vcard">
				<?php
				echo	'<strong>' . get_comment_author_link() . '</strong>' . ' <small>den ' .
						'<time datetime="' . get_comment_time('c') . '">' . get_comment_time('j F') .
						' ' . get_comment_time('H:i:s') . '</time></small>';
				?>
			</header>
			
			<div class="comment-content">
				<?php comment_text(); ?>
			</div>
			
			<div class="comment-reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => 'Svara', 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div>
		
		</article>
<?php	
}

?>