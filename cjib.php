<?php
require "config.php";
if ($_SESSION['loggedin'] != TRUE) {
	Header("Location: login.php?returnpage=aangiftes");
}
if ($_SESSION['role'] == "anwb") {
	Header("Location: index");
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	//We need to have a CJIB number
	
	$allCJIB = $con->query("SELECT COUNT(id) as count FROM cjib");
	$allCJIB = $allCJIB->fetch_assoc();
	$number = (int)$allCJIB['count'];
	$number = $number + 1;
	
	
	if ($_POST['form'] == "new") {
		$insert = $con->query("
		INSERT INTO cjib
		(
		number,
		name,
		steam,
		phone,
		dob,
		job,
		open,
		term,
		last_contact,
		user
		)
		VALUES
		(
		'CJIB-".date("Y").'-'.$number."',
		'".$con->real_escape_string($_POST['name'])."',
		'".$con->real_escape_string($_POST['steam'])."',
		'".$con->real_escape_string($_POST['phone'])."',
		'".$con->real_escape_string($_POST['dob'])."',
		'".$con->real_escape_string($_POST['job'])."',
		'".$con->real_escape_string($_POST['open'])."',
		'".$con->real_escape_string($_POST['term'])."',
		'".$con->real_escape_string($_POST['last_contact'])."',
		'".$con->real_escape_string($_POST['user'])."'
		)
		");
		
		//echo $con->error;
		
		if ($insert) {
			Header("Location: cjib_dossier?id=".$con->insert_id);
		}
	}
}

$cjibstuff = $con->query("SELECT * FROM cjib WHERE status = 'open' OR status = 'wanted'");
//var_dump($cjibstuff->fetch_assoc());
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
  <title>Zoutelande - CJIB</title>
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
        <li class="breadcrumb-item active">Centraal Justitieel Incassobureau</li>
      </ol>
		<hr>
		<a href="#" data-toggle="modal" data-target="#exampleModal" class="btn btn-success btn-block">Nieuw dossier</a>
		<table id="badm" class="table">
		  <tr>
			<th>CJIB nummer</th>
			<th>In gebreke gestelde</th> 
			<th>Status</th>
			<th>Openstaand</th>
			<th>Opmaakdatum</th>
			<th>Behandelaar</th>
			<th>Herinnering</th>
		  </tr>
		  <!--<tr>
			<td>CJIB-2019-1</td>
			<td>K. Hollander</td> 
			<td>Gesloten</td>
			<td>12-01-2019</td>
			<td>K. Hollander</td>
			<td>x</td>
		  </tr>-->
		  <?php
		  while($row = $cjibstuff->fetch_assoc()) {
		  ?>
		  <tr>
			<td><a href="/cjib_dossier?id=<?php echo $row['id']; ?>"><?php echo $row['number'] ?></a></td>
			<td><?php echo $row['name'] ?></td> 
			<td><?php echo $row['status'] ?></td> 
			<td>&euro; <?php echo $row['open'] ?></td> 
			<td><?php echo $row['created_at'] ?></td> 
			<td><?php echo $row['user'] ?></td> 
			<td><a href="/cjib_herinnering?id=<?php echo $row['id']; ?>">Afdrukken</a></td>
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
          <small>Copyright © Zoutelande</small>
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
            <h5 class="modal-title" id="exampleModalLabel">Nieuw dossier</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Sluiten">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
			<form method="POST" id="new" name="new">
				<input type="hidden" name="form" value="new">
				<label for='name'><em><b>Volledige naam:</b></em></label>
				<input type="text" name="name" id="name" class="form-control"><br>
				<label for='steam'><em><b>Steamnaam:</b></em></label>
				<input type="text" name="steam" id="steam" class="form-control"><br>
				<label for='phone'><em><b>Telefoonnummer:</b></em></label>
				<input type="text" name="phone" id="phone" class="form-control"><br>
				<label for='dob'><em><b>Geboortedatum:</b></em></label>
				<input type="text" name="dob" id="dob" placeholder="17-04-1997" class="form-control"><br>
				<label for='job'><em><b>Beroep:</b></em></label>
				<input type="text" name="job" id="job" placeholder="Buschauffeur" class="form-control"><br>
				<label for='open'><em><b>Openstaand bedrag:</b></em></label>
				<input type="text" name="open" id="open" placeholder="&euro; 50.000" class="form-control"><br>
				<label for='term'><em><b>Betalingstermijn:</b></em></label>
				<input type="text" name="term" id="term" placeholder="4 maanden" class="form-control"><br>
				<label for='last_contact'><em><b>Laatste contactmoment:</b></em></label>
				<input type="text" name="last_contact" id="last_contact" value="<?php echo date('d-m-Y'); ?>" class="form-control"><br>
				<label for='user'><em><b>Ambtenaar:</b></em></label>
				<input type="text" name="user" id="user" value="<?php echo $_SESSION['name']; ?>" class="form-control" readonly><br>
			</form>
			</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Afbreken</button>
            <input class="btn btn-primary" type="submit" value="Opslaan" form="new">
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
