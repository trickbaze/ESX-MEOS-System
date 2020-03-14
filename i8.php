<?php
require "config.php";
if ($_SESSION['loggedin'] != TRUE) {
	Header("Location: login.php?returnpage=i8");
}

if ($_SESSION['rang'] == "G4S") {
	Header("Location: index");
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$insert = $con->query("INSERT INTO i8 
	(
	userid,
	datum_1,
	datum_2,
	plaats,
	omstandigheden,
	geweld_persoon,
	geweld_goed,
	letsel_betrokkene,
	letsel_betrokkene_onbekend,
	letsel_betrokkene_gering,
	letsel_betrokkene_ander,
	ander_letsel,
	andere_schade,
	hovj_naam,
	hovj_rang,
	toegepast_traangas,
	toegepast_diensthond,
	toegepast_dienstvoertuig,
	toegepast_fysiek,
	toegepast_handboeien,
	toegepast_stroomstootwapen,
	toegepast_vuurwapen,
	toegepast_wapenstok
	) VALUES (
	'".$_SESSION['id']."',
	'".$con->real_escape_string($_POST['datum_1'])."',
	'".$con->real_escape_string($_POST['datum_2'])."',
	'".$con->real_escape_string($_POST['plaats'])."',
	'".$con->real_escape_string($_POST['omstandigheden'])."',
	'".$con->real_escape_string($_POST['geweld_persoon'])."',
	'".$con->real_escape_string($_POST['geweld_goed'])."',
	'".$con->real_escape_string($_POST['letsel_betrokkene'])."',
	'".$con->real_escape_string($_POST['letsel_betrokkene_onbekend'])."',
	'".$con->real_escape_string($_POST['letsel_betrokkene_gering'])."',
	'".$con->real_escape_string($_POST['letsel_betrokkene_ander'])."',
	'".$con->real_escape_string($_POST['ander_letsel'])."',
	'".$con->real_escape_string($_POST['andere_schade'])."',
	'".$con->real_escape_string($_POST['hovj_naam'])."',
	'".$con->real_escape_string($_POST['hovj_rang'])."',
	'".$con->real_escape_string($_POST['toegepast_traangas'])."',
	'".$con->real_escape_string($_POST['toegepast_diensthond'])."',
	'".$con->real_escape_string($_POST['toegepast_dienstvoertuig'])."',
	'".$con->real_escape_string($_POST['toegepast_fysiek'])."',
	'".$con->real_escape_string($_POST['toegepast_handboeien'])."',
	'".$con->real_escape_string($_POST['toegepast_stroomstootwapen'])."',
	'".$con->real_escape_string($_POST['toegepast_vuurwapen'])."',
	'".$con->real_escape_string($_POST['toegepast_wapenstok'])."'
	)");
	if ($insert) {
		Header("Location: ?status=done");
	} else {
		exit($con->error);
	}
}
if ($_GET['action'] == "goedkeuren") {
	$con->query("UPDATE i8 SET status = 1, beoordeeld_door_id = '".$_SESSION['id']."' WHERE id = '".$_GET['id']."'");
	Header("Location: i8");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Zoutelande - i8 formulier</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="/">Zoutelande - MEOS</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="index">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="/gms">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Portofoon</span>
          </a>
        </li>
		<?php if ($_SESSION['role'] != "anwb") { ?>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="i8">
            <i class="fa fa-fw fa-file"></i>
            <span class="nav-link-text"><u>i8 formulier</u></span>
          </a>
        </li>
		<?php } ?>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="basisadministratie">
            <i class="fa fa-fw fa-area-chart"></i>
            <span class="nav-link-text">Basisadministratie</span>
          </a>
        </li>
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
		<?php if ($_SESSION['role'] == "admin") { ?>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="gebruikers">
            <i class="fa fa-fw fa-user"></i>
            <span class="nav-link-text">Gebruikersadministratie</span>
          </a>
        </li>
		
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="jaillog">
            <i class="fa fa-fw fa-cogs"></i>
            <span class="nav-link-text">Logboeken</span>
          </a>
        </li>
		<?php } ?>
		
      </ul>

      
    </div>
  </nav>
  <div class="content-wrapper">
    <div class="container-fluid">
	<?php if ($_SESSION['role'] == "admin") { ?>
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.html">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">i8 meldingen</li>
      </ol>
	  <table class="table">
	  <tr>
		<th>Ambtenaar</th>
		<th>Datum</th>
		<th>Status</th>
		<th>Getoetst door</th>
		<th>Actie</th>
	  </tr>
	  <?php
	  $get = $con->query("SELECT i8.*, u.name FROM i8 INNER JOIN users AS u ON u.id = i8.userid ORDER BY i8.status LIMIT 20");
	  while($row = $get->fetch_assoc()) {
	  $door = $con->query("SELECT name FROM users WHERE id = '".$row['beoordeeld_door_id']."'");
	  $door = $door->fetch_assoc();
	  ?>
	  <tr>
		<td><?php echo $row['name']; ?></td>
		<td><?php echo $row['datum_1']; ?></td>
		<td><?php if ($row['status'] == 0) { echo "Openstaand"; } else { echo "Beoordeeld"; } ?></td>
		<td><?php echo $door['name']; ?></td>
		<td><a target="_blank" href="geti8.php?id=<?php echo $row['id']; ?>">Bekijken</a><?php if ($row['beoordeeld_door_id'] == NULL) { ?> | <a href="?action=goedkeuren&id=<?php echo $row['id']; ?>">Goedkeuren</a><?php } ?></td>
	  </tr>
	  <?php } ?>
</table>
	  
	<?php } ?>
	<ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.html">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">i8 formulier</li>
      </ol>
      <div class="row">
        <div class="col-12">
		<?php if ($_GET['status'] == "done") { ?>
		<div class="alert alert-success" role="alert">
			<b>Het formulier is succesvol verstuurd</b>
		</div>
		<?php } ?>
		<?php if ($_GET['status'] == "error") { ?>
		<div class="alert alert-danger" role="alert">
			<b>Het formulier is niet verstuurd, neem contact op met je leidinggevende</b>
		</div>
		<?php } ?>
		<form method="POST">
          <h1>Meldingsformulier geweldsaanwending (i8)</h1>
          <p>Heb je geweld toegepast in het uitoefenen van je werkzaamheden? Dan moet je dat onverwijld melden aan je leidinggevende. Dat geschiedt middels het i8 formulier. Hier vul je het toegepaste geweld in. Jouw leidinggevende kan dit vervolgens toetsen, mocht dit nodig zijn.</p>
		  <hr>
		  <form method="POST">
			<b><em>Datum van melding:</em></b><br>
			<input type="text" name="datum_1" value="<?php echo date('d-m-Y');?> " class="form-control" readonly><br>
			<hr>
			<h2>Gegevens voorval</h2>
			<b><em>Datum van de geweldsaanwending:</em></b><br>
			<input type="text" name="datum_2" placeholder="dd-mm-jjjj uu:mm" class="form-control" required><br>
			<b><em>Plaats en omstandigheden:</em></b><br>
			<input type="text" name="plaats" placeholder="Duidelijke omschrijving van de locatie waar het voorval plaatsvond en of het bijvoorbeeld regende of mistig was" class="form-control" required><br>
			<b><em>Omstandigheden:</em></b><br>
			<input type="text" name="omstandigheden" placeholder="Duidelijke omschrijving van wat er gebeurde" class="form-control" required><br>
			<b><em>Geweld tegen persoon:</em></b><br>
			<select class="form-control" name="geweld_persoon" required>
				<option value="1">Ja</option>
				<option value="0">Nee</option>
			</select><br>
			<b><em>Geweld tegen goed:</em></b><br>
			<select class="form-control" name="geweld_goed" required>
				<option value="1">Ja</option>
				<option value="0">Nee</option>
			</select><br>
			<h2>Gevolgen van de geweldsaanwending</h2>
			<b><em>Letsel bij betrokkenen / derde:</em></b><br>
			<select onchange="letsel()" class="form-control" id="letsel_betrokkene" name="letsel_betrokkene" required>
				<option disabled selected>Maak een keuze...</option>
				<option value="1">Ja</option>
				<option value="0">Nee</option>
			</select><br>
			<b><em>Onbekend letsel:</em></b><br>
			<select class="form-control" name="letsel_betrokkene_onbekend" id="letsel_betrokkene_onbekend" disabled>
				<option value="1">Ja</option>
				<option selected value="0">Nee</option>
			</select><br>
			<b><em>Gering letsel:</em></b><br>
			<select class="form-control" name="letsel_betrokkene_gering" id="letsel_betrokkene_gering" disabled>
				<option value="1">Ja</option>
				<option selected value="0">Nee</option>
			</select><br>
			<b><em>Ander letsel:</em></b><br>
			<select onchange="ander()" class="form-control" name="letsel_betrokkene_ander" id="letsel_betrokkene_ander" disabled>
				<option disabled selected>Maak een keuze...</option>
				<option value="1">Ja</option>
				<option value="0">Nee</option>
			</select><br>
			<b><em>Omschrijf letsel:</em></b><br>
			<textarea name="ander_letsel" id="ander_letsel" class="form-control" disabled></textarea><br>
			<b><em>Materiale schade:</em></b><br>
			<select class="form-control" name="andere_schade" id="andere_schade" required>
				<option value="1">Ja</option>
				<option selected value="0">Nee</option>
			</select><br>
			<hr>
			<h2>Personalia HOVJ</h2>
			<b><em>Naam:</em></b><br>
			<input type="text" name="hovj_naam" placeholder="Ben Fappen" class="form-control" required><br>
			<b><em>Rang:</em></b><br>
			<input type="text" name="hovj_rang" placeholder="Inspecteur" class="form-control" required><br>
			<hr>
			<h2>Toegepaste geweldsmiddelen</h2>
			<b><em>Traangas:</em></b><br>
			<select class="form-control" name="toegepast_traangas" required>
				<option value="1">Ja</option>
				<option selected value="0">Nee</option>
			</select><br>
			<b><em>Diensthond:</em></b><br>
			<select class="form-control" name="toegepast_diensthond" required>
				<option value="1">Ja</option>
				<option selected value="0">Nee</option>
			</select><br>
			<b><em>Dienstvoertuig:</em></b><br>
			<select class="form-control" name="toegepast_dienstvoertuig" required>
				<option value="1">Ja</option>
				<option selected value="0">Nee</option>
			</select><br>
			<b><em>Fysiek geweld:</em></b><br>
			<select class="form-control" name="toegepast_fysiek" required>
				<option value="1">Ja</option>
				<option selected value="0">Nee</option>
			</select><br>
			<b><em>Handboeien:</em></b><br>
			<select class="form-control" name="toegepast_handboeien" required>
				<option value="1">Ja</option>
				<option selected value="0">Nee</option>
			</select><br>
			<b><em>Stroomstootwapen:</em></b><br>
			<select class="form-control" name="toegepast_stroomstootwapen" required>
				<option value="1">Ja</option>
				<option selected value="0">Nee</option>
			</select><br>
			<b><em>Vuurwapen:</em></b><br>
			<select class="form-control" name="toegepast_vuurwapen" required>
				<option value="1">Ja</option>
				<option selected value="0">Nee</option>
			</select><br>
			<b><em>Wapenstok:</em></b><br>
			<select class="form-control" name="toegepast_wapenstok" required>
				<option value="1">Ja</option>
				<option selected value="0">Nee</option>
			</select><br>
			<input type="submit" value="Versturen" class="btn btn-success">
			</form>
        </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Your Website 2018</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.html">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
	<script>
	function letsel() {
		if (document.getElementById('letsel_betrokkene').value == 1) {
			enableLetsel();
		} else {
			disableLetsel();
		}
	}
	
	function ander() {
		if (document.getElementById('letsel_betrokkene_ander').value == 1) {
			document.getElementById('ander_letsel').removeAttribute('disabled');
			document.getElementById('ander_letsel').setAttribute('required','true');
		} else {
			document.getElementById('ander_letsel').removeAttribute('required');
			document.getElementById('ander_letsel').setAttribute('disabled','true');
		}
	}
	
	function enableLetsel() {
		document.getElementById('letsel_betrokkene_onbekend').removeAttribute('disabled');
		document.getElementById('letsel_betrokkene_onbekend').setAttribute('required','true');
		
		document.getElementById('letsel_betrokkene_gering').removeAttribute('disabled');
		document.getElementById('letsel_betrokkene_gering').setAttribute('required','true');
		
		document.getElementById('letsel_betrokkene_ander').removeAttribute('disabled');
		document.getElementById('letsel_betrokkene_ander').setAttribute('required','true');
	}
	
	function disableLetsel() {
		document.getElementById('letsel_betrokkene_onbekend').removeAttribute('required');
		document.getElementById('letsel_betrokkene_onbekend').setAttribute('disabled','true');
		document.getElementById('letsel_betrokkene_onbekend').value = 0;
		
		document.getElementById('letsel_betrokkene_gering').removeAttribute('required');
		document.getElementById('letsel_betrokkene_gering').setAttribute('disabled','true');
		document.getElementById('letsel_betrokkene_gering').value = 0;
		
		document.getElementById('letsel_betrokkene_ander').removeAttribute('required');
		document.getElementById('letsel_betrokkene_ander').setAttribute('disabled','true');
		document.getElementById('letsel_betrokkene_ander').value = 0;
	}
	</script>
  </div>
</body>

</html>
