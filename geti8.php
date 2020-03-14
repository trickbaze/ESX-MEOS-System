<?php
require "config.php";
$get = $con->query("SELECT * FROM i8 WHERE id='".$_GET['id']."'");
$row = $get->fetch_assoc();
$beoordeelddoorq = $con->query("SELECT name FROM users WHERE id = '".$row['beoordeeld_door_id']."'");
$beoordeelddoor = $beoordeelddoorq->fetch_assoc();
/*
array(26) {
  ["id"]=>
  string(1) "5"
  ["userid"]=>
  string(2) "15"
  ["datum_1"]=>
  string(11) "11-05-2019 "
  ["datum_2"]=>
  string(16) "11-05-2019 17:28"
  ["plaats"]=>
  string(6) "Plaats"
  ["omstandigheden"]=>
  string(14) "Omstandigheden"
  ["geweld_persoon"]=>
  string(1) "1"
  ["geweld_goed"]=>
  string(1) "1"
  ["letsel_betrokkene"]=>
  string(1) "1"
  ["letsel_betrokkene_onbekend"]=>
  string(1) "1"
  ["letsel_betrokkene_gering"]=>
  string(1) "0"
  ["letsel_betrokkene_ander"]=>
  string(1) "1"
  ["ander_letsel"]=>
  string(10) "Boem is ho"
  ["andere_schade"]=>
  string(1) "1"
  ["hovj_naam"]=>
  string(10) "Ben Fappen"
  ["hovj_rang"]=>
  string(10) "Inspecteur"
  ["toegepast_traangas"]=>
  string(1) "1"
  ["toegepast_diensthond"]=>
  string(1) "0"
  ["toegepast_dienstvoertuig"]=>
  string(1) "0"
  ["toegepast_fysiek"]=>
  string(1) "0"
  ["toegepast_handboeien"]=>
  string(1) "1"
  ["toegepast_stroomstootwapen"]=>
  string(1) "0"
  ["toegepast_vuurwapen"]=>
  string(1) "0"
  ["toegepast_wapenstok"]=>
  string(1) "1"
  ["beoordeeld_door_id"]=>
  NULL
  ["status"]=>
  string(1) "0"
}
*/
?>

<h2>Algemene informatie</h2>
<b>Formulierdatum:</b><br>
<?php echo trim($row['datum_1']); ?><br><br>
<b>Datum van voorval:</b><br>
<?php echo trim($row['datum_2']); ?><br><br>
<b>Plaats:</b><br>
<?php echo trim($row['plaats']); ?><br><br>
<b>Omstandigheden:</b><br>
<?php echo trim($row['omstandigheden']); ?><br><br>
<b>Geweld tegen persoon?</b><br>
<?php if ($row['geweld_persoon'] == 1) { echo "JA"; } else { echo "NEE"; }?><br><br>
<b>Geweld tegen goed?</b><br>
<?php if ($row['geweld_goed'] == 1) { echo "JA"; } else { echo "NEE"; }?><br><br>
<h2>Gevolgen van de geweldsaanwending</h2>
<b>Letsel bij betrokkenen derde?</b><br>
<?php if ($row['letsel_betrokkene'] == 1) { echo "JA"; } else { echo "NEE"; }?><br><br>
<b>Letsel Onbekend?</b><br>
<?php if ($row['letsel_betrokkene_onbekend'] == 1) { echo "JA"; } else { echo "NEE"; }?><br><br>
<b>Letsel gering?</b><br>
<?php if ($row['letsel_betrokkene_gering'] == 1) { echo "JA"; } else { echo "NEE"; }?><br><br>
<b>Letsel anders?</b><br>
<?php if ($row['letsel_betrokkene_ander'] == 1) { echo "JA"; } else { echo "NEE"; }?><br><br>
<b>Omschrijf ander letsel:</b><br>
<?php echo $row['ander_letsel']; ?><br><br>
<b>Materiele schade?</b><br>
<?php if ($row['andere_schade'] == 1) { echo "JA"; } else { echo "NEE"; }?><br><br>
<h2>Personalia HovJ</h2>
<b>Naam:</b><br>
<?php echo $row['hovj_naam']; ?><br><br>
<b>Rang:</b><br>
<?php echo $row['hovj_rang']; ?><br><br>
<h2>Toegepaste geweldsmiddelen</h2>
<b>Traangas?</b><br>
<?php if ($row['toegepast_traangas'] == 1) { echo "JA"; } else { echo "NEE"; }?><br><br>
<b>Diensthond?</b><br>
<?php if ($row['toegepast_diensthond'] == 1) { echo "JA"; } else { echo "NEE"; }?><br><br>
<b>Dienstvoertuig?</b><br>
<?php if ($row['toegepast_dienstvoertuig'] == 1) { echo "JA"; } else { echo "NEE"; }?><br><br>
<b>Fysiek?</b><br>
<?php if ($row['toegepast_fysiek'] == 1) { echo "JA"; } else { echo "NEE"; }?><br><br>
<b>Handboeien?</b><br>
<?php if ($row['toegepast_handboeien'] == 1) { echo "JA"; } else { echo "NEE"; }?><br><br>
<b>Stroomstootwapen?</b><br>
<?php if ($row['toegepast_stroomstootwapen'] == 1) { echo "JA"; } else { echo "NEE"; }?><br><br>
<b>Vuurwapen?</b><br>
<?php if ($row['toegepast_vuurwapen'] == 1) { echo "JA"; } else { echo "NEE"; }?><br><br>
<b>Wapenstok?</b><br>
<?php if ($row['toegepast_wapenstok'] == 1) { echo "JA"; } else { echo "NEE"; }?><br><br>
<hr>
<b>Beoordeeld door:</b><br>
<?php echo $beoordeelddoor['name']; ?><br><br>
<b>Status:</b><br>
<?php if ($row['status'] == 0) { echo "Openstaand"; } else { echo "Beoordeeld"; } ?><br><br>