$(function() {
	$(".processbar").css("width", "1px");
	$(".info").text("0%");
	$.getJSON("?page=vertify&action=getFileList&"+document.location.search.split("&").pop(), startCompare);	
});

function startCompare(Filelist) {
	$('#result > td > div').empty();
	compareFiles(Filelist, 0);
}

function compareFiles(Filelist, Pointer) {
	if(typeof Filelist[++Pointer] === "undefined")
		return;
		
	var File	= Filelist[Pointer];
	var ELE		= $("<div />").text("File: "+File).appendTo('#result > td > div');
	$("#result > td > div").scrollTop($("#result > td > div").scrollTop() + 14);
	$.ajax({
		url: "?page=vertify&action=check&file="+File,
		success: function(TEXT) {
			$(".processbar").css("width", (((Pointer + 1) / Filelist.length) * 100)+"%");
			$(".info").text(Math.ceil(((Pointer + 1) / Filelist.length) * 100)+"%");
			if(TEXT == 1) {
				ELE.css("background-color", "green");
				$("#fileok").text(function(i, old) {
					return parseInt(old) + 1;
				});
			} else if(TEXT == 2) {
				ELE.css("background-color", "red");
				$("#filefail").text(function(i, old) {
					return parseInt(old) + 1;
				});
			} else if(TEXT == 3) {
				ELE.css("background-color", "orange");
				$("#fileerror").text(function(i, old) {
					return parseInt(old) + 1;
				});
			} else if(TEXT == 4) {
				ELE.css("background-color", "grey");
				ELE.css("color", "black");
				$("#filenew").text(function(i, old) {
					return parseInt(old) + 1;
				});
			} 
			compareFiles(Filelist, Pointer);
		}
	});	
}