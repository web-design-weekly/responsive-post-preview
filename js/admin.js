
jQuery(document).ready(function ($) {

	//alert( "Image Option " + scriptParams.imgURL ); // the value from the PHP get_option call in the js

// Uploading files
var file_frame;

	$('.upload_image_button').on('click', function( event ){

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( file_frame ) {
			file_frame.open();
			return;
		}

		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
			title: $( this ).data( 'uploader_title' ),
			button: {
				text: $( this ).data( 'uploader_button_text' ),
			},
			multiple: false  // Set to true to allow multiple files to be selected
		});

		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
			// We set multiple to false so only get one image from the uploader
			attachment = file_frame.state().get('selection').first().toJSON();

			// Do something with attachment.id and/or attachment.url here
			//console.log(attachment);

			//$('.upload_image').val(attachment.url);
			$('#plugin_text_string').val(attachment.url);
			$('.upload_image_logo').attr("src", attachment.url);

			imageWidthHeight();


			//scriptParams.imgURL = attachment.url;

		});

		// Finally, open the modal
		file_frame.open();
	});


	//Update the image src if custom URL is entered
	$("#plugin_text_string").blur(function() {
		$('.upload_image_logo').attr("src", $(this).val());

		imageWidthHeight();

	});

	//Calculate the image height and width for the inputs
	function imageWidthHeight() {

		var img,
			width,
			height;

		img = $('.upload_image_logo');

		width = img.width();
		height = img.height();

		$('#plugin_image_width').val(width);
		$('#plugin_image_height').val(height);

	}

});
