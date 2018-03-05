var close = document.getElementsByClassName("closebtn");
var i;

for (i = 0; i < close.length; i++) {
    close[i].onclick = function(){
        var div = this.parentElement;
        div.style.opacity = "0";
        setTimeout(function(){ div.style.display = "none"; }, 600);
    }
}

function camera_file(){
	var button = document.getElementById("camera_file");
	button.click();
}

function file_send(){
	var button = document.getElementById("camera_send");
	button.click();
}

function filter_send(nb){

	if (nb == 1) {
		var button = document.getElementById("filter_1");
		document.getElementById("filter_view_1").style.opacity = 1;
		document.getElementById("filter_view_2").style.opacity = 0;
		document.getElementById("filter_view_3").style.opacity = 0;
		button.click();
	}
	else if (nb == 2) {
		var button = document.getElementById("filter_2");
		document.getElementById("filter_view_1").style.opacity = 0;
		document.getElementById("filter_view_2").style.opacity = 1;
		document.getElementById("filter_view_3").style.opacity = 0;
		button.click();
	}
	else{
		var button = document.getElementById("filter_3");
		document.getElementById("filter_view_1").style.opacity = 0;
		document.getElementById("filter_view_2").style.opacity = 0;
		document.getElementById("filter_view_3").style.opacity = 1;
		button.click();
	}
}

///////////////////////////////////////////////////////////////////

function delete_picture(id) {
 window.location  = "http://localhost:8888/studio.php?del=" + id;
}
