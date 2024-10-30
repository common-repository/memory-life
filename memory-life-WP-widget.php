<?php
/**
 * @package MemoryLife 
 * @version 0.1
 */
/*
Plugin Name: memory-life Widget
Plugin URI: http://addons.memory-life.com/wordpress
Description: A widget to display a part of your memories: photos, videos, sounds 
Version: 0.2
Author: fablamenas 
Author URI: http://memory-life.com
Author Email: fablamenas@gmail.com 
*/



/**
 * Example Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
class MemoryLife_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function MemoryLife_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'memory-life', 'description' => __('A widget to display a part of your memories', 'memory-life') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'memory-life-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'memory-life-widget', __('memory-life', 'memory-life'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$token = $instance['token'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Display name from widget settings if one was input. */
		if ( $token )
			printf( '<object id="MLswf" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="270" height=500  codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0"><param name="align" value="middle" /><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="true" /><param name="quality" value="high" /><param name="wmode" value="gpu" /><param name="bgcolor" value="#666677" /><param name="src" value="http://invitation.memory-life.com/partage/MLswf.swf?token=%1$s&amp;bgcolor=0xffb72d&amp;bordercolor=0x666666&amp;viewarray=explore" /><param name="name" value="MLswf" /><param name="allowfullscreen" value="true" /><embed id="MLswf" type="application/x-shockwave-flash" width="270" height=500 src="http://invitation.memory-life.com/partage/MLswf.swf?token=%1$s&amp;bgcolor=0xffb72d&amp;bordercolor=0x666666&amp;viewarray=explore" name="MLswf" bgcolor="#666677" wmode="gpu" quality="high" allowfullscreen="true" allowscriptaccess="always" align="middle"></embed></object>', $token );

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		
		$instance['token'] = $new_instance['token'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Example', 'example'), 'token' => '20100601190555236958' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Your Token: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'token' ); ?>"><?php _e('Your token:', 'example'); ?></label>
			<input id="<?php echo $this->get_field_id( 'token' ); ?>" name="<?php echo $this->get_field_name( 'token' ); ?>" value="<?php echo $instance['token']; ?>" style="width:100%;" />
		</p>
		<?php
		// OUI fabvien, on peut mettre du html dans du PHP? mais il ne faut pas oublier de réouvrir une balise PHP !!!
	

	}
}

// il vaut mieux sortir la fonction du "create_fonction" . (éviter potentiellement des failels de sécurité d'injection de code sur un exploit. (par exempls, tordu certes, mais si quelque'un arrive à inserer dans l'argument de create function , (par un  buffer of, ou autres failles de PHP ou d'apache, il peut te créer une fonction moche , et comme tous tes fichiers appartiennent apparement en ecriture et à apache, il peut te pourrir ton blog. 
function mlife_widget_init() {
        register_widget('MemoryLife_Widget');
}

// register FooWidget widget
add_action('widgets_init','mlife_widget_init' );


// 
// Pas la peine de fermer les balises PHP en fin de fichier, ça permet d'éviter les erreurs type "headers already sent" chiantes à debugguer
/* ?>*/
