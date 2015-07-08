function request() {
    var this_host = window.location.protocol + "//" + window.location.hostname + "/ajax";
    var ob = new Object();
    ob.controller = "shorturl";
    ob.url = $('#url').val();
    ob.key = $('#key').val();
    output = JSON.stringify(ob);

	$.ajax ({
        url: this_host,
    	type: "POST",
        dataType: "JSON",
        data: { 'output' : output },
        cache: false,
        success:
        function(msg){
            alert (msg);
            }
		});

    }
