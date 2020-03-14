//GOOGLE AUTHHHHHHHHHHHHHHH
//try {
// sample arguments for registration
/*var createCredentialDefaultArgs = {
    publicKey: {
        // Relying Party (a.k.a. - Service):
        rp: {
            name: "Acme"
        },

        // User:
        user: {
            id: new Uint8Array(16),
            name: "john.p.smith@example.com",
            displayName: "John P. Smith"
        },

        pubKeyCredParams: [{
            type: "public-key",
            alg: -7
        }],

        attestation: "direct",

        timeout: 60000,

        challenge: new Uint8Array([ // must be a cryptographically random number sent from a server
            0x8C, 0x0A, 0x26, 0xFF, 0x22, 0x91, 0xC1, 0xE9, 0xB9, 0x4E, 0x2E, 0x17, 0x1A, 0x98, 0x6A, 0x73,
            0x71, 0x9D, 0x43, 0x48, 0xD5, 0xA7, 0x6A, 0x15, 0x7E, 0x38, 0x94, 0x52, 0x77, 0x97, 0x0F, 0xEF
        ]).buffer
    }
};*/

// sample arguments for login
/*var getCredentialDefaultArgs = {
    publicKey: {
        timeout: 60000,
        // allowCredentials: [newCredential] // see below
        challenge: new Uint8Array([ // must be a cryptographically random number sent from a server
            0x79, 0x50, 0x68, 0x71, 0xDA, 0xEE, 0xEE, 0xB9, 0x94, 0xC3, 0xC2, 0x15, 0x67, 0x65, 0x26, 0x22,
            0xE3, 0xF3, 0xAB, 0x3B, 0x78, 0x2E, 0xD5, 0x6F, 0x81, 0x26, 0xE2, 0xA6, 0x01, 0x7D, 0x74, 0x50
        ]).buffer
    },
};*/

// register / create a new credential
/*navigator.credentials.create(createCredentialDefaultArgs)
    .then((cred) => {
        console.log("NEW CREDENTIAL", cred);

        // normally the credential IDs available for an account would come from a server
        // but we can just copy them from above...
        var idList = [{
            id: cred.rawId,
            transports: ["ble"],
            type: "public-key"
        }];
        getCredentialDefaultArgs.publicKey.allowCredentials = idList;
        return navigator.credentials.get(getCredentialDefaultArgs);
    })
    .then((assertion) => {
        console.log("ASSERTION", assertion);
    })
    .catch((err) => {
        console.log("ERROR", err);
    });
} catch(e) {
	
}*/
	//GOOGLE AUTHHHHHHHHHHHHHHH

console.log("Loaded js.js");

function makeid() {
  var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < 32; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));

  return text;
}

console.log(makeid());
$(window).on('load', function() {
	if (localStorage.getItem("app_identifier") == null) {
		localStorage.setItem("app_identifier", makeid()+Date.now()+makeid());
	}
	
	if (localStorage.getItem("secKey") != null) {
		$.get( "https://meos.Zoutelanderp.nl/api/index.php?action=authenticate&secKey="+localStorage.getItem("secKey")+"&app_identifier="+localStorage.getItem("app_identifier"))
		.done(function(data) {
			if (data != "ERROR") {
				localStorage.setItem("session", data);
				document.location.href = 'index.html';
			} else {
				localStorage.setItem("session", null);
				localStorage.setItem("secKey", null);
			}
		});
	}
	
	console.log("JQuery is loaded");
	
	//Boot the form
	$("#code_1").focus();
	$("#code_1").attr("placeholder", Math.floor((Math.random() * 10) + 1));
	$("#code_2").attr("placeholder", Math.floor((Math.random() * 10) + 1));
	$("#code_3").attr("placeholder", Math.floor((Math.random() * 10) + 1));
	$("#code_4").attr("placeholder", Math.floor((Math.random() * 10) + 1));
	$("#code_5").attr("placeholder", Math.floor((Math.random() * 10) + 1));
	$("#code_6").attr("placeholder", Math.floor((Math.random() * 10) + 1));
	$(window).on('keyup', function(e) {
		console.log("Keyup detected");
		console.log($("#code_1").is(":focus"));
		console.log($("#code_2").is(":focus"));
		console.log($("#code_3").is(":focus"));
		console.log($("#code_4").is(":focus"));
		console.log($("#code_5").is(":focus"));
		console.log($("#code_6").is(":focus"));
		if ($("#code_1").is(":focus")) {
			$("#code_2").focus();
			return;
		}
		if ($("#code_2").is(":focus")) {
			$("#code_3").focus();
			return;
		}
		if ($("#code_3").is(":focus")) {
			$("#code_4").focus();
			return;
		}
		if ($("#code_4").is(":focus")) {
			$("#code_5").focus();
			return;
		}
		if ($("#code_5").is(":focus")) {
			$("#code_6").focus();
			return;
		}
	});
	
	$("#loginForm").on('submit', function(e) {
		e.preventDefault();
		console.log(e);
		var pin = $("#code_1").val()+$("#code_2").val()+$("#code_3").val()+$("#code_4").val()+$("#code_5").val()+$("#code_6").val();
		console.log(pin);
		var secKey = Date.now()+makeid();
		$.post( "https://meos.Zoutelanderp.nl/api/index.php?action=register_device", { pin: pin, secKey: secKey })
		.done(function( data ) {
			console.log(data);
			//Register sekKey in local storage
			localStorage.setItem("secKey", secKey);
			document.location.href = 'login.html';
			//secKey can be used to check the user permissions via ?action=authenticate - POST secKey
		});
	});
});