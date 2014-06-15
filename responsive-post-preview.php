<?php
/*
 * Plugin Name: Responsive Post Preview
 * Description: Adds the ability to preview your posts at different viewport sizes
 * Author: Jake Bresnehan
 * Author URI:  http://web-design-weekly.com
 * Plugin URI:  http://web-design-weekly.com
 * Version: 1.0.3
 */

class Responsive_Post_Preview {

	public function __construct() {

		// Register styles
		add_action( 'admin_enqueue_scripts', array( $this, 'styles' ) );

		// Fire up the javascript
		add_action( 'admin_footer', array( $this, 'javascript' ) );

		// Adds settings link to plugins page
		$plugin_file = 'responsive-post-preview/responsive-post-preview.php';
		add_filter( 'plugin_action_links_' . $plugin_file, array( $this, 'my_plugin_action_links' ) );

	}


	public function styles() {

		/* would be good to remove this out so it is not repeated in both functions */
		global $pagenow;

		if( 'post.php' != $pagenow ) {
			return;
		}

		wp_enqueue_style( 'my_custom_script', plugin_dir_url( __FILE__ ) . 'css/styles.css' );
	}


	public function javascript() {

		/* would be good to remove this out so it is not repeated in both functions */
		global $pagenow;

		if( 'post.php' != $pagenow ) {
			return;
		}
?>

		<script>
		(function($){

			var container,
				smallLink,
				mediumLink,
				currentPreviewURL = $('#post-preview').attr('href');


			container = "<div class=\"responsive-post-preview\"></div>";

			smallLink = "<a id=\"icon-mobile\" href=\"#\" target=\"wp-preview\" class=\"small\">Phone</a>";

			mediumLink = "<a id=\"icon-mobile2\" href=\"#\" target=\"wp-preview\" class=\"medium\">Tablet</a>";


			$('#minor-publishing-actions').append( container );
			$('.responsive-post-preview').append( smallLink );
			$('.responsive-post-preview').append( mediumLink );

			$('.responsive-post-preview a').attr('href', currentPreviewURL );


			$('.responsive-post-preview a').click(function(event) {
				event.preventDefault();

				var url = $(this).attr('href'),
					size = $(this).attr('class');

				OpenInNewTab(url, size);
				console.log(url);
				console.log(size);


			});


			function OpenInNewTab(url, size) {

				var w = window.open(),
					modifiedPage;

					// Lets determine the size and and do some magic

					if (size === 'small' ) {
						 modifiedPage = '<iframe src="' + url + '" width="320px" height="100%"></iframe>';
					}

					if (size === 'medium' ) {
						modifiedPage = '<iframe src="' + url + '" width="768px" height="1024px"></iframe>';
					}

				$(w.document.body).html(modifiedPage);

			}


		}(jQuery));
		</script>

<?php
	}

	/**
	 * Add settings link on plugins.php
	 *
	 * @since    1.0.2
	 */

	public function my_plugin_action_links( $links ) {
		$links[] = '<a href="http://web-design-weekly.com/support/" target="_blank">Support</a>';

		return $links;
	}


}
new Responsive_Post_Preview;