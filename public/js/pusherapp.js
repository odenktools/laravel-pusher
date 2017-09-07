var Cookies2 = Cookies.noConflict();

$(document).ready(function () {

	var started = false;

	var myusername = null;
	
	var privatePusherChannel = 'private-test-channel';
	
	var privatePusherEvent = 'client-test-event';

	// ======================== Pusher initialize ======================== //
	var pusher = new Pusher(pusherKey, {
			encrypted: true,
			authTransport: 'ajax',
			authEndpoint: authEndpoint,
			auth: {
				headers: {
					'X-CSRF-Token': crsf
				}
			}
		});
	// ======================== /Pusher initialize ======================== //

	var form = $('#formchat');

	var resultText = $('#dataResults');

	var formMessage = $('#message');

	var membersList = $('#members-list');

	var membersCount = $('#membercount');

	resultText.val('Waiting HTTP response');

	function getName() {
		var name = Cookies2.get('name');
		if (name === 'null' || name === undefined || name === '') {
			$('#startusername').removeClass('hide').show();
		} else {
			$('#room').removeClass('hide').show();
			$('#roomconsole').removeClass('hide').show();
			$('#roomjoin').hide();
			$('#myusername').val(name);
			runSocket();
		}
	}

	getName();

	$("#btn_disconnect").click(function (event) {
		event.preventDefault();
		Cookies2.remove('name');
		pusher.disconnect();
		window.location.reload();
	});

	$('#username').keypress(function (e) {
		var key = e.which;
		if (key == 13) // the enter key code
		{
			registerUsername();
			return false;
		}
	});

	$('#start').click(function () {
		if (started)
			return;
		started = true;
		$(this).attr('disabled', true).unbind('click');
		$('#roomjoin').removeClass('hide').show();
		$('#registernow').removeClass('hide').show();
		$('#register').click(registerUsername);
		$('#username').focus();
	});

	function registerUsername() {

		var name = Cookies2.get('name');

		if (!name || name === 'null') {

			if ($('#username').length === 0) {
				// Create fields to register
				$('#register').click(registerUsername);
				$('#username').focus();
			} else {
				$('#username').attr('disabled', true);
				$('#register').attr('disabled', true).unbind('click');
				var username = $('#username').val();
				if (username === "") {
					$('#you')
					.removeClass().addClass('label label-warning')
					.html("Insert your display name (e.g., pippo)");
					$('#username').removeAttr('disabled');
					$('#register').removeAttr('disabled').click(registerUsername);
					return;
				}
				myusername = username;
				$('#myusername').val(username);
				Cookies2.set('name', myusername);
				$('#room').removeClass('hide').show();
				$('#roomconsole').removeClass('hide').show();
				$('#roomjoin').hide();
				runSocket();
			}

		}
	}

	function runSocket() {

		function ajaxCallRequest(f_method, f_url, f_data) {
			$("#dataSent").val(unescape(f_data));
			//var f_contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
			var f_contentType = "application/json";
			$.ajax({
				url: f_url,
				type: f_method,
				contentType: f_contentType,
				dataType: 'json',
				data: f_data,
				headers: {
					'X-CSRF-Token': crsf
				},
				beforeSend: function () {
					$('#sendSerialized').attr('disabled', true);
				},
				complete: function () {},
				success: function (data) {
					formMessage.val('');
					resultText.val(data.message);
					$('#sendSerialized').attr('disabled', false);
				}
			});
		}

		function triggerPusher() {
			var form = $('#formchat');
			var method = form.attr('method');
			var url = form.attr('action');
			var json = $('form#formchat').serializeJSON();
			ajaxCallRequest(method, url, json);
		}

		$("#sendSerialized").click(function (event) {
			event.preventDefault();
			triggerPusher();
		});

		$('#message').keypress(function (e) {
			var key = e.which;
			if (key == 13) {
				e.preventDefault();
				triggerPusher();
				return false;
			}
		});

		// =========================== PUSHER CHANNEL ==================== //
		var channel = pusher.subscribe(privatePusherChannel);
		channel.bind(privatePusherEvent, function (data) {
			$('#messages-list').append($('<li>').text(data));
		});
		// =========================== /PUSHER CHANNEL ================== //
		
		pusher.connection.bind('connected', function () {
			$('#start').removeAttr('disabled').html("Stop")
			.click(function () {
				$(this).attr('disabled', true);
				started = false;
				pusher.disconnect();
				window.location.reload();
			});
		});

	}

});
