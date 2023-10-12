<?php
require "config.php";
if ($_SESSION['loggedin'] != TRUE) {
	Header("Location: login.php?returnpage=jaillog");
}
if ($_SESSION['role'] != "admin") {
	Header("Location:index.php");
}

$jailq = $ddcon->query("SELECT jail.identifier, jail_time, users.name FROM jail INNER JOIN users ON jail.identifier = users.identifier");
$invorderq = $con->query("SELECT burger, agent, datetime FROM invorderlog");
$huiszoekq = $con->query("SELECT burger, agent, datetime FROM huiszoekinglog WHERE burger != ''");
$beslagq = $con->query("SELECT burger, agent, datetime, kenteken, voertuig FROM beslaglog ORDER BY datetime ASC");
$zoeklogq = $con->query("SELECT agent, burger, datetime, burgerid FROM livelog WHERE burger != '' ORDER BY datetime DESC LIMIT 25");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Logboek | MEOS</title>
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
                  <a class="nav-link" href="voertuigregistratie">
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
        <li class="breadcrumb-item active">Gevangenislogboek</li>
      </ol>
		<table id="badm" class="table">
		  <tr>
			<th>Steam id</th>
			<th>Gebruikersnaam</th>
			<th>Resterend</th> 
		  </tr>
		  <?php
		  while ($row = $jailq->fetch_assoc()) {  
		  ?>
		  <tr>
			<td><?php echo $row['identifier']; ?></td>
			<td><?php echo htmlspecialchars($row['name']); ?></td>
			<td><?php echo $row['jail_time']; ?> minuten</td> 
		  </tr>
		  <?php 
		  }
		  ?>
		</table>

	  </div>
	  <hr>
	  <br><br><br>
	  <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Invorderlogboek</li>
      </ol>
		<table id="badm" class="table">
		  <tr>
			<th>Burger</th>
			<th>Agent</th>
			<th>Datum</th> 
		  </tr>
		  <?php
		  while ($row = $invorderq->fetch_assoc()) {  
		  $burgerq = $ddcon->query("SELECT concat(firstname,' ',lastname) as name FROM users WHERE identifier = '".$row['burger']."'");
		  $row2 = $burgerq->fetch_assoc();
		  ?>
		  <tr>
			<td><?php echo htmlspecialchars($row2['name']); ?> (<?php echo htmlspecialchars($row['burger']); ?>)</td>
			<td><?php echo htmlspecialchars($row['agent']); ?></td>
			<td><?php echo $row['datetime']; ?></td> 
		  </tr>
		  <?php 
		  }
		  ?>
		</table>

	  </div>
	  <hr>
	  <br><br><br>
	  <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Huiszoekinglogboek</li>
      </ol>
		<table id="badm" class="table">
		  <tr>
			<th>Burger</th>
			<th>Agent</th>
			<th>Datum</th> 
		  </tr>
		  <?php
		  while ($row = $huiszoekq->fetch_assoc()) {  
		  $burgerq = $ddcon->query("SELECT concat(firstname,' ',lastname) as name FROM users WHERE identifier = '".$row['burger']."'");
		  $row2 = $burgerq->fetch_assoc();
		  ?>
		  <tr>
			<td>
			<?php if ($row['burger'] == "") {
				echo "Onbekend";
			} else {
			?>
			<?php echo htmlspecialchars($row2['name']); ?> (<?php echo htmlspecialchars($row['burger']); ?>)
			<?php } ?>
			</td>
			<td><?php echo htmlspecialchars($row['agent']); ?></td>
			<td><?php echo $row['datetime']; ?></td> 
		  </tr>
		  <?php 
		  }
		  ?>
		</table>
		<br><br><br>
	  </div>
	  <hr>
	  <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Informatielogboek</li>
      </ol>
		<table id="badm" class="table">
		  <tr>
			<th>Burger</th>
			<th>Agent</th>
			<th>Datum</th> 
			<th>Actie</th> 
		  </tr>
		  <?php
		  while ($row = $zoeklogq->fetch_assoc()) {  
		  ?>
		  <tr>
			<td>
			<?php echo htmlspecialchars($row['burger']); ?>
			</td>
			<td><?php echo htmlspecialchars($row['agent']); ?></td>
			<td><?php echo $row['datetime']; ?></td> 
			<td><a href="/gegevens?id=<?php echo $row['burgerid']; ?>">Bezoek burger</a></td> 
		  </tr>
		  <?php 
		  }
		  ?>
		</table>

	  </div>
	  <hr>
	  <br><br><br>
	  <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Beslaglogboek</li>
      </ol>
		<table id="badm" class="table">
		  <tr>
			<th>Burger</th>
			<th>Agent</th>
			<th>Kenteken</th>
			<th>Datum</th> 
		  </tr>
		  <?php
		  while ($row = $beslagq->fetch_assoc()) {  
		  $burgerq = $ddcon->query("SELECT concat(firstname,' ',lastname) as name FROM users WHERE identifier = '".$row['burger']."'");
		  $row2 = $burgerq->fetch_assoc();
		  //$voertuigq = $ddcon->query("SELECT concat(name,' (',model,')') as voertuig FROM vehicles WHERE hash = '".$row['voertuig']."'");
		  //$row3 = $voertuigq->fetch_assoc();
		  ?>
		  <tr>
			<td>
			<?php if ($row['burger'] == "") {
				echo "Onbekend";
			} else {
			?>
			<?php echo htmlspecialchars($row2['name']); ?> (<?php echo htmlspecialchars($row['burger']); ?>)
			<?php } ?>
			</td>
			<td><?php echo htmlspecialchars($row['agent']); ?></td>
			<td><?php echo htmlspecialchars($row['kenteken']); ?></td>
			<td><?php echo $row['datetime']; ?></td> 
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
          <small>Copyright © Meerstad</small>
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
