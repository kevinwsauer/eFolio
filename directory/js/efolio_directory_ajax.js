jQuery(document).ready(function($) {
	var path = Template.path;			
	$("#directory").load(path, function() {
		$('#loading').remove();
	});
});