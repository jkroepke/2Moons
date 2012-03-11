var Gate	= {
	max: function(ID) {
		$('#ship'+ID+'_input').val($('#ship'+ID+'_value').text().replace(/\./g, ""));
	},
	
	submit: function() {
		$.getJSON('?page=information&mode=sendFleet&'+$('.jumpgate').serialize(), function(data) {
			if(data.error)
				Dialog.alert(data.message);
			else
				Dialog.alert(data.message, Dialog.close);
		});		
	}
}