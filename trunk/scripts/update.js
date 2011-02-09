$(function(){
  $(".containerPlus").buildContainers({
	containment:"document",
	elementsPath:"styles/css/mbContainer/",
	effectDuration:300,
	slideTimer:300,
	autoscroll:true,
  });
});

function openPWDialog() {
	$('.containerPlus').mb_open();
	$('.containerPlus').mb_centerOnWindow(false);
}