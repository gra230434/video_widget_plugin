<?php
/**
 * Plugin Name: video Post Widget
 * Plugin URI: http://www.technologyofkevin.com
 * Description: video sidebar only for ams lab
 * Author: Kevin Wei
 * Version: 1.0
 * Author URI: http://www.technologyofkevin.com
 */

add_action( 'widgets_init', 'postvideo_register_widgets' );

function postvideo_register_widgets() {
	register_widget( 'VideoPostWidget' );  //VideoPostWidget
}

/**
 * Ｖideo Post Widget
 * only for video tag in HTML5
 * @since 1.0
 */

class VideoPostWidget extends WP_Widget {

// init
	function __construct() {
		$widget_ops = array( 'classname' => 'VideoPostWidget', 'description' => 'Displays a video in yout web' );
		parent::__construct( 'Video_Post_Widget', 'Video Post', $widget_ops );
	}

// front-end
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = $instance['title'];
		$is_youtube = $instance['is_youtube'];
		$video = $instance['videourl'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display name from widget settings if one was input. */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* If show announcement was selected, display the announcement. */
		if ( $video ){
			if ( $is_youtube == True ){
				$new_videourl = substr(strrchr($video, '='), 1);
				echo '<iframe width="300" height="169" src="https://www.youtube.com/embed/' . $new_videourl . '?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>';
			} else {
				echo '<video width="100%" autoplay loop muted>';
				echo '<source src="' . $video . '" type="video/mp4">';
				echo '<p>Sorry.<br>Your browser does not support the video tag.<br>please try Google Chrome or Firefox</p>';
				echo '</video>';
			}
		}
		/* After widget (defined by themes). */
		echo $after_widget;
	}

// update
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['is_youtube'] = strip_tags( $new_instance['is_youtube'] );
		$instance['videourl'] = strip_tags( $new_instance['videourl'] );

		return $instance;
	}

// back-end
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'video',
		                   'is_youtube' => False,
		                   'videourl' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = $instance['title'];
		$is_youtube = $instance['is_youtube'];
		$videourl = $instance['videourl'];?>

		<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title: </label>
		<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" style="width:100%;" />

		<?php if ($instance['is_youtube']): ?>
			<input type="checkbox" name="<?php echo $this->get_field_name( 'is_youtube' ); ?>" value="yes" checked> Is youtube<br>
		<?php else: ?>
			<input type="checkbox" name="<?php echo $this->get_field_name( 'is_youtube' ); ?>" value="no"> Is youtube<br>
		<?php endif; ?>

		<label for="<?php echo $this->get_field_id( 'videourl' ); ?>">video url</label>
    <input id="<?php echo $this->get_field_id( 'videourl' ); ?>" name="<?php echo $this->get_field_name( 'videourl' ); ?>" cols="20" rows="10" value="<?php echo esc_attr( $videourl ); ?>"  style="width:100%;" />

	<?php
	}
}

?>
