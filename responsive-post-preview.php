<?php
/*
 * Plugin Name: Responsive Post Preview
 * Description: Adds the ability to view your posts at different viewport sizes
 * Author: Jake Bresnehan
 * Version: 1.0
 */

class Responsive_Post_Preview {

	public function __construct() {
		add_action( 'admin_footer', array( $this, 'javascript' ) );
	}

	public function javascript() {

		global $pagenow;

		// If on post screen insert html into side widget
		// when that link is clicked open up a new tab with the post.

		// when that is working, work out how to open a new tab that has the body set at a specific size

		//http://stackoverflow.com/questions/9399354/how-to-open-a-new-window-and-insert-html-into-it-using-jquery


		if( 'post.php' != $pagenow ) {
			return;
		}
?>

		<script>
		(function($){

			var previewLinkHtml = "<div id='responsive-post-preview'><a href=\"#\" target=\"wp-preview\">Responsive Post Preview — Tablet</a></div>",
				currentPreviewURL = $('#post-preview').attr('href');


			$('#minor-publishing-actions').append( previewLinkHtml );
			$('#responsive-post-preview a').attr('href', currentPreviewURL );


			$('#responsive-post-preview a').click(function(event) {
				event.preventDefault();
				var url = $(this).attr('href');

				//OpenInNewTab(url);
				OpenInNewTab(url);


			});


			function OpenInNewTab(url) {
				var w = window.open();

					$.ajax({
					url: url,
					dataType: 'html',
					beforeSend: function () {
					},
					success: function(html) {

						// Lets go grab the content and and do some magic
						//var modifiedPage =  html + '<script src ="#">';

						var modifiedPage = '<style type="text/css">body {height: 1024px; width: 768px; margin: 0 auto !important; overflow: scroll;}</style>' + html;

						//console.log(modifiedPage);

						$(w.document.body).html(modifiedPage);
						win.focus();


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