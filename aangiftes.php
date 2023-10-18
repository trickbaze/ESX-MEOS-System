<?php
require "config.php";
if ($_SESSION['loggedin'] != TRUE) {
	Header("Location: login.php?returnpage=aangiftes");
}
if ($_SESSION['role'] == "anwb") {
	Header("Location: index.php");
}
if (isset($_GET['action'])) {
	if (@$_GET['action'] == "open") {
		$update = $con->query("UPDATE aangifte SET status='open' WHERE id='".$con->real_escape_string($_GET['id'])."'");
		Header("Location: aangiftes.php");
	}
	if (@$_GET['action'] == "hold") {
		$update = $con->query("UPDATE aangifte SET status='hold' WHERE id='".$con->real_escape_string($_GET['id'])."'");
		Header("Location: aangiftes.php");
	}
	if (@$_GET['action'] == "close") {
		$update = $con->query("UPDATE aangifte SET status='closed' WHERE id='".$con->real_escape_string($_GET['id'])."'");
		Header("Location: aangiftes.php");
	}
	if (@$_GET['action'] == "delete") {
		$update = $con->query("DELETE FROM aangifte WHERE id='".$con->real_escape_string($_GET['id'])."'");
		Header("Location: aangiftes.php");
	}
	if (@_GET['action' == "behandelen"]) {
		$update = $con->query("UPDATE aangifte SET behandelaar='".$con->real_escape_string($_SESSION['name'])."' WHERE id='".$con->real_escape_string($_GET['id'])."'");
		Header("Location: aangiftes.php");
	}
}


$mensenq = $con->query("SELECT id, opnamedatum, concat(aangever_voornaam, ' ' ,aangever_achternaam) as name, status, behandelaar FROM aangifte ORDER BY status ASC, opnamedatum ASC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Aangifteadministratie | MEOS</title>
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
                  <a class="nav-link" href="users.php">
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
        <li class="breadcrumb-item active">Aangifteadministratie</li>
      </ol>
		<hr>
		<a href="aangifte.php" class="btn btn-success btn-block">Aangifte invoeren</a>
		<table id="badm" class="table">
		  <tr>
			<th>Volgnummer</th>
			<th>Opnamedatum</th> 
			<th>Aangever</th>
			<th>Status</th>
			<th>Behandelaar</th>
			<th>Actie</th>
		  </tr>
		  <?php
		  while ($row = $mensenq->fetch_assoc()) {  
		  ?>
		  <tr>
			<td><a href="aangifte.php?id=<?php echo $row['id']; ?>">Lezen (<?php echo $row['id']; ?>)</a></td>
			<td><?php echo htmlspecialchars($row['opnamedatum']); ?></td> 
			<td><?php echo htmlspecialchars($row['name']); ?></td>
			<td><?php if ($row['status'] == "open") { echo '<span class="label label-success">Geopend</span>'; } if ($row['status'] == "closed") { echo '<span class="label label-danger">Gesloten</span>'; } if ($row['status'] == "hold") { echo '<span class="label label-warning">In de wacht</span>'; } ?></td>
			<td><?php echo htmlspecialchars($row['behandelaar']); ?></td>
			<td>
			<?php if ($row['status'] == "open") { ?> <a href="?action=close&id=<?php echo $row['id']; ?>">Sluiten</a><br><a href="?action=hold&id=<?php echo $row['id']; ?>">In de wacht</a> <?php } ?>
			<?php if ($row['status'] == "closed") { ?> <a href="?action=hold&id=<?php echo $row['id']; ?>">In de wacht</a><br><a href="?action=open&id=<?php echo $row['id']; ?>">Openen</a> <?php } ?>
			<?php if ($row['status'] == "hold") { ?> <a href="?action=open&id=<?php echo $row['id']; ?>">Openen</a><br><a href="?action=close&id=<?php echo $row['id']; ?>">Sluiten</a> <?php } ?>
			<?php if ($_SESSION['role'] == "admin") { ?> <br><a href="?action=delete&id=<?php echo $row['id']; ?>">Verwijderen</a> <?php } ?>
			<br><a href="?action=behandelen&id=<?php echo $row['id']; ?>">Behandelen</a>
			</td>
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
$(document).ready(function() {
    $('#badm').DataTable();
} );
</script>
</body>

</html>
