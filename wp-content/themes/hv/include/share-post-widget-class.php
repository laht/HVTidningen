<?php

/**
 * Adds a widget that gives a user options to share the post on Facebook, Twitter etc.
 */

class Share_Post_Widget extends WP_Widget {
	
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'share_post_widget', // Base ID
			'Dela inläggetlänkar', // Name
			array( 'description' => 'Visar ikoner och länkar för att dela inlägget på Facebook, Twitter, RSS etc.', ) //Args
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
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		global $post;
		
		if($post) {
		
			$permalink = get_permalink($post->ID);
			$post_title = $post->post_title;
			 
			echo $before_widget;
			if(!empty($title))
				echo $before_title . $title . $after_title;
			echo '<div class="share-post clearfix">';
			echo '<a class="facebook" href="http://www.facebook.com/sharer.php?u=' . $permalink . '&t=' . $post_title . '"></a>';
			echo '<a class="google" href="https://plus.google.com/share?url=' . $permalink . '"></a>';
			echo '<a class="twitter" href="http://twitter.com/home?status=' . $permalink . '"></a>';
			echo '<a class="mail" href="mailto:EPOSTADRESS?subject=Ämne&body=' . $permalink . '"></a>';
			echo '</div>';
			echo $after_widget;
		
		}
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
		?>
		<p>
			<label for="<?php echo $this->get_field_name('title'); ?>">Titel:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
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
		return $instance;
	}
	 
}

?>