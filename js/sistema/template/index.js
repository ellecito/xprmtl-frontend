$(document).ready(function(){
	if (!Modernizr.borderradius) {
		$.getScript("http://malsup.github.com/jquery.corner.js", function() {
			$(".img-circle").corner();
			$(".img-rounded").corner();
		});
	}
});
