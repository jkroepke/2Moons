function submitftp()
{
	$.get('index.php?mode=ftp&lang='+location.search.split('&')[1].substr('-2')+'&'+$('#ftp').serialize(), function(data){
		if(data == "")
			location.reload();
		else
			alert(data);
	});
}