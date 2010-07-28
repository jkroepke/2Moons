function getsectime(element, time) {
v = new Date();
n = new Date();
ssfs1 = time;
ssfs1 = ssfs1 - Math.round((n.getTime() - v.getTime()) / 1000.);
mfs1 = 0;
hfs1 = 0;
if (ssfs1 < 0) {
	$('#'+element).text("-");
} else {
	if (ssfs1 > 59) {
		mfs1 = Math.floor(ssfs1 / 60);
		ssfs1 = ssfs1 - mfs1 * 60;
	}
	if (mfs1 > 59) {
		hfs1 = Math.floor(mfs1 / 60);
		mfs1 = mfs1 - hfs1 * 60;
	}
	if (ssfs1 < 10) {
		ssfs1 = "0" + ssfs1;
	}
	if (mfs1 < 10) {
		mfs1 = "0" + mfs1;
	}
	$('#'+element).text(hfs1 + ":" + mfs1 + ":" + ssfs1);
}
time = time - 1;
window.setTimeout("getsectime('"+element+"', "+time+");", 1000);
}