<?php
class hvFacebook {
	
	public function setup() {
		//Setup an absolute path to the plugin folder.
		$this->plugin_url = defined('WP_PLUGIN_URL') ? 
								trailingslashit(WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__))) : 
								trailingslashit(get_bloginfo('wpurl')) . PLUGINDIR . '/' . dirname(plugin_basename(__FILE__));
		
		//Add necessary scripts and styles.
		$this->add_scripts_and_styles();
		
		//Run.
		$this->run();
	}
	
	function add_scripts_and_styles() {
		//Scripts
		wp_enqueue_script('hv-facebook', $this->plugin_url . '/hv-facebook.js');
	}
	
	function run() {
		echo '<header class="header clearfix">';
			echo '<img src="wp-content/plugins/hv-facebook/img/facebook-icon.png">';
			echo '<h1><a href="https://www.facebook.com/TidningenHemvarnet" target="_blank">Facebook</a></h1>';
		echo '</header>';
		
		echo '<div class="widget-loader">Laddar Facebook flöde...</div>';
		
		echo '<div class="items-cont">';
			echo '<div class="items">';
			echo '</div>';
		echo '</div>';
	}
	
}
?>