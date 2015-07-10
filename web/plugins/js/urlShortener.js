function request_set() {
    var this_host = window.location.protocol + "//" + window.location.hostname + "/ajax";
    var ob = new Object();
    ob.controller = "shorturl";
    ob.url = $('#url').val();
    ob.key = $('#key').val();
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
    $("#result").text(" ");
    if (msg.error == "no") {
        $("#c_message").text("Copy the link from the field \"Short URL\" and insert in to the need block.");
        short_link = window.location.protocol + "//" + window.location.hostname + "/0" + msg.message;
        $("#result").text(short_link);
        }
    else {
        $("#c_message").text(msg.message);
        }
    }
