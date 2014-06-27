<?php

/**
 * Adds a widget that can show some related posts.
 */

class Popular_Posts_Widget extends WP_Widget {
	
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'popular_posts_widget', // Base ID
			'Populära inlägg', // Name
			array( 'description' => 'Visar populära inlägg.', ) //Args
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
		
		global $wp_query;
		
		//If there are no post then return false.
		if(!isset($wp_query)) return false;
		
		$category = $wp_query->get_queried_object();
		
		/* Note:
		 * The function render each individual post in the sidebar is moved to another
		 * file so I can use the same file on multiple widgets.
		 */
		require_once('render-widget-post.php');
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		$posts = get_posts(array(
			'category_name' => $category->name,
			'orderby' => 'comment_count',
			'numberposts' => $instance['numberposts']
		));
		 
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
				$comments_count = wp_count_comments($post->ID);
				$number = $comments_count->approved;
				$text = sprintf( _n( '1 kommentar', '%s kommentarer', $number ), $number );
				render($post, $text);
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