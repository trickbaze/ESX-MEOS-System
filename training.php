<?php
require "config.php";
if ($_SESSION['loggedin'] != TRUE) {
	Header("Location: login.php?returnpage=training");
}
if ($_SESSION['role'] == "anwb") {
	Header("Location: index");
}
$getTrainerStatus = $con->query("SELECT * FROM users WHERE id = '".$_SESSION['id']."' AND trainer = 1");
if ($getTrainerStatus->num_rows == 1) {
	$_SESSION['trainer'] = true; 
}

if (@$_SESSION['trainer'] != true)  {
	//Header("Location:index");
	//exit;
}

$getOwnRang = $con->query("SELECT rang FROM users WHERE id = '".$_SESSION['id']."' LIMIT 1");
$row = $getOwnRang->fetch_assoc();
$_SESSION['rang'] = $row['rang'];

$getAllFinishedTrainingsByShort = $con->query("SELECT specialisaties FROM users WHERE id = '".$_SESSION['id']."' LIMIT 1");
$rr = $getAllFinishedTrainingsByShort->fetch_assoc();
$allFinishedTrainingsByShort = explode(", ",$rr['specialisaties']);

$getAllTraining = $con->query("SELECT * FROM specialisaties ORDER BY id ASC");
$getAllTraining2 = $con->query("SELECT * FROM specialisaties ORDER BY id ASC");
//$getAllTraining2 = $con->query("SELECT * FROM specialisaties as s WHERE s.id not in (select table1_id from table2)");
//$getAllTraining2 = $con->query("SELECT s.id FROM specialisaties as s  LEFT JOIN specialisatie_aanmeldingen as a ON s.id = a.specialisatie WHERE a.user = '".$_SESSION['id']."'");

$getAllTrainingRegistered = $con->query("SELECT * FROM specialisatie_aanmeldingen WHERE user = '".$_SESSION['id']."'");
if ($getAllTrainingRegistered->num_rows == 0) {
	$registredAtTrainings = null;
}
while ($row = $getAllTrainingRegistered->fetch_assoc()) {
	$registredAtTrainings[] = $row['specialisatie'];
}

if (isset($_GET['registeer'])) {
	$con->query("INSERT INTO specialisatie_aanmeldingen (specialisatie,user) VALUES ('".$_GET['registeer']."','".$_SESSION['id']."')");
	
	$specialisatieNaamQ = $con->query("SELECT name FROM specialisaties WHERE id = '".$_GET['registeer']."'");
	$snrow = $specialisatieNaamQ->fetch_assoc();
	
	$message = "Zojuist heeft ".$_SESSION['name']." zich aangemeld voor ".$snrow['name']."\n\n";
	
	$data = array("username" => "Trainingen en specialisaties", "content" => $message);
	$data_string = json_encode($data);

	$ch = curl_init('https://discord.com/api/webhooks/1163125177824071690/mr3IMls8_ot5b5NTJ8TfNFnJTZFI98cXBV9-Oq2wnL4L4zzeOcynj45yy1f9ai1IqJ_e');
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($data_string))
	);
	
		$result = curl_exec($ch);

	
	Header("Location: training");
}

if (isset($_GET['action'])) {
	
	if ($_GET['action'] == "verwijderaanmelding") {
		$nameq = $con->query("SELECT u.name as name, u.username as username FROM specialisatie_aanmeldingen as a INNER JOIN users as u ON a.user = u.id WHERE a.id = '".$_GET['kandidaatid']."'");
		$name = $nameq->fetch_assoc();
		
		$specq = $con->query("SELECT s.name as name, s.short as short FROM specialisatie_aanmeldingen as sa INNER JOIN specialisaties as s ON sa.specialisatie = s.id WHERE sa.id= '".$_GET['kandidaatid']."'");
		$spec = $specq->fetch_assoc();
		
		$username = $name['username']." (".$name['name'].")";
		$specialisatie = $spec['name'];
		
		$message = "Datum: ".date("d-m-Y")."\n";
		$message .= "Kandidaat: ". $username . "\n";
		$message .= "Instructeur: ". $_SESSION['name'] . "\n";
		$message .= "Beoordeling:  Onvoldoende\n";
		$message .= "Opleidingsonderdeel:  ".$spec['name']." (".$spec['short'].")\n";
		
		$data = array("username" => "Trainingen en specialisaties", "content" => $message);
		$data_string = json_encode($data);

		$ch = curl_init('https://discord.com/api/webhooks/1163125239434182857/ex59YZfD7qNVABPfmwKPaPKPDvIO8JersQU0lL0PToiNmNO0rmHeQuucxxBkFg3Kpq1G');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data_string))
		);
		
		$result = curl_exec($ch);
		
		$con->query("DELETE FROM specialisatie_aanmeldingen WHERE id = '".$_GET['kandidaatid']."'");
		Header("Location: training");
	}
	
	if ($_GET['action'] == "specialisatieafgerond") {
		$a = $con->query("SELECT s.name as spec, s.short as short, s.beloningspromotie as beloningspromotie, a.user as user FROM specialisaties as s INNER JOIN specialisatie_aanmeldingen as a ON s.id=a.specialisatie WHERE a.id = '".$_GET['kandidaatid']."' LIMIT 1");
		$row = $a->fetch_assoc(); //Short,beloningspromotie,user
		$b = $con->query("SELECT specialisaties FROM users WHERE id = '".$row['user']."'");
		$r2 = $b->fetch_assoc(); //Huidige specialisaties
		
		//echo "<pre>";
		//var_dump($row);
		//exit;
		
		if ($r2['specialisaties'] == NULL) {
			$r2['specialisaties'] = $row['short'];
		} else {
			$r2['specialisaties'] = $r2['specialisaties'].", ".$row['short'];
		}
		
		$con->query("UPDATE users SET specialisaties = '".$r2['specialisaties']."' WHERE id='".$row['user']."'");
		//echo $row['beloningspromotie'];
		if (strlen($row['beloningspromotie']) > 1) {
			//echo "RANK";
			$con->query("UPDATE users SET rang = '".$row['beloningspromotie']."' WHERE id='".$row['user']."'");
		}
		//exit;
		//I want to have the username
		$userQuery = $con->query("SELECT username, name FROM users WHERE id='".$row['user']."'");
		$rowUser = $userQuery->fetch_assoc();
		
		$username = $rowUser['username']." (".$rowUser['name'].")";
		$specialisatie = $row['spec'];
		
		$message = "Datum: ".date("d-m-Y")."\n";
		$message .= "Kandidaat: ". $username . "\n";
		$message .= "Instructeur: ". $_SESSION['name'] . "\n";
		$message .= "Beoordeling:  Voldoende\n";
		$message .= "Opleidingsonderdeel:  ".$row['spec']." (".$row['short'].")\n";
		
		$data = array("username" => "Trainingen en specialisaties", "content" => $message);
		$data_string = json_encode($data);

		$ch = curl_init('https://discord.com/api/webhooks/1163125239434182857/ex59YZfD7qNVABPfmwKPaPKPDvIO8JersQU0lL0PToiNmNO0rmHeQuucxxBkFg3Kpq1G');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data_string))
		);
		
		if ($rowUser != "") {
			$result = curl_exec($ch);
		}
		
		$con->query("DELETE FROM specialisatie_aanmeldingen WHERE id = '".$_GET['kandidaatid']."'");
	}
	
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if ($_POST['form'] == "create") {
		$rang = implode(",",$_POST['rang']);
		$beloning_rang = implode(",",$_POST['beloning_rang']);
		
		$con->query("INSERT INTO specialisaties 
		(
		id,
		name,
		short,
		docent,
		toelatingsrangen,
		beloningspromotie,
		created_by,
		ip
		) VALUES 
		(
		'',
		'".$con->real_escape_string($_POST['name'])."',
		'".$con->real_escape_string($_POST['afkorting'])."',
		'".$con->real_escape_string($_POST['teacher'])."',
		'".$con->real_escape_string($rang)."',
		'".$con->real_escape_string($beloning_rang)."',
		'".$con->real_escape_string($_SESSION['id'])."',
		'".$con->real_escape_string($_SERVER['REMOTE_ADDR'])."'
		)");
		Header("Location:training");
	}
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if ($_POST['form'] == "add") {

		$con->query("INSERT INTO specialisatie_aanmeldingen 
		(
		id,
		specialisatie,
		user
		) VALUES 
		(
		'',
		'".$con->real_escape_string($_POST['user'])."',
		'".$con->real_escape_string($_POST['specialisatie'])."'
		)");
		Header("Location:training");
	}
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
  <title>Specialisatietraining | MEOS</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  
  <!-- datatables -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
<link rel="icon" type="image/png" href="favicon.ico" />
<meta name="theme-color" content="<?php echo $browser_color; ?>">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-red fixed-top" id="mainNav">
         <a class="navbar-brand" href="#"><img id="logo-meos" src="img/logo.png"></a>
         <p id="header-text">MEOS</p>
         <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">

              <!-- Default user section-->
               <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                  <a class="nav-link" href="index">
                  <i class="fa fa-home"></i>
                  <span class="nav-link-text">Homepagina</span>
                  </a>
               </li>
               <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
                  <a class="nav-link" href="basisadministratie">
                  <i class="fa fa-fw fa-area-chart"></i>
                  <span class="nav-link-text">Basisadministratie</span>
                  </a>
               </li>
               <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
                  <a class="nav-link" href="rdw">
                  <i class="fa fa-fw fa-area-chart"></i>
                  <span class="nav-link-text">Voertuigregistratie</span>
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

               <!-- Admin Section-->
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

              <!-- Default user section-->
               <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
                  <a class="nav-link" href="exit.php">
                  <i class="fa fa-sign-out"></i>
                  <span class="nav-link-text">Uitloggen</span>
                  </a>
               </li>
            </ul>
         </div>
      </nav>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Training</li>
      </ol>
		<?php if (@$_SESSION['trainer'] == true) { ?>
		<h1>Kandidaten en aanmeldingen:</h1>
		<form id="getSpecialisatieForm" method="get">
			<em><b>Selecteer training</b></em>
			<select id="specialisatieSelector" onchange="document.location.href='?getSpecialisatieFormgetSpecialisatie='+document.getElementById('specialisatieSelector').value;" class="form-control" name="getSpecialisatie">
				<option disabled <?php if (!isset($_GET['getSpecialisatieFormgetSpecialisatie'])) { ?> selected <?php  } ?>>Maak een keuze...</option>
				<?php 
				while ($row = $getAllTraining2->fetch_assoc()) {
					?>
						<option <?php if (@$_GET['getSpecialisatieFormgetSpecialisatie'] == $row['id']) { echo "selected"; } ?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?> (<?php echo $row['short']; ?>) - <?php echo str_replace("<br>"," - ",$row['docent']); ?>
					<?php
				}
				?>
			</select>
		<?php } ?>
		</form>
		<?php if (@$_SESSION['trainer'] == true AND isset($_GET['getSpecialisatieFormgetSpecialisatie'])) { ?>
		<?php 
		$q = $con->query("SELECT specialisatie_aanmeldingen.id as id,users.name as name, users.username as username FROM specialisatie_aanmeldingen INNER JOIN users ON users.id=specialisatie_aanmeldingen.user WHERE specialisatie = '".$con->real_escape_string($_GET['getSpecialisatieFormgetSpecialisatie'])."'");
		if ($q->num_rows == 0) {
			echo "Geen kandidaten gevonden";
		} else {
		?><br>
			<table class="table">
			  <tr>
				<th>Nummer</th>
				<th>Kandidaatnaam</th> 
				<th>&nbsp;</th>
			  </tr>
			  <?php
			  while ($row = $q->fetch_assoc()) { ?>
			  <tr>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['name']; ?> (<?php echo $row['username']; ?>)</td> 
				<td>
				<a class="btn btn-success" href="?action=specialisatieafgerond&kandidaatid=<?php echo $row['id']; ?>">Afgerond</a>
				
				<a class="btn btn-danger" href="?action=verwijderaanmelding&kandidaatid=<?php echo $row['id']; ?>">Verwijderen</a>
				</td>
			  </tr>
			  <?php } ?>
			</table>
		<?php
		} 
	 } echo "<hr>"; ?>
	  <h1>Inschrijven training</h1>
	  <table class="table">
		  <tr>
			<th>Nummer</th>
			<th>Specialisatie</th> 
			<th>Toelatingsrangen</th> 
			<th>&nbsp;</th>
		  </tr>
		  <?php
		  while ($row = $getAllTraining2->fetch_assoc()) { ?>
		  <?php 
		  $explode = explode(",",$row['toelatingsrangen']);
		  if (!in_array($_SESSION['rang'],$explode) OR @in_array($row['id'],$registredAtTrainings) OR @in_array($row['short'],$allFinishedTrainingsByShort)) {
			$toelaatbaar = false;
		  } else {
			$toelaatbaar = true;
		  }
		  ?>
		  <tr>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['name']; ?></td> 
			<td><?php echo str_replace(",",", ",$row['toelatingsrangen']); ?></td> 
			<td>
			<a <?php if ($toelaatbaar == true) { ?> class="btn btn-success" href="?registeer=<?php echo $row['id']; ?>" <?php } else { ?> class="btn btn-danger" href="" <?php } ?> ><?php if ($toelaatbaar == false) { echo "Niet (meer) beschikbaar"; } else { echo "Inschrijven"; }?></a>
			</td>
		  </tr>
		  <?php } ?>
		</table>
		<?php if (@$_SESSION['trainer'] == true) { ?>
		<button onclick="$('#addModal').modal();" class="btn btn-primary">Kandidaat toevoegen</button>
		<?php } ?>
		<?php if (@$_SESSION['trainer'] == true) { ?>
		<button onclick="$('#createModal').modal();" class="btn btn-success">Creëer specialisatie</button>
		<?php } ?>
	  </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
	<footer class="sticky-footer">
            <div class="container">
               <div class="text-center">
                  <small><?php echo $site_footer; ?></small>
               </div>
            </div>
         </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- BEGIN Create Modal-->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Creëer specialisatie</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
			<form method="POST">
				<input type="hidden" name="form" value="create">
				<em><b>Specialisatienaam:</b></em>
				<input class="form-control" type="text" name="name" required>
				<em><b>Specialisatieafkorting:</b></em>
				<input class="form-control" pattern="[A-Za-z0-9\-\_]+" type="text" name="afkorting" required>
				<em><b>Docent:</b></em>
				<input class="form-control" type="text" name="teacher" value="<?php echo $_SESSION['name']; ?>" required>
				<em><b>Toelatingsrangen:</b></em>
				<select multiple style="height: 100%;" size="10" name="rang[]" class="form-control" required>
					<option value="Aspirant">Aspirant</option>
					<option value="Surveillant">Surveillant</option>
					<option value="Agent">Agent</option>
					<option value="Hoofd Agent">Hoofd Agent</option>
					<option value="Brigadier">Brigadier</option>
					<option value="Inspecteur">Inspecteur</option>
					<option value="Hoofd Inspecteur">Hoofd Inspecteur</option>
					<option value="Commissaris">Commissaris</option>
					<option value="Hoofd Commissaris">Hoofd Commissaris</option>
					<option value="1e Hoofd Commissaris">1e Hoofd Commissaris</option>
				</select>
				<em><b>Beloningspromotie:</b></em>
				<select style="height: 100%;" size="11" name="beloning_rang[]" class="form-control" required>
					<option selected value="0">Geen</option>
					<option value="Aspirant">Aspirant</option>
					<option value="Surveillant">Surveillant</option>
					<option value="Agent">Agent</option>
					<option value="Hoofd Agent">Hoofd Agent</option>
					<option value="Brigadier">Brigadier</option>
					<option value="Inspecteur">Inspecteur</option>
					<option value="Hoofd Inspecteur">Hoofd Inspecteur</option>
					<option value="Commissaris">Commissaris</option>
					<option value="Hoofd Commissaris">Hoofd Commissaris</option>
					<option value="1e Hoofd Commissaris">1e Hoofd Commissaris</option>
				</select>
				<input type="submit" class="btn btn-primary" value="Bewaren">
			</form>
		  </div>
        </div>
      </div>
    </div>
	<!-- END Create Modal-->

	<!-- BEGIN Add Modal-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Gebruiker toevoegen</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
			<form method="POST">
				<input type="hidden" name="form" value="add">
				<em><b>ID:</b></em><br>
				<small>ID kan je vinden in de Gebruikersadministratie</small>
				<input class="form-control" type="text" name="specialisatie" required>
				<em><b>Specialisatie:</b></em><br>
				<small>De value altijd 0</small>
				<input class="form-control" type="text" placeholder="0" name="user" required>
				<br>
				<input type="submit" class="btn btn-primary" value="Bewaren">
			</form>
		  </div>
        </div>
      </div>
    </div>
	<!-- END Create Modal-->
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
  <script>
</script>
</body>

</html>
