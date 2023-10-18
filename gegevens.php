<?php
   //error_reporting(0);
   require "config.php";
   if ($_SESSION['loggedin'] != TRUE) {
   	Header("Location: login.php?returnpage=basisadministratie");
   }

   if ($_SESSION['rang'] == "G4S") {
   	Header("Location: index.php");
   }
   if ($_SESSION['role'] == "anwb") {
   	Header("Location: index.php");
   }

   if (@$_GET['action'] == "delete") {
   	$delete = $con->query("DELETE FROM informatie WHERE id='".$con->real_escape_string($_GET['verbaal'])."'");
   	Header("Location: gegevens.php?id=".$_GET['persoon']);
   }

   if (@$_GET['action'] == "delfine") {
   	if ($_GET['id'] == "all") {
   		$ddcon->query("DELETE FROM billing WHERE identifier='".$ddcon->real_escape_string($_GET['steam'])."'");
   	} else {
   		$ddcon->query("DELETE FROM billing WHERE id='".$ddcon->real_escape_string($_GET['id'])."'");
   	}
   	Header("Location: gegevens.php?id=".$_GET['persoon']);
   }

   if (@$_GET['action'] == "beslag") {
   	//exit;
   	$ddcon->query("DELETE FROM owned_vehicles WHERE id='".$ddcon->real_escape_string($_GET['id'])."'");
   	$con->query("INSERT INTO beslaglog (ip,agent,burger,kenteken,voertuig) VALUES ('".$_SERVER['REMOTE_ADDR']."','".$con->real_escape_string($_SESSION['name'])."','".$con->real_escape_string($_GET['user'])."','".$con->real_escape_string($_GET['kenteken'])."','".$con->real_escape_string($_GET['voertuig'])."')");
   	Header("Location: gegevens.php?id=".$_GET['persoon']);

   }

   if (@$_GET['action'] == "invorderen") {
   	//echo $_GET['owner'];
   	//echo "<br>";
   	//exit;
   	$ddcon->query("DELETE FROM user_licenses WHERE owner='".$ddcon->real_escape_string($_GET['owner'])."' AND type='drive_bike'"); //A
   	$ddcon->query("DELETE FROM user_licenses WHERE owner='".$ddcon->real_escape_string($_GET['owner'])."' AND type='drive_truck'"); //C
   	$ddcon->query("DELETE FROM user_licenses WHERE owner='".$ddcon->real_escape_string($_GET['owner'])."' AND type='dmv'"); //Theorie
   	$ddcon->query("DELETE FROM user_licenses WHERE owner='".$ddcon->real_escape_string($_GET['owner'])."' AND type='drive'"); //B
   	$ddcon->query("DELETE FROM user_licenses WHERE owner='".$ddcon->real_escape_string($_GET['owner'])."' AND type='bus'"); //Bus
   	$con->query("INSERT INTO invorderlog (agent,burger,ip) VALUES ('".$_SESSION['username']."(".$_SESSION['name'].")','".$con->real_escape_string($_GET['owner'])."','".$_SERVER['REMOTE_ADDR']."')");
   	Header("Location: gegevens.php?id=".$_GET['persoon']);
   }

   if (@$_GET['action'] == "designal") {
   	$con->query("UPDATE informatie SET gesignaleerd = null WHERE gameid = '".$_GET['gameid']."'");
   	Header("Location: gegevens.php?id=".$_GET['gameid']);
   }

   if ($_SERVER['REQUEST_METHOD'] == "POST") {
   	if ($_POST['form'] == "notitie") {
   		if (isset($_POST['gesignaleerd'])) {
   			$gesignaleerd = true;
   		} else {
   			$gesignaleerd = null;
   		}
   		$insert = $con->query("
   		INSERT INTO
   		informatie
   		(
   		gameid,
   		verbalisant,
   		datum,
   		notitie,
   		sanctie,
   		gesignaleerd
   		) VALUES
   		(
   		'".$con->real_escape_string($_POST['gameid'])."',
   		'".$con->real_escape_string($_POST['verbalisant'])."',
   		'".$con->real_escape_string($_POST['datum'])."',
   		'".$con->real_escape_string($_POST['notitie'])."',
   		'".$con->real_escape_string($_POST['sanctie'])."',
   		'".$con->real_escape_string($gesignaleerd)."'
   		)
   		");

   		if ($insert) {
   			Header("Location:gegevens.php?id=".$_POST['gameid']."&status=ok");
   		} else {
   			Header("Location:gegevens.php?id=".$_POST['gameid']."&status=kut");
   		}
   	}

   	if ($_POST['form'] == "recherche") {
   		$insert = $con->query("
   		INSERT INTO
   		recherche
   		(
   		rechercheur,
   		notitie,
   		datum,
   		burger
   		) VALUES
   		(
   		'".$con->real_escape_string($_POST['verbalisant'])."',
   		'".$con->real_escape_string($_POST['notitie'])."',
   		'".$con->real_escape_string($_POST['datum'])."',
   		'".$con->real_escape_string($_POST['gameid'])."'
   		)
   		");

   		if ($insert) {
   			Header("Location:gegevens.php?id=".$_POST['gameid']."&status=ok2");
   		} else {
   			Header("Location:gegevens.php?id=".$_POST['gameid']."&status=kut2");
   		}
   	}


   	if ($_POST['form'] == "jail") {
   		$insert = $ddcon->query("
   		INSERT INTO
   		jail
   		(
   		identifier,
   		jail_time
   		) VALUES
   		(
   		'".$ddcon->real_escape_string($_POST['steam'])."',
   		'".$ddcon->real_escape_string($_POST['time'])."'
   		)
   		");

   		if ($insert) {
   			Header("Location:gegevens.php?id=".$_POST['persoon']."&status=ok");
   		} else {
   			Header("Location:gegevens.php?id=".$_POST['persoon']."&status=kut");
   		}
   	}

   	if ($_POST['form'] == "kladblok") {
   		//exit(var_dump($_POST));
   		$x = $con->query("SELECT * FROM kladblok WHERE userid = '".$_GET['id']."' LIMIT 1");
   		if ($x->num_rows == 1) {
   			$con->query("UPDATE kladblok SET text = '".$_POST['kladblok']."' WHERE userid='".$_GET['id']."'");
   		} else {
   			$con->query("INSERT INTO kladblok (userid,text) VALUES ('".$_GET['id']."','".$_POST['kladblok']."')");
   		}
   	}

   	if (isset($_GET['kenteken'])) {
   		//$a = $ddcon->query("SELECT * FROM owned_vehicles INNER JOIN users ON users.identifier = owned_vehicles.owner WHERE vehicle LIKE '%".$_GET['kenteken']."%' LIMIT 1");
   		$a = $ddcon->query("SELECT * FROM owned_vehicles INNER JOIN users ON users.identifier = owned_vehicles.owner WHERE plate = '".$_GET['kenteken']."' LIMIT 1");
   		$r = $a->fetch_assoc();

   		$s = $con->query("SELECT id,reason FROM rdwwok WHERE voertuigid = '".$r['id']."'");

   		if ($s->num_rows !== 0) {
   			$status2 = "Afgekeurd";
   		} else {
   			$status2 = "Goedgekeurd";
   		}

   		$wokInformation = $s->fetch_assoc();
   	}

   }

   $mensenq = $ddcon->query("SELECT identifier, firstname, lastname, dateofbirth, sex, height, jobs.label as job, users.identifier as identifier FROM users INNER JOIN job_grades ON (users.job = job_grades.job_name AND users.job_grade = job_grades.grade) INNER JOIN jobs ON users.job = jobs.name WHERE identifier= '".$ddcon->real_escape_string($_GET['id'])."' LIMIT 1");
   $row = $mensenq->fetch_assoc();

   $steamid = $row['identifier'];

   $notities = $con->query("SELECT * FROM informatie WHERE gameid = '".$con->real_escape_string($_GET['id'])."' ORDER BY id DESC");
   $voertuigen = $ddcon->query("SELECT owner, plate,vehicle, type FROM owned_vehicles WHERE owner = '".$row['identifier']."'");

   $identifier = $row['identifier'];
   //var_dump($voertuigen);
   //exit;

   $rijbewijs_theorie = $ddcon->query("SELECT * FROM user_licenses WHERE type='dmv' AND owner='".$row['identifier']."' LIMIT 1");
   $rijbewijs_a = $ddcon->query("SELECT * FROM user_licenses WHERE type='drive_bike' AND owner='".$row['identifier']."' LIMIT 1");
   $rijbewijs_b = $ddcon->query("SELECT * FROM user_licenses WHERE type='drive' AND owner='".$row['identifier']."' LIMIT 1");
   $rijbewijs_c = $ddcon->query("SELECT * FROM user_licenses WHERE type='drive_truck' AND owner='".$row['identifier']."' LIMIT 1");
   $rijbewijs_bus = $ddcon->query("SELECT * FROM user_licenses WHERE type='bus' AND owner='".$row['identifier']."' LIMIT 1");

   $rijbewijzen = "";

   if ($rijbewijs_theorie->num_rows == 1) {
   	$rijbewijzen .= "Theorie\n"; 
   }
   if ($rijbewijs_a->num_rows == 1) {
   	$rijbewijzen .= "A\n";
   }
   if ($rijbewijs_b->num_rows == 1) {
   	$rijbewijzen .= "B\n";
   }
   if ($rijbewijs_c->num_rows == 1) {
   	$rijbewijzen .= "C\n";
   }
   if ($rijbewijs_bus->num_rows == 1) {
   	$rijbewijzen .= "Bus\n";
   }

   $kladblok = $con->query("SELECT text FROM kladblok WHERE userid = '".$_GET['id']."'");
   $rowKladblok = $kladblok->fetch_assoc();

   $checkSig = $con->query("SELECT * FROM informatie WHERE gameid = '".$con->real_escape_string($_GET['id'])."' AND gesignaleerd = true ORDER BY id DESC");
   if ($checkSig->num_rows != 0) {
   	$signalering['status'] = true;
   	$signalering['notitie'] = $checkSig->fetch_assoc()['notitie'];
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
      <title>Gegevens | MEOS <?php echo htmlspecialchars($row['firstname'])." ".htmlspecialchars($row['lastname']); ?></title>
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
   <style>
      .kenteken2 {
      position: relative;
      background: #f3bd00;
      width: 208px;
      height: 42px;
      padding: 2px;
      border-radius: 5px;
      }
      .inset2 {
      border: 1px solid #333;
      border-radius: 4px;
      width: auto;
      height: 38px;
      position: relative;
      display: flex;
      }
      .kenteken2 .inset2 .blue2 {
      width: 24px;
      height: 36px;
      background: #003399;
      border-right: 1px solid #333;
      background-image: url('https://i.ibb.co/r7SZP4h/NLD1-01.png');
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
      }
      .kenteken2 .inset2 input {
      text-transform: uppercase;
      background: 0;
      border: 0;
      outline: 0;
      margin: 0;
      padding: 0;
      text-align: center;
      width: calc(100% - 25px);
      font-size: 23.5px;
      letter-spacing: 3px;
      line-height: 38px;
      font-family: 'Kenteken', sans-serif;
      background-image: url('https://svgshare.com/i/VU4.svg');
      background-repeat: no-repeat;
      background-size: auto;
      }
   </style>
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
                  <a class="nav-link" href="index.php">
                  <i class="fa fa-home"></i>
                  <span class="nav-link-text">Homepagina</span>
                  </a>
               </li>
               <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
                  <a class="nav-link" href="basisadministratie.php">
                  <i class="fa fa-fw fa-area-chart"></i>
                  <span class="nav-link-text">Basisadministratie</span>
                  </a>
               </li>
               <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
                  <a class="nav-link" href="rdw.php">
                  <i class="fa fa-fw fa-area-chart"></i>
                  <span class="nav-link-text">Voertuigregistratie</span>
                  </a>
               </li>
               <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
                  <a class="nav-link" href="training.php">
                  <i class="fa fa-fw fa-book"></i>
                  <span class="nav-link-text">Training</span>
                  </a>
               </li>
               <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
                  <a class="nav-link" href="aangiftes.php">
                  <i class="fa fa-fw fa-area-chart"></i>
                  <span class="nav-link-text">Aangifteadministratie</span>
                  </a>
               </li>
               <!-- Admin Section-->
               <?php if ($_SESSION['role'] == "admin") { ?>
               <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
                  <a class="nav-link" href="gebruikers.php">
                  <i class="fa fa-user-circle"></i>
                  <span class="nav-link-text"> Gebruikersadministratie</span>
                  </a>
               </li>
               <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
                  <a class="nav-link" href="jaillog.php">
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
                  <a href="index.php">Dashboard</a>
               </li>
               <li class="breadcrumb-item"><a href="basisadministratie.php">Basisadministratie</a></li>
               <li class="breadcrumb-item active"><?php echo htmlspecialchars($row['firstname'])." ".htmlspecialchars($row['lastname']); ?></li>
            </ol>
            <form method="POST">
               <?php if ($signalering['status'] == true) { ?>
               <div class="alert alert-danger">
                  <h3><b>Gesignaleerd persoon i.v.m: </b><?php echo $signalering['notitie']; ?> <a href="?action=designal&gameid=<?php echo $_GET['id']; ?>"> >>Signalering Intrekken</a></h3>
               </div>
               <?php } ?>
               <em>Voornaam:</em><br>
               <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['firstname']); ?>" readonly><br>
               <em>Achternaam:</em><br>
               <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['lastname']); ?>" readonly><br>
               <em>Geboortedatum:</em><br>
               <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['dateofbirth']); ?>" readonly><br>
               <em>Geslacht:</em><br>
               <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['sex']); ?>" readonly><br>
               <em>Lengte:</em><br>
               <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['height']); ?>" readonly><br>
               <hr>
               <em>Baan:</em><br>
               <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['job']); ?>" readonly><br>
               <hr>
               <em>Rijvaardigheidsbewijzen:</em><br>
               <textarea rows="4" class="form-control" readonly><?php echo htmlspecialchars($rijbewijzen); ?></textarea>
               <?php if (@$_SESSION['rang'] != "G4S") {?><br><a class="btn btn-danger" href="?action=invorderen&owner=<?php echo $row['identifier']; ?>&persoon=<?php echo $identifier; ?>">Invorderen</a><br><?php } ?><br>
               <?php if (@$_SESSION['role'] == "admin") {
                  ?>
               <!--<a class="btn btn-primary" href="huiszoekingafschrift.php?id=<?php echo $_GET['id']; ?>">Huiszoeking uitvoeren</a><br>
                  <b>Voer deze actie UITSLUITEND uit met toestemming van de Officier van Justitie</b>-->
               <?php
                  }			
                  ?>
               <hr>
            </form>
            <?php if (@$_SESSION['rang'] != "G4S") {?>
            <form method="POST">
               <input type="hidden" name="form" value="notitie">
               <input type="hidden" name="gameid" value="<?php echo $row['identifier']; ?>">
               <div class="col-sm-2"><input required name="verbalisant" class="form-control" type="text" value="<?php echo htmlspecialchars($_SESSION['name']); ?>" readonly></div>
               <div class="col-sm-2"><input required name="datum" class="form-control" type="date"></div>
               <div class="col-sm-2"><input required name="sanctie" class="form-control" type="text" placeholder="Sanctie"></div>
               <div class="form-check">
                  <input style="margin-left: -5px;" type="checkbox" class="form-check-input" name="gesignaleerd" value="" id="exampleCheck1">
                  <label style="padding-left: 15px;" class="form-check-label" for="exampleCheck1">Signaleren</label>
               </div>
               <br>
               <div class="col-sm-12"><textarea required name="notitie" placeholder="Beschrijf incident / notitie" class="form-control"></textarea></div>
               <br>
               <input type="submit" class="btn btn-success btn-block" value="Opslaan">
            </form>
            <?php } ?>
            <hr>

            <?php if (@$_SESSION['rang'] != "G4S") {?>
            <?php } ?>
            <hr>
            <h2>Notities</h2>
            <table id="badm" class="table">
               <tr>
                  <th>Registratienummer</th>
                  <th>Verbalisant</th>
                  <th>Datum</th>
                  <th>Notitie</th>
                  <th>Sanctie</th>
                  <?php if ($_SESSION['role'] == "admin") { ?>
                  <th>Actie</th>
                  <?php } ?>
               </tr>
               <?php
                  if ($notities->num_rows == 0) {
                   echo "<center>Geen feiten bekend</center><br>";
                  } else {
                  while ($row = $notities->fetch_assoc()) {  
                  $meuk = preg_replace( "/\r|\n/", "", $row['notitie'] );
                  ?>
               <tr>
                  <td><?php echo $row['id']; ?></td>
                  <td><?php echo $row['verbalisant']; ?></td>
                  <td><?php echo $row['datum']; ?></td>
                  <td onclick="alert('<?php echo addslashes($meuk); ?>');"><?php echo substr($row['notitie'],0,50); if (strlen($row['notitie']) > 49) { echo "..."; } ?> </td>
                  <td><?php echo $row['sanctie']; ?></td>
                  <?php if ($_SESSION['role'] == "admin") { ?>
                  <td><a href="?action=delete&verbaal=<?php echo $row['id']; ?>&persoon=<?php echo $identifier; ?>">Verwijderen</a></td>
                  <?php } ?>
               </tr>
               <?php 
                  }
                  }
                  ?>
            </table>
            <hr>
            <h2>Voertuigen</h2>
            <table id="badm" class="table">
               <tr>
                  <th>Kenteken vervoersmiddel</th>
                  <th>Modelnaam voertuig</th>
                  <?php if ($_SESSION['role'] == "admin") { ?>
                  <th>Actie</th>
                  <?php } ?>
               </tr>
               <?php
                  //echo "Geen feiten geregistreerd";
                  if ($voertuigen->num_rows == 0) {
                  echo "<center>Geen voertuigen geregistreerd</center><br>";
                  } else {
                  while ($roww = $voertuigen->fetch_assoc()) {  
                  $vehicle = json_decode($roww['vehicle']);
                  $s = $con->query("SELECT id,date FROM rdwwok WHERE voertuigid = '".$roww['id']."'");
                  if ($s->num_rows == 1) {
                  $status = "<div style='color:red;font-weight:bold;'>Afgekeurd</div>";
                  $statusplain = "Afgekeurd";
                  } else {
                  $status = "<div style='color:green;font-weight:bold;'>Goedgekeurd</div>";
                  $statusplain = "Goedgekeurd";
                  }
                  $t = $s->fetch_assoc();
                  ?>
               <tr>
                  <td>
                     <div class="kenteken2">
                        <div class="inset2">
                           <div class="blue2"></div>
                           <input type="text" placeholder="<?php echo $roww['plate']; ?>" value="" readonly/> 
                        </div>
                     </div>
                  </td>
                  <td><?php echo $roww['type']; ?></td>
                  <td><a href="rdw.php?kenteken=<?php echo $roww['plate']; ?>"><button type="button" class="btn btn-primary btn-sm">Voertuig informatie</button></a></td>
                  <!--<?php if ($_SESSION['role'] == "admin") { ?><td><a onclick="if (!confirm('Wil je dit voertuig in beslag nemen? Deze actie kan je niet omdraaien!')) { return false }" href="?action=beslag&id=<?php echo $roww['owner']; ?>&user=<?php echo $steamid ?>&kenteken=<?php echo $vehicle->plate; ?>&voertuig=<?php echo $vehicle->model; ?>&persoon=<?php echo $identifier; ?>">In beslag nemen</a></td><?php } ?>-->		  
               </tr>
               <?php 
                  //unset($vehicle);
                  }
                  }
                  //exit;
                  ?>
            </table>
            <hr>
            <!--<h2>Invoeren bekeuring</h2>-->
            <?php
               $totaalboetes = $ddcon->query("SELECT sum(amount) as a FROM billing WHERE identifier = '".$steamid."' AND target = 'society_police'");
               $totaalboetesrow = $totaalboetes->fetch_assoc();
               ?>
            <h2>Openstaande bekeuringen (&euro;<?php if ($totaalboetesrow['a'] == null) { echo "0"; } else { echo $totaalboetesrow['a']; } ?>)</a></h2>
            <a class="btn btn-primary" href="./boete.php?persoon=<?php echo $identifier; ?>">Verbaal aanzeggen</a> &nbsp; <?php if ($_SESSION['role'] == "admin") { ?><a href="?action=delfine&id=all&persoon=<?php echo $identifier; ?>&steam=<?php echo $steamid; ?>" class="btn btn-danger">Alles verwijderen</a><?php } ?><br>
            <br>
            <table id="badm" class="table">
               <tr>
                  <th>Volgnummer</th>
                  <th>Reden</th>
                  <th>Verbalisant</th>
                  <th>Bedrag</th>
                  <?php if ($_SESSION['role'] == "admin") { ?>
                  <th>Actie</th>
                  <?php } ?>
               </tr>
               <?php
                  $boetesq = $ddcon->query("SELECT id, identifier, sender, target_type, target, label, amount FROM billing WHERE identifier = '".$steamid."' AND target = 'society_police'");

                  while ($row = $boetesq->fetch_assoc()) {
                  if (substr($row['sender'],0,6) == "steam:") {
                   $verbalisantq = $ddcon->query("SELECT CONCAT(LEFT(UCASE(firstname),1),'.',UCASE(lastname)) as verbalisant FROM users WHERE identifier = '".$row['sender']."'");
                   $vrow = $verbalisantq->fetch_assoc();
                   $varbalisant = $vrow['verbalisant'];
                  } else {
                   if ($row['sender'] != NULL) {
                  $verbalisant = $row['sender'];
                   } else {
                    $verbalisant = "Flitspaal";
                   }
                  }
                  ?>
               <tr>
                  <td><?php echo $row['id'] ?></td>
                  <td><?php echo $row['label']; ?></td>
                  <td><?php echo $verbalisant; ?></td>
                  <td>&euro; <?php echo $row['amount']; ?></td>
                  <?php if ($_SESSION['role'] == "admin") { ?>
                  <td><a href="?action=delfine&id=<?php echo $row['id']; ?>&persoon=<?php echo $identifier; ?>">Verwijderen</a></td>
                  <?php } ?>
               </tr>
               <?php 
                  }
                  ?>
            </table>
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
         $('#badm').DataTable( {
           paging: false
         } );
      </script>
   </body>
</html>