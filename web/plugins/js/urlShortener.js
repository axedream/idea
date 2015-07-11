function request_set() {
    var this_host = window.location.protocol + "//" + window.location.hostname + "/ajax";
    var ob = new Object();
    ob.controller = "shorturl";
    ob.url = $('#input_url').val();
    ob.action   = 'set';
    output = JSON.stringify(ob);

	$.ajax ({
        url: this_host,
    	type: "POST",
        dataType: "JSON",
        data: { 'output' : output },
        cache: false,
        success:
        function(msg){ getMessage(msg); }
		});
    }

function getMessage(msg) {
    $("#url").text(" ");
    $("#message").text(" ");
    if (msg.error == "no") msg.url = window.location.protocol + "//" + window.location.hostname + "/0" + msg.url;
    $("#message").text(msg.message);
    $("#url").text(msg.url);
    }
