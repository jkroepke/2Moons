Message	= {
	MessID : 0,
	GenerateMessages: function () {
		var HTML = "";
		var MESS = "";
		var data = (Message.MessID == 999) ? Message.MessListOut : Message.MessList;

		HTML += '<form action="" id="del" onsubmit="Message.DelMessages();return false"><table id="messages"><tr><th colspan="4">'+Message.LNG.mg_message_title+'</td></tr><tr style="height: 20px;"><td>'+Message.LNG.mg_action+'</td><td>'+Message.LNG.mg_date+'</td><td>';
		HTML += (Message.MessID != 999) ? Message.LNG.mg_from : Message.LNG.mg_to;
		HTML += '</td><td>'+Message.LNG.mg_subject+'</td></tr>';
		$.each(data, function(tmp, mess) {
			if((mess.type == Message.MessID || Message.MessID == 100 || Message.MessID == 999) && !$.isEmptyObject(mess)) {
				var TEMP = '';
				TEMP += '<tr class="message_head message_'+mess.id+'"><td style="width:40px;" rowspan="2">';
				TEMP += (mess.type != 50 && Message.MessID != 999) ?	'<input name="delmes['+mess.id+']" type="checkbox">' : '';
				TEMP += '</td><td>'+mess.time+'</td><td>';
				TEMP += (mess.type == 50 && Message.MessID != 999) ? Message.LNG.mg_game_message : mess.from;
				TEMP += '</td><td>'+mess.subject;
				TEMP += (mess.type == 1 && Message.MessID != 999) ? '<a href="#" onclick="OpenPopup(\'game.php?page=messages&amp;mode=write&amp;id='+mess.sender+'&amp;subject='+Message.CreateAnswer(mess.subject)+'\', \'\', 720, 300);" title="'+Message.LNG.mg_answer_to+' '+Message.stripHTML(mess.from)+'"><img src="'+Skin+'img/m.gif" border="0"></a>' : '';
				TEMP += '</td></tr><tr class="message_body message_'+mess.id+'"><td colspan="3" class="left">'+mess.text+'</td></tr>';
				if($.browser.webkit || $.browser.opera)
					MESS = TEMP + MESS;
				else
					MESS += TEMP;
			}
		});
		HTML += MESS;
		if(Message.MessID != 999 && Message.MessID != 50) {
			HTML += '<tr>';
			HTML += '<td colspan="4">';
			HTML += '<select id="deletemessages" name="deletemessages">';
			HTML += '<option value="deletemarked">'+Message.LNG.mg_delete_marked+'</option>';
			HTML += '<option value="deleteunmarked">'+Message.LNG.mg_delete_unmarked+'</option>';
			HTML += '<option value="deletetypeall">'+Message.LNG.mg_delete_type_all+'</option>';
			HTML += '<option value="deleteall">'+Message.LNG.mg_delete_all+'</option>';
			HTML += '</select>';
			HTML += '<input value="'+Message.LNG.mg_confirm_delete+'" type="button" onclick="Message.DelMessages()">';
			HTML += '</td></tr>';
		}
		HTML += '</table></form>';
		$('#messages').remove();
		$('#content table').eq(0).after(HTML);
	},

	MessageCount: function() {
		if(Message.MessID == 100) {
			$('#unread_0').text('0');
			$('#unread_1').text('0');
			$('#unread_2').text('0');
			$('#unread_3').text('0');
			$('#unread_4').text('0');
			$('#unread_5').text('0');
			$('#unread_15').text('0');
			$('#unread_99').text('0');
			$('#unread_100').text('0');
			$('#newmes').text('');
			$.get('ajax.php?action=updatemessages&messcat=100');
		} else {
			var count = parseInt($('#unread_'+Message.MessID).text());
			var lmnew = parseInt($('#newmesnum').text());
				
			$('#unread_'+Message.MessID).text('0');
			if(Message.MessID != 999) {
				$.get('ajax.php?action=updatemessages&messcat='+Message.MessID+'&count='+count);
				$('#unread_100').text($('#unread_100').text() - count);
			}
			if(lmnew - count <= 0)
				$('#newmes').text('');
			else
				$('#newmesnum').text(lmnew - count);
		}
	},

	getMessages: function (MessID) {
		Message.MessID	= MessID;
		if(parseInt($('#unread_'+Message.MessID).text()) != 0)
			Message.MessageCount();
			
		if(typeof Message.MessList == "undefined") {
			$.getJSON('ajax.php?action=getmessages&lang='+Lang, function(data) {
				Message.MessList	= data.MessageList;
				Message.LNG			= data.LNG;
				if(Message.MessID != 999)
					Message.GenerateMessages()
			});
			if(Message.MessID != 999)
				return;
		}
		if(Message.MessID == 999 && typeof Message.MessListOut == "undefined") {
			$.getJSON('ajax.php?action=getmessages&messcat=999', function(data) {
				Message.MessListOut	= data;
				Message.GenerateMessages();
			});
			return;
		}
		Message.GenerateMessages();
	},


	stripHTML: function (string) { 
		return string.replace(/<(.|\n)*?>/g, ''); 
	},

	CreateAnswer: function (Answer) {
		var Answer	= Message.stripHTML(Answer);
		if(Answer.substr(0, 3) == "Re:") {
			return 'Re[2]:'+Answer.substr(3);
		} else if(Answer.substr(0, 3) == "Re[") {
			var re = Answer.replace(/Re\[(\d+)\]:.*/, '$1');
			return 'Re['+(parseInt(re)+1)+']:'+Answer.substr(5+parseInt(re.length))
		} else {
			return 'Re:'+Answer
		}
	},

	DelMessages: function () {
		$.get('ajax.php?action=deletemessages&mess_type='+Message.MessID+'&'+$('#del').serialize());
		var infos	= $('#del').serializeArray();
		var mode	= infos[infos.length-1].value;
		infos.pop();
		
		if(mode == 'deleteunmarked' && Message.getMessagesIDs(infos).length == 0)
			mode = 'deletetypeall';
		if(Message.MessID == 100 && mode == 'deletetypeall')
			mode = 'deleteall';
		switch (mode)
		{
			case 'deleteall':
				Message.MessList	= {};
				$('#messages').remove();
				$('#total_0').text('0');
				$('#total_1').text('0');
				$('#total_2').text('0');
				$('#total_3').text('0');
				$('#total_4').text('0');
				$('#total_5').text('0');
				$('#total_15').text('0');
				$('#total_99').text('0');
				$('#total_100').text('0');
			break;
			case 'deletetypeall':
				$('#messages').remove();
				$('#total_100').text(parseInt($('#total_100').text()) - parseInt($('#total_'+Message.MessID).text()));
				$('#total_'+Message.MessID).text('0');
				$.each(Message.MessList, function(index, mess) {
					if(mess.type == Message.MessID)
						Message.MessList[index]	= {};
				});
			break;
			case 'deletemarked':
				var count	= 0;
				var ID		= 0;
				$.each(infos, function(index, mess) {
					if(mess.value == 'on') {
						ID	= mess.name.replace(/delmes\[(\d+)\]/, '$1');
						$('.message_'+ID).remove();
						Message.MessList[ID]	= {};
						count += 1;
					}
				});
				$('#total_100').text(parseInt($('#total_100').text()) - count);
				$('#total_'+Message.MessID).text(parseInt($('#total_'+Message.MessID).text()) - count);
				$("form#del input:checkbox").val([]);
			break;
			case 'deleteunmarked':
				var count = 0;
				var IDs	= Message.getMessagesIDs(infos);
				$.each(Message.MessList, function(index, mess) {
					if((Message.MessID == 100 || Message.MessID == mess.type) && $.inArray(String(index), IDs) == -1) {
						$('.message_'+index).remove();
						Message.MessList[index]	= {};
						count += 1;
					}
				});
				$('#total_100').text(parseInt($('#total_100').text()) - count);
				$('#total_'+Message.MessID).text(parseInt($('#total_'+Message.MessID).text()) - count);
				$("form#del input:checkbox").val([]);
			break;
		}
	},
	
	getMessagesIDs: function(Infos) {
		var IDs = [];
		$.each(Infos, function(index, mess) {
			if(mess.value == 'on')
				IDs.push(mess.name.replace(/delmes\[(\d+)\]/, '$1'));
		});	
		return IDs;
	}
}