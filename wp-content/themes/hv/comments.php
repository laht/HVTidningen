<?php

//If the post is password protected and the user hasn't entered the password, return.
if(post_password_required()) return;
?>

<?php if(have_comments()) : ?>
	<section id="comments" class="comment-area grid-100">
	
		<small id="comment-number">
		<?php
			printf( _n( 'En kommentar om &ldquo;%2$s&rdquo;', '%1$s kommentarer om &ldquo;%2$s&rdquo;', get_comments_number(), 'twentytwelve' ),
				number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
		?>
		</small>

		<ol class="commentlist">
			<?php wp_list_comments('max_depth=2&callback=hv_comment&style=ol'); ?>
		</ol>

	</section>
<?php endif; ?>

<section id="comment-form" class="grid-100">
	<?php
		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		
		$fields = array(
			'author'	=>	'<div class="comment-input-div comment-author"><label for="author">Namn</label> ' .
						    ( $req ? '<span class="required">*</span>' : '' ) .
						    '<input id="author" name="author" class="border-box" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '"' .
						    $aria_req . ' /></div>',
							
			'email'		=>	'<div class="comment-input-div comment-email"><label for="email">Email</label> ' .
						    ( $req ? '<span class="required">*</span>' : '' ) .
						    '<input id="email" name="email" class="border-box" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '"' .
						    $aria_req . ' /></div>',
							
			'url'		=>	'<div class="comment-input-div comment-url"><label for="url">Hemsida</label>' .
						    '<input id="url" name="url" class="border-box" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '"' .
						    '/></div>'
		);
		
		$args = array(
			'fields'				=>	$fields,
			'comment_field'			=>	'<div class="comment-input-div comment-body"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label>' .
										'<textarea id="comment" name="comment" class="border-box" aria-required="true"></textarea></div>',
			'comment_notes_before'	=>	'<p class="comment-notes">' . __( 'Your email address will not be published.' ) .
										( $req ? ' Obligatoriska fält är markerade med <span class="required">*</span>.' : '' ) . '</p>',
			'comment_notes_after'	=>	'<small class="form-allowed-tags">' .
										sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' )
										, ' <code>' . allowed_tags() . '</code>' ) . '</small>',
			'logged_in_as'			=>	'<p>' . sprintf( 'Du är inloggad som <a href="%1$s">%2$s</a>.' .
										' Vill du <a href="%3$s" title="Logga ut från detta konto">logga ut?</a>',
										admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink()
										) ) ) . '</p>',
			'title_reply'			=>	''
		);
		
		comment_form($args);
	?>
</section>