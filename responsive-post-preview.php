<?php
/*
 * Plugin Name: Responsive Post Preview
 * Description: Adds the ability to view your posts at different viewport sizes
 * Author: Jake Bresnehan
 * Version: 1.0
 */

class Responsive_Post_Preview {

	public function __construct() {

		// Register styles
		add_action( 'admin_enqueue_scripts', array( $this, 'styles' ) );

		// Fire up the javascript
		add_action( 'admin_footer', array( $this, 'javascript' ) );

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

					$.ajax({
					url: url,
					dataType: 'html',
					beforeSend: function () {
					},
					success: function(html) {

						// Lets go grab the content and and do some magic

						if (size === 'small' ) {
							modifiedPage = '<style type="text/css">body {height: 480px; width: 320px; margin: 0 auto !important; overflow: scroll;}</style>' + html;
						}

						if (size === 'medium' ) {
							modifiedPage = '<style type="text/css">body {height: 1024px; width: 768px; margin: 0 auto !important; overflow: scroll;}</style>' + html;
						}

						$(w.document.body).html(modifiedPage);

					},
					error: function() {
						console.log("Oh the internet broke....");
					}
				});

			}


		}(jQuery));
		</script>

<?php
	}

}
new Responsive_Post_Preview;