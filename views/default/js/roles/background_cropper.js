/**
 * TGS Roles Global JS Hooks Library
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

elgg.provide('elgg.backgroundCropper');

elgg.backgroundCropper.init = function() {
	var image_source = $('#master-bg').attr('src');

	var SCALE = $('#master-bg').data('bg_scale');

	// Init cropit
	$('#image-cropper').cropit({
		imageState: {
			src: image_source
		}, 
		exportZoom: SCALE,
		onZoomDisabled: function(e) {
			$('.cropit-control-container').addClass('cropit-zoom-disabled')	
		}
	});

	// Submit click handler
	$('#bg-submit').live('click', function(event) {
		var data = $('#image-cropper').cropit('export', {
			type: 'image/jpeg',
			quality: 1,
		});

		// Set hidden input to base64 encoded image data
		$('input[name=image_data]').val(data.replace('data:image/jpeg;base64,', ''));
	});
}

elgg.register_hook_handler('init', 'system', elgg.backgroundCropper.init);