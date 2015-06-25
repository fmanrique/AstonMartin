
$(document).ready(function(){
});

function delete_item(url) {
	c = confirm("Are you sure to delete this item?");

	if (c) {
		location.href = url;
	}
}