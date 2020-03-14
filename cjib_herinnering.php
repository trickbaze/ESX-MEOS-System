<?php
require "config.php";
if ($_SESSION['loggedin'] != TRUE) {
	Header("Location: login.php?returnpage=aangifte");
}
$aangifte = $con->query("SELECT * FROM cjib WHERE id='".$con->real_escape_string($_GET['id'])."'");
$row = $aangifte->fetch_assoc();
?>
<html>
	<head>
		<title>Herinnering <?php echo $row['number'] ?></title>
		<link rel="icon" type="image/png" href="favicon.ico" />
		<meta name="theme-color" content="<?php echo $browser_color; ?>">
	</head>
	
	<body onload="window.print(false);">
		HERINNERING<br>
		Datum:<?php echo date('d-m-Y'); ?><br>
<br>
Geachte heer/mevrouw <?php echo $row['name']; ?><br>
<br>
Een poos geleden heeft u van de politie enkele boetes ontvangen. Deze zijn tot op de dag van vandaag nog niet betaald.<br>
<br>
Het Centraal Justitieel Incassobureau van Zoutelande heeft hier een melding van ontvangen en stelt u hierbij in gebreke. Wij verzoeken u dus ook om de openstaande verkeersboetes onverwijld te betalen, zodat het bedrag niet zal verhogen. <br>
Wij verwachten dat u het openstaande bedrag van <?php echo $row['open']; ?> binnen <?php echo $row['term']; ?> na dagtekening betaald heeft aan de politie via het facturensysteem. <br>
<br>
Mocht blijken dat u na uw betaaltermijn nog een bedrag open heeft staan krijgt u van het CJIB een aanmaning, dit bedrag is dan verhoogd met de wettelijke administratiekosten.<br>
Ook kunnen wij eigendommen van u in beslag nemen of kunt u in gijzeling worden genomen. Een gijzeling zal het bedrag van de vordering niet veranderen. <br>
Als u zo snel mogelijk betaald hoeven bovenstaande maatregelen natuurlijk niet getroffen te worden. <br>
<br>
Mocht deze brief uw betaling gekruist hebben, kunt u deze brief als niet verzonden beschouwen. <br>
<br>
Als u nog vragen heeft, kunt u zich wenden tot medewerkers van het Centraal Justitieel Incassobureau, bij het politiebureau van Zoutelande.<br>
<br>
Hoogachtend,<br>
<?php echo $row['user'] ?><br>
Namens, CJIB Zoutelande
	</body>
</html>