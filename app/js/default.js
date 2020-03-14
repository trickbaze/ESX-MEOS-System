$(window).on('load', function() {
	if (localStorage.getItem("secKey") != null) {
		$.get( "https://meos.Zoutelanderp.nl/api/index.php?action=authenticate&secKey="+localStorage.getItem("secKey"))
		.done(function(data) {
			if (data == "ERROR") {
				localStorage.setItem("session", null);
				localStorage.setItem("secKey", null);
				document.location.href = 'login.html';
			}
		});
	} else {
		document.location.href = 'login.html';
	}
});