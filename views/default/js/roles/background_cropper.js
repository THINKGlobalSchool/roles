/**
 * Background cropping (modified from core avatar cropper)
 */

elgg.provide('elgg.backgroundCropper');

/**
 * Register the avatar cropper.
 *
 * If the hidden inputs have the coordinates from a previous cropping, begin
 * the selection and preview with that displayed.
 */
elgg.backgroundCropper.init = function() {
	var params = {
		selectionOpacity: 0,
		onSelectEnd: elgg.backgroundCropper.selectChange,
		onSelectChange: elgg.backgroundCropper.preview,
		handles: true
	};

	if ($('input[name=bg_x2]').val()) {
		var x1 = $('input[name=bg_x1]').val();
		var x2 = $('input[name=bg_x2]').val();
		var y1 = $('input[name=bg_y1]').val();
		var y2 = $('input[name=bg_y2]').val();

		if ($('#user-background-cropper').hasClass('bg-downscaled')) {
			var $img = $('#user-background-cropper');
			var BG_ORIGINAL_WIDTH = $img.data('bg_original_width');
			var BG_NEW_WIDTH = $img.width();

			params.x1 = x1 * (BG_NEW_WIDTH / BG_ORIGINAL_WIDTH);
			params.x2 = x2 * (BG_NEW_WIDTH / BG_ORIGINAL_WIDTH);
			params.y1 = y1 * (BG_NEW_WIDTH / BG_ORIGINAL_WIDTH); 
			params.y2 = y2 * (BG_NEW_WIDTH / BG_ORIGINAL_WIDTH);

		} else {
			params.x1 = x1;
			params.x2 = x2;
			params.y1 = y1; 
			params.y2 = y2;
		}
	}

	$('#user-background-cropper').imgAreaSelect(params);

	if ($('input[name=bg_x2]').val()) {
		var ias = $('#user-background-cropper').imgAreaSelect({instance: true});
		var selection = ias.getSelection();
		elgg.backgroundCropper.preview($('#user-background-cropper'), selection);
	}
};

/**
 * Handler for changing select area.
 *
 * @param {Object} reference to the image
 * @param {Object} imgareaselect selection object
 * @return void
 */
elgg.backgroundCropper.preview = function(img, selection) {
	// catch for the first click on the image
	if (selection.width == 0 || selection.height == 0) {
		return;
	}
	/** Canvas fun! **/
	
	// Figure out scale (image may be shrunk down to fit cropper tool)
	var SCALE = $(img).data('bg_scale');
	var BG_WIDTH = $(img).data('bg_width');
	var BG_PREVIEW_WIDTH = $(img).data('bg_preview_width');
	var PREVIEW_SCALE = BG_PREVIEW_WIDTH / BG_WIDTH;

	// Get the master image for the pattern canvas
	var img = document.getElementById("user-background-cropper")
	
	// Create a pattern canvas element
	var pattern_canvas = document.createElement('canvas');

	// Determine height/width from selection
	var texture_width = selection.x2 - selection.x1;
	var texture_height = selection.y2 - selection.y1;

	var texture_width_scaled = texture_width * SCALE;
	var texture_height_scaled = texture_height * SCALE;

	var x1 = selection.x1;
	var x2 = selection.x2;
	var y1 = selection.y1;	
	var y2 = selection.y2;

	if ($(img).hasClass('bg-downscaled')) {
		var SCALE_DOWN_PERCENT = SCALE * 100;
		var SCALE_UP = (SCALE_DOWN_PERCENT / (1 - SCALE_DOWN_PERCENT/100) / 100) + 1;

		x1 = (x1 * SCALE_UP);
		y1 = (y1 * SCALE_UP);
		x2 = (x2 * SCALE_UP);
		y2 = (y2 * SCALE_UP);

		texture_width = Math.floor(texture_width * SCALE_UP);
		texture_height = Math.floor(texture_height * SCALE_UP);

		texture_width_scaled = texture_width * PREVIEW_SCALE;
		texture_height_scaled = texture_height * PREVIEW_SCALE;

		texture_width_scaled = texture_width * PREVIEW_SCALE;
		texture_height_scaled = texture_height * PREVIEW_SCALE;

		//@TODO cropping/scaling down selection
	}

	// Set pattern canvas dimensions
	pattern_canvas.width = texture_width_scaled;
	pattern_canvas.height = texture_height_scaled;

	// Get pattern canvas context for drawing
	var pattern_context = pattern_canvas.getContext('2d');

	// Draw the image
	pattern_context.drawImage(img, x1, y1, texture_width, texture_height, 0, 0, texture_width_scaled, texture_height_scaled);

	//$('#user-background-preview-title').html(pattern_canvas);

	// Get the existing preview canvas
	var preview_canvas = document.getElementById("user-background-preview-canvas");
	var preview_context = preview_canvas.getContext("2d");

	// Create a rectangle in the context matching canvas dimensions
	preview_context.rect(0, 0, preview_canvas.width, preview_canvas.height);

	// Clear it out for good measure
	preview_context.clearRect(0, 0, preview_canvas.width, preview_canvas.height); 

	// Create a pattern from the pattern canvas
	var pattern = preview_context.createPattern(pattern_canvas , "repeat");
   
   	// Set the pattern and fill!
    preview_context.fillStyle = pattern;
    preview_context.fill();
};

/**
 * Handler for updating the form inputs after select ends
 *
 * @param {Object} reference to the image
 * @param {Object} imgareaselect selection object
 * @return void
 */
elgg.backgroundCropper.selectChange = function(img, selection) {
	var BG_WIDTH = $(img).data('bg_width');

	// If we're downscaled
	if ($(img).hasClass('bg-downscaled')) {
		var BG_ORIGINAL_WIDTH = $(img).data('bg_original_width');
		var BG_NEW_WIDTH = $(img).width();

		// Scale values back up to crop properly in the crop action
		selection.x1 = Math.ceil(selection.x1 * (BG_ORIGINAL_WIDTH / BG_NEW_WIDTH));
		selection.x2 = Math.ceil(selection.x2 * (BG_ORIGINAL_WIDTH / BG_NEW_WIDTH));
		selection.y1 = Math.ceil(selection.y1 * (BG_ORIGINAL_WIDTH / BG_NEW_WIDTH));
		selection.y2 = Math.ceil(selection.y2 * (BG_ORIGINAL_WIDTH / BG_NEW_WIDTH));

		selection.width = selection.x2 - selection.x1;
		selection.height = selection.y2 - selection.y1;
		
		if (selection.width > BG_WIDTH) {
			// @TODO Do more things
		}
	}

    // Update form inputs
	$('input[name=bg_x1]').val(selection.x1);
	$('input[name=bg_x2]').val(selection.x2);
	$('input[name=bg_y1]').val(selection.y1);
	$('input[name=bg_y2]').val(selection.y2);
};

elgg.register_hook_handler('init', 'system', elgg.backgroundCropper.init);