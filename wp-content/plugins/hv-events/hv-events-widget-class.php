<?php

/**
 * Adds a widget that can show upcoming events.
 */

class HV_Events_Widget extends WP_Widget {
	
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'hv_events_widget', // Base ID
			'Evenemang', // Name
			array( 'description' => 'Visar några kommande evenemang.', ) //Args
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
		$posts = get_posts(array(
			'post_type'		=> 'events',
			'numberposts'	=> -1,
			'meta_key'		=> 'start_date',
			'orderby'		=> 'start_date',
			'order'			=> 'ASC'
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
			
			$c = 0;
			
			foreach($posts as $post) :
			
				if($c > $instance['numberposts']) break;
			
				$custom = get_post_custom($post->ID);
				$title = $post->post_title;
				$content = $post->post_content;
				$venue = $custom['venue'][0];
				$start_date = DateTime::createFromFormat('Y-m-d H:i', $custom['start_date'][0]);
				$end_date = DateTime::createFromFormat('Y-m-d H:i', $custom['end_date'][0]);
				$permalink = get_permalink($post->ID);
				
				if(time() > $start_date->format('U')) continue;
				else $c++;
				?>
				
				<li>
					<a href="<?php echo $permalink; ?>" class="event-list-item">
						<div class="event-date">
							<span class="day"><?php echo strftime('%d', $start_date->format('U')); ?></span>
							<span class="month"><?php echo strftime('%b', $start_date->format('U')); ?></span>
						</div>
						<div class="event-title">
							<?php echo $title; ?>
						</div>
						<div class="event-venue">
							<?php echo $venue; ?>
						</div>
						<div class="clear"></div>
					</a>
				</li>
				
			<?php endforeach;
			
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