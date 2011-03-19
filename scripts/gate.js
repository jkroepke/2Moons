var Gate	= {
	max: function(ID) {
		$('#ship'+ID+'_input').val($('#ship'+ID+'_value').text().replace(/\./g, ""));
	},
	
	submit: function() {
		$.getJSON('?page=infos&gid=43&action=send&'+$('.jumpgate').serialize(), function(data) {
			if(data.error)
				alert(data.message);
			else
				alert(data.message, Dialog.close);
		});		
	},
	
	time: function() {
		$('#bxxGate1').text(function(i, sec){
			return GetRestTimeFormat(sec);
		})
	}
}