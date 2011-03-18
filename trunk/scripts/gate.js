var Gate	= {
	max: function(ID) {
		$('#ship'+ID+'_input').val($('#ship'+ID+'_value').text().replace(/\./g, ""));
	},
	
	submit: function() {
		$.get('?page=infos&gid=43&action=send&'+$('.jumpgate').serialize(), function(data) {
			alert(data);
		});		
	},
	
	time: function() {
		$('#bxxGate1').text(function(i, sec){
			return GetRestTimeFormat(sec);
		})
	}
}