<?php

/*
    Plugin Name: Elvanto Login Widget
    Plugin URI: https://www.elvanto.com
    Description: Plugin for adding an Elvanto Login Widget to your Wordpress Site
    Author: Elvanto
    Version: 1.1
    Author URI: https://www.elvanto.com
*/

class ElvantoLoginWidget extends WP_Widget {

    //Setup
    function __construct() {
        parent::__construct(
            'elvanto_login_widget',
            __('Elvanto Login'),
            array(
                'description' => __('Log in to Elvanto from your Wordpress site')
            )
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
        echo '<p><label for="login_username">' . __('Username or Email') . '</label><br><input type="text" name="login_username" id="login_username" autocomplete="off"></p>';
        echo '<p><label for="login_password">' . __('Password') . '</label><br><input type="password" name="login_password" id="login_password" autocomplete="off"></p>';
        echo '<p><label><input type="checkbox" name="remember_me" value="1">' . __('Remember me') . '</label></p>';
        echo '<p><button type="submit">Log In</button></p>';
        echo '</form>';
        echo '<p><a href="https://' . $instance['subdomain'] . '.' . $instance['region'] . '/login/?action=lostpassword">' . __('I forgot my password') . '</a></p>';
        echo $args['after_widget'];
        echo '<p>' . __('Or login via') . ':</p>';
        echo '<p><a href="https://socialauth.elvanto.com/?service=facebook&amp;action=login&amp;redirect_to=https%3A%2F%2F' . $instance['subdomain'] . '.' . $instance['region'] . '%2Flogin%2F%3Fredirect_to%3D%252F" class="btn btn-el-fb"><i class="fa fa-lg fa-left fa-facebook"></i>Facebook</a></p>';
        echo '<p><a href="https://socialauth.elvanto.com/?service=google&amp;action=login&amp;redirect_to=https%3A%2F%2F' . $instance['subdomain'] . '.' . $instance['region'] . '%2Flogin%2F%3Fredirect_to%3D%252F" class="btn btn-el-g"><i class="fa fa-lg fa-left fa-google"></i>Google</a></p>';

    }

    // Input
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('New Title');
        $subdomain = !empty($instance['subdomain']) ? $instance['subdomain'] : $instance['subdomain'];
        $location = !empty($instance['region']) ? $instance['region'] : $instance['region'];
        echo '<p><label for="' . $this->get_field_id('title') . '">' . _e('Title:') . '</label>';
        echo '<input class="widefat" name="' . $this->get_field_name('title') . '" type="text" value="' . esc_attr($title) . '"></p>';
        echo '<p>' . __('Display a title for your widget') . '</p>';
        echo '<p><label for="' . $this->get_field_id('subdomain') . '">' . __('Sub Domain:') . '</label>';
        echo '<input class="widefat" name="' . $this->get_field_name('subdomain') . '" type="text" value="' . esc_attr($subdomain) . '"></p>';
        echo '<p>' . __('This is your account sub domain of Elvanto') . '</p>';
        echo '<p><label for="' . $this->get_field_id('region') . '">' . __('Region Domain:') . '</label>';
        echo '<select class="widefat" name="' . $this->get_field_name('region') . '">';
        echo '<option value="elvanto.com.au"' . selected($instance['region'], 'elvanto.com.au') . '>.elvanto.com.au</option>';
        echo '<option value="elvanto.net"' . selected($instance['region'], 'elvanto.net') . '>.elvanto.net</option>';
        echo '<option value="elvanto.eu"' . selected($instance['region'], 'elvanto.eu') . '>.elvanto.eu</option>';
        echo '</select></p>';
        echo '<p>' . __('This is your region domain of Elvanto') . '</p>';

    }

    // Save
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['subdomain'] = (!empty($new_instance['subdomain'])) ? strip_tags($new_instance['subdomain']) : '';
        $instance['region'] = (!empty($new_instance['region'])) ? strip_tags($new_instance['region']) : '';
        return $instance;
    }

}

// register ElvantoLoginWidget widget
function register_elvanto_login_widget() {
    register_widget( 'ElvantoLoginWidget' );
}
add_action( 'widgets_init', 'register_elvanto_login_widget' );
