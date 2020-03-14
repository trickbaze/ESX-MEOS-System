<?php
require "config.php";

if ($_SESSION['loggedin'] != TRUE) {
	Header("Location: login");
}
$inw = $ddcon->query("SELECT * FROM users");
$hvs = $ddcon->query("SELECT * FROM users WHERE job = 'police' OR job = 'ambulance'");
$gev = $ddcon->query("SELECT * FROM jail");
$voe = $ddcon->query("SELECT * FROM owned_vehicles");
$moncon = $ddcon->query("SELECT sum(money) as tot FROM users");
$monconr = $moncon->fetch_assoc();

$monban = $ddcon->query("SELECT sum(bank) as tot FROM users");
$monbanr = $monban->fetch_assoc();

$openb = $ddcon->query("SELECT sum(amount) as tot FROM billing WHERE target='society_police'");
$openbr = $openb->fetch_assoc();

$logc = $con->query("SELECT * FROM livelog");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (isset($_POST['anotitie']) AND trim($_POST['anotitie']) != "") {
		$con->query("INSERT INTO anotitie (user_id,text) VALUES ('".$con->real_escape_string($_SESSION['id'])."','".$con->real_escape_string($_POST['anotitie'])."')");
		Header("Location:index");
	}
}

if (@$_GET['action'] == "deleteanotitie") {
	$con->query("DELETE FROM anotitie WHERE id = '".$_GET['id']."'");
	Header("Location: index.php");
}

$specialisaties = $con->query("SELECT specialisaties FROM users WHERE id = '".$_SESSION['id']."'");
//var_dump($specialisaties->fetch_assoc()['specialisaties']);
//exit;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Meerstad | MEOS Systeem</title>
  <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon"/>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <!-- <link rel="icon" type="image/png" href="favicon.ico" /> -->
<meta name="theme-color" content="<?php echo $browser_color; ?>">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-red fixed-top" id="mainNav">
    <a class="navbar-brand" href="#"><img id="logo-meos" src="img/logo.png"></a><p id="header-text">MEOS</p>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="#">
          <i class="fa fa-home"></i>
            <span class="nav-link-text">Homepagina</span>
          </a>
        </li>

		<?php if ($_SESSION['role'] != "anwb") { ?>
		<?php } ?>
		<?php
	  if ($_SESSION['role'] != "anwb") {
	  ?>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="basisadministratie">
            <i class="fa fa-fw fa-area-chart"></i>
            <span class="nav-link-text">Basisadministratie</span>
          </a>
        </li>
	  <?php } ?>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="voertuigregistratie">
            <i class="fa fa-fw fa-area-chart"></i>
            <span class="nav-link-text">Voertuigregistratie</span>
          </a>
        </li>
		<?php if (@$_SESSION['cjib'] == 1) { ?>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="cjib">
            <i class="fa fa-fw fa-list"></i>
            <span class="nav-link-text">CJIB</span>
          </a>
        </li>
		<?php } ?>
			  <?php
	  if ($_SESSION['role'] != "anwb") {
	  ?>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="/intranet">
            <i class="fa fa-folder"></i>
            <span class="nav-link-text">Intranet</span>
          </a>
        </li>
	  <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="training">
            <i class="fa fa-fw fa-book"></i>
            <span class="nav-link-text">Training</span>
          </a>
        </li>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="aangiftes">
            <i class="fa fa-fw fa-area-chart"></i>
            <span class="nav-link-text">Aangifteadministratie</span>
          </a>
        </li>
	  <?php } ?>
		<?php if ($_SESSION['role'] == "admin") { ?>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="gebruikers">
            <i class="fa fa-user-circle"></i>
            <span class="nav-link-text"> Gebruikersadministratie</span>
          </a>
        </li>
		
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="jaillog">
            <i class="fa fa-history"></i>
            <span class="nav-link-text">Logboeken</span>
          </a>
        </li>
		<?php } ?>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="exit.php">
            <i class="fa fa-sign-out"></i>
            <span class="nav-link-text">Uitloggen</span>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <!--<a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
        </li>-->
      </ul>
    </div>
  </nav>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        
      </ol>
	  <div class="row">
	 <?php
	  if ($_SESSION['role'] != "anwb") {
	  ?>
        <div class="col-xl-3 col-sm-6 mb-3">
        <a href="basisadministratie" class="fill-div"><div class="bg-primary knop">
              <img id="icon-meos" src="img/user-shape.svg"><p class="text-button">Persoon</p>
          </div></a>
        </div>
	  <?php } ?>
        <div class="col-xl-3 col-sm-6 mb-3">
        <a href="voertuigregistratie" class="fill-div"><div class="bg-primary knop">
              <img id="icon-meos" src="img/sports-car.svg"><p class="text-button">Vervoersmiddel</p>
          </div></a>
        </div>
		<?php
	  if ($_SESSION['role'] != "anwb") {
	  ?>
        <div class="col-xl-3 col-sm-6 mb-3">
        <a href="aangiftes" class="fill-div"><div class="bg-primary knop">
              <img id="icon-meos" src="img/file.svg"><p class="text-button">Aangifte</p>
          </div></a>
        </div>
		  <?php } ?>
        <div class="col-xl-3 col-sm-6 mb-3">
        <a href="beveiligingscentrum" class="fill-div"><div class="bg-primary knop">
              <img id="icon-meos" src="img/White_lock.svg"><p class="text-button">Beveiligingscentrum</p>
          </div></a>
        </div>
	
      </div>
      <h1>
	  Welkom <?php echo $_SESSION['name']; ?><br>
    In het MEOS systeem van SERVERNAME
  
	  </h1>
	  <b><u>Dit systeem is uitsluitend voor geautoriseerd gebruik. Misbruik van dit systeem kan leiden tot ontslag en/of strafvervolging</u></b><br>
	  <?php
	  if ($_SESSION['role'] != "anwb") {
	  ?>
	  <h1></br> Algemene Notities</h1>
	  <form method="POST">
		<textarea name="anotitie" class="form-control" placeholder="Notitie"></textarea>
    </p>
		<input type="submit" class="btn btn-success" value="Opslaan">
	  </form>
	  <hr>
	  <?php
	  $getNotities = $con->query("SELECT n.id as nid, u.id, u.name, n.text, n.date FROM anotitie AS n INNER JOIN users AS u ON u.id=n.user_id ORDER BY n.id DESC LIMIT 10");
	  while ($row = $getNotities->fetch_assoc()) {
		  ?>
			<b><?php echo htmlspecialchars($row['name']); ?></b> - <em><?php echo $row['date']; ?> <?php if ($_SESSION['id'] == $row['id'] OR $_SESSION['role'] == "admin") { echo "<a href='?action=deleteanotitie&id=".$row['nid']."'>(verwijder)</a>"; } ?></em> <br>
			<?php echo htmlspecialchars($row['text']); ?>
			<hr>
		  <?php
	  }
	  ?>
	  <?php } ?>
	  
	  
	  
	  <?php if ($_SESSION['role'] != "anwb") { ?>
	  Hallo <?php echo $_SESSION['name']; ?>, welkom in MEOS vandaag.
	  <?php if ($specialisaties->num_rows>0) { ?> <br>Momenteel ben je in het bezit van de volgende specialisaties: <?php echo $specialisaties->fetch_assoc()['specialisaties']; } ?>
	  <br>
	  <?php } ?>
	  
	  
	  
	  <hr>
	  <?php
	  if ($_SESSION['role'] != "anwb") {
	  ?>
	  Op het moment zijn er <b> <?php echo $inw->num_rows; ?></b> ingeschreven inwoners in de Gemeente Meerstad<br>
	  <hr>
	  In de gemeente Meerstad zijn <b> <?php echo $voe->num_rows; ?></b> geregistreerde voertuigen <br>
	  <hr>
	  Op het moment beheren alle inwoners intotaal <b> &euro;<?php echo number_format($monconr['tot'],2,",","."); ?> </b> aan contant geld.
    <hr>
	  Op het moment beheren alle inwoners intotaal <b> &euro;<?php echo number_format($monbanr['tot'],2,",","."); ?> </b> op hun bankrekeningen <br>
	  <hr>
	  Momenteel zijn er <b> <?php echo $gev->num_rows; ?> </b>  burgers die veroordeeld zijn,<br>
	  <hr>
	  Op het moment hebben alle burgers intotaal <b> &euro;<?php echo number_format($openbr['tot'],2,",","."); ?> </b>  aan boetes open staan<br>
	  <br>
	  <?php } ?>
	  <hr>
	  <h1>Logboek</h1><br>
	  <div class="list-group">
	  <?php
		if ($_SESSION['role'] != "anwb") {
		  $sel = $con->query("SELECT DISTINCT burgerid,agent,burger FROM livelog ORDER BY id DESC LIMIT 6");
		  while ($row = $sel->fetch_assoc()) {
			  if (trim($row['agent']) != "") {
	  ?>
		<a href="gegevens.php?id=<?php echo $row['burgerid'] ?>" class="list-group-item">
		  <h4 class="list-group-item-heading"><?php echo $row['burger'] ?></h4>
		  <p class="list-group-item-text"><?php echo $row['agent'] ?> heeft <?php echo $row['burger']; ?> opgezocht.</p>
		</a>
	  <?php
	 }
	}
} else {
	echo "Geen toegang tot logboek";
}
	?>
  <hr>
	<h1>Signalementen</h1><br>
	  <div class="list-group">
	  <?php
		if ($_SESSION['role'] != "anwb") {
		  $sel = $con->query("SELECT notitie, gameid FROM informatie WHERE gesignaleerd = true ORDER BY id");
		  while ($row = $sel->fetch_assoc()) {
			  $user = $ddcon->query("SELECT CONCAT(firstname, ' ', lastname) as name FROM users WHERE aid = '".$row['gameid']."'");

	  ?>
		<a href="gegevens.php?id=<?php echo $row['gameid'] ?>" class="list-group-item">
		  <h4 class="list-group-item-heading">Signalering van <?php echo $user->fetch_assoc()['name']; ?></h4>
		  <p class="list-group-item-text"<?php echo $user->fetch_assoc()['name']; ?> >is voor de politie gesignaleerd: <?php echo $row['notitie']; ?></p>
		</a>
	  <?php
	 
	}
} else {
	echo "Geen toegang tot logboek";
}
	?>
	</div>
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © NAME</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
    <script src="js/sb-admin-charts.min.js"></script>
  </div>
  

</body>

</html>
