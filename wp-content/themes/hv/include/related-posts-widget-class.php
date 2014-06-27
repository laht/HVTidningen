<?php

/**
 * Adds a widget that can show some related posts.
 */

class Related_Posts_Widget extends WP_Widget {
	
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'related_posts_widget', // Base ID
			'Relaterade inlägg', // Name
			array( 'description' => 'Visar några relaterade inlägg baserad på etiketter.', ) //Args
		);
	}
	 
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args		Widget arguments.
	 * @param array $instance 	Saved values from the database.
	 */
	public function widget($args, $instance) {
		extract($args);
		
		/* Note:
		 * The function render each individual post in the sidebar is moved to another
		 * file so I can use the same file on multiple widgets.
		 */
		require_once('render-widget-post.php');
		
		global $post;  
		$tags = wp_get_post_tags($post->ID);  
		  
		if ($tags) {  
		$tag_ids = array();  
			foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;  
			$args = array(  
				'tag__in' => $tag_ids,  
				'post__not_in' => array($post->ID),  
				'numberposts' => $instance['numberposts'], // Number of related posts to display.  
				'ignore_sticky_post' => 1  
			);
		}
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		$posts = get_posts($args);
		 
		echo $before_widget;
		
		if(!empty($title))
			echo $before_title . $title . $after_title;
			
		//If no posts were found.
		if(count($posts) == 0) {
			echo '<p>Inga inlägg hittades.</p>';
		}
		
		else {
		
			echo '<ul>';
			
			foreach($posts as $post) {
				$categories = get_the_category($post->ID); 
				render($post, $categories[0]->name);
			}
			
			echo '</ul>';
		
		}
		
		echo $after_widget;
	 }
	 
	 /**
	  * Back-end widget form.
	  *
	  * @see WP_Widget::form()
	  *
	  * @param array $instance	Previously saved values from the  database.
	  */
	public function form($instance) {
		$title = (isset($instance['title'])) ? $instance['title'] : 'Ny titel';
		$numberposts = (isset($instance['numberposts'])) ? $instance['numberposts'] : 5;
		?>
		<p>
			<label for="<?php echo $this->get_field_name('title'); ?>">Titel:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_name('numberposts'); ?>">Antal inlägg:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('numberposts'); ?>" name="<?php echo $this->get_field_name('numberposts'); ?>" type="text" value="<?php echo esc_attr($numberposts); ?>">
		</p> 
		<?php
	}
	  
	  /**
	   * Sanitize widget form values as they are saved.
	   *
	   * @see WP_Widget::update()
	   *
	   * @param array $new_instance Values just sent to be saved.
	   * @param array $old_instance Previously saved values from database.
	   *
	   * @return array Updated safe values to be saved.
	   */
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['numberposts'] = (!empty($new_instance['numberposts'])) ? $new_instance['numberposts'] : 5;

		return $instance;
	}
	 
}

?>