var	RevPoint	= 0;
var	DataPoint	= -1;
var	UpdateList	= new Array();

// Copy Array to bypass Reference Array Functions.
Array.prototype.copy = function () {
	return ((new Array()).concat(this));
};

function dirname(file) {
	var tmp = file.split('/');
	tmp.pop()
	return tmp.join('/')
}

function DisplayUpdates() {
	var HTML	= '';
	var List	= RevList.copy();
	List.reverse();
	if(List[0].version > CurrentVersion && $('#update').length == 0) {
		$('tr').eq(0).after('<tr id="update"><td><a href="#" onclick="updateGame();return false;">Update</a>'+(canDownload ? ' - <a href="?page=update&action=download">'+up_download+'</a>':'')+'</td></tr>');	
	} else {
		$('#update').remove();
	}
	$.each(List, function(i, data) {
		if(i == 0 && data.version > CurrentVersion)
			HTML	+= '<tr class="rev"><th colspan="5">'+up_last+'</th></tr>';
		else if(data.version == CurrentVersion)
			HTML	+= '<tr class="rev"><th colspan="5">'+up_current+'</th></tr>';
		else if(data.version == CurrentVersion - 1)
			HTML	+= '<tr class="rev"><th colspan="5">'+up_old+'</th></tr>';
		
		HTML	+= '<tr class="rev"><th>'+up_revision+' '+data.version+' '+data.date+' '+ml_from+' '+data.author+'</th></tr>';
		if(data.comment != '')
			HTML	+= '<tr class="rev"><td>'+data.comment+'</th></tr>';
		
		if(data.add.length != 0) {
			HTML	+= '<tr class="rev"><td>'+up_add+'<br>';
			$.each(data.add, function(i, file) {
				HTML	+= file+'<br>';
			});
			HTML	+= '</td></tr>';
		}
		if(data.edit.length != 0) {
			HTML	+= '<tr class="rev"><td>'+up_edit+'<br>';
			$.each(data.edit, function(i, file) {
				HTML	+= '<a href="http://code.google.com/p/2moons/source/diff?spec=svn'+data.version+'&r='+data.version+'&format=side&path=/trunk/'+file+'" target="diff">'+file+'</a><br>';
			});
			HTML	+= '</td></tr>';
		}
		if(data.del.length != 0) {
			HTML	+= '<tr class="rev"><td>'+up_del+'<br>';
			$.each(data.del, function(i, file) {
				HTML	+= file+'<br>';
			});
			HTML	+= '</td></tr>';
		}
	});
	$('.rev').remove();
	$('tr').eq(2).after(HTML);
}

function updateGame() {;
	UpdateList	= RevList.copy();
	UpdateList.shift();
	var Dirs	= new Array();
	$.each(UpdateList, function(i, data) {
		var Files	= data.add.concat(data.edit.concat(data.del));
		$.each(Files, function(i, file) {
			Dirs.push(dirname(file));
		});
	});
	Dirs	= $.unique(Dirs);
	$.getJSON('admin.php?page=update&action=check&'+$.param({dirs: Dirs}), function(data) {
		if(data.error == true) {
			alert(data.status);
			return;
		}
		$.get('admin.php?page=update&action=update', function() {
			initRev();
		});
	});
}

function initRev() {
	$.ajaxSetup({async: false});
	$.each(UpdateList, function(i, data) {
		$.each(data.add, function(i, file) {
			$.getJSON('update.php?r='+data.version+'&mode=add&file='+file);
		});
		$.each(data.edit, function(i, file) {
			$.getJSON('update.php?r='+data.version+'&mode=edit&file='+file);
		});
		$.each(data.del, function(i, file) {
			$.getJSON('update.php?r='+data.version+'&mode=del&file='+file);
		});
		$.get('update.php?r='+data.version+'&mode=update&file=0');
		CurrentVersion	= data.version;
		$('#version').val('1.3.'+CurrentVersion);
		RevList.shift();
	});
	$.ajaxSetup({async: true});
	done();
}

function done() {
	$.get('update.php?mode=unlink', function() {
		alert('Done');
		DisplayUpdates();
	});
}