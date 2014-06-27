<?php
class hvRSS {
	private static $ins = null;
	
	public static function init() {
		add_action('plugins_loaded', array(self::instance(), 'setup'));
	}
	
	public static function instance() {
		//Create a new object if one doesn't exist.
		is_null(self::$ins) && self::$ins = new self;
		return self::$ins;
	}
	
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
		wp_enqueue_script('hv-rss', $this->plugin_url . '/hv-rss.js');
	}
	
	function run() {
		echo '<header class="header clearfix">';
			echo '<img src="wp-content/plugins/hv-rss/img/rss-icon.png">';
			echo '<h1><a href="http://forsvarsmakten.se/" target="_blank">Förvarsmakten</a></h1>';
		echo '</header>';
		
		echo '<div class="widget-loader">Laddar RSS flöde...</div>';
		
		echo '<div class="items-cont">';
			echo '<div class="items">';
			echo '</div>';
		echo '</div>';
	}
}
?>