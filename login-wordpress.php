<?php 

/*
	Plugin Name: Elvanto Wordpress Login Widget
	Plugin URI: https://www.elvanto.com
	Description: Plugin for adding an Elvanto Login Widget to your Wordpress Site
	Author: Aaron Maurice
	Version: 1.0
	Author URI: https://www.elvanto.com
*/

class Elvanto_Login_Widget extends WP_Widget {

	//Setup
	function __construct() {
		parent::__construct(
			'elvanto_login_widget',
			__('Elvanto Login'),
			array('description' => __('Log in to Elvanto from your Wordpress site!'))
		);
	}

	// Output
	public function widget($args, $instance) {
		echo $args['before_widget'];
		if (!empty($instance['title'])) {
			echo $args['before_title'] . apply_filters('widget_title', $instance['title'] ). $args['after_title'];
		}
		echo '<form action="https://' . $instance['subdomain'] . '.' . $instance['region'] . '/login/" method="post">';
		echo '<input type="hidden" name="redirect_to" value="https://' . $instance['subdomain'] . '.' . $instance['region'] . '/">';
		echo '<p><label for="login_username">Username or Email</label><br><input type="text" name="login_username" id="login_username" autocomplete="off"></p>';
		echo '<p><label for="login_password">Password</label><br><input type="password" name="login_password" id="login_password" autocomplete="off"></p>';
		echo '<p><label><input type="checkbox" name="remember_me" value="1"> Remember me</label></p>';
		echo '<p><button type="submit">Log In</button></p>';
		echo '</form>';
		echo '<p><a href="https://' . $instance['subdomain'] . '.' . $instance['region'] . '/login/?action=lostpassword">I forgot my password</a></p>';
		echo $args['after_widget'];
	}

	//Input
	public function form($instance) {
		$title = !empty($instance['title']) ? $instance['title'] : __('New Title');
		$subdomain = !empty($instance['subdomain']) ? $instance['subdomain'] : $instance['subdomain'];
		$location = !empty($instance['location']) ? $instance['location'] : $instance['location'];
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
			<input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>
		<p><?php _e('Display a title for your widget'); ?></p>
		<p>
			<label for="<?php echo $this->get_field_id('subdomain'); ?>"><?php _e('Sub Domain:'); ?></label> 
			<input class="widefat" name="<?php echo $this->get_field_name('subdomain'); ?>" type="text" value="<?php echo esc_attr($subdomain); ?>">
		</p>
		<p><?php _e('This is your account sub domain of Elvanto'); ?></p>
		<p>
			<label for="<?php echo $this->get_field_id('region'); ?>"><?php _e('Region Domain:'); ?></label> 
			<select class="widefat" name="<?php echo $this->get_field_name('region'); ?>">
				<option value="elvanto.com.au"<?php selected($instance['region'], 'elvanto.com.au'); ?>>.elvanto.com.au</option>
				<option value="elvanto.net"<?php selected($instance['region'], 'elvanto.net'); ?>>.elvanto.net</option>
				<option value="elvanto.eu"<?php selected($instance['region'], 'elvanto.eu'); ?>>.elvanto.eu</option>
			</select>
		</p>
		<p><?php _e('This is your region domain of Elvanto'); ?></p>
		<?php 
	}

	// Save
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['subdomain'] = (!empty($new_instance['subdomain'])) ? strip_tags($new_instance['subdomain']) : '';
		$instance['region'] = (!empty($new_instance['region'])) ? strip_tags($new_instance['region']) : '';
		return $instance;
	}

}

// register Elvanto_Login_Widget widget
function register_elvanto_login_widget() {
    register_widget( 'Elvanto_Login_Widget' );
}
add_action( 'widgets_init', 'register_elvanto_login_widget' );