$(document).ready(function() {

$("#OrderByAvis").change(function(){
	window.location.replace($("#OrderByAvis").find(":selected").val());
});


 
});

