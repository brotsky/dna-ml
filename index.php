<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('TRAINING_SET_CSV', 'training-set.csv');
define('REMOVE_JUNK_CSV', 'remove-training-set-junk.csv');
define('JUNK_MUTATION_LIMIT', 0.1);

require('dataRow.php');

$trainingCSV = file_get_contents(TRAINING_SET_CSV);
$rows = explode('
', $trainingCSV);

$diseaseAPatients = false;
$diseaseBPatients = false;
$diseaseCPatients = false;
$healthyPatients = false;

$diseasesRow = explode(',', $rows[0]);
foreach($diseasesRow as $key => $cell) {
  if($key > 3) {
    if($cell === 'Disease A') $diseaseAPatients[] = $key;
    if($cell === 'Disease B') $diseaseBPatients[] = $key;
    if($cell === 'Disease C') $diseaseCPatients[] = $key;
    else $healthyPatients[] = $key;
  }
}

?>
<pre>
<?php var_dump($diseaseAPatients); ?>
<?php var_dump($diseaseBPatients); ?>
<?php var_dump($diseaseCPatients); ?>
<?php var_dump($healthyPatients); ?>
</pre>
<?php

$mutations = false;
foreach($rows as $key => $row) {
  if($key > 1) { // remove titles
    $cells = explode(',', $row);
    $row = new DataRow($cells);
    if($row->mutations && $row->differences)
      $mutations[] = $row;
  }
}

$displayRows = $mutations;
?>
<table class="table">
  <thead>
    <tr>
      <?php 
      $row1 = explode(',',$rows[0]);
      foreach($row1 as $cell) {
        ?>
        <th><?php echo $cell ?></th>
        <?php
      }
      ?>
    </tr>
    <tr>
      <?php
      $row2 = explode(',',$rows[1]);
      foreach($row2 as $cell) {
        ?>
        <th><?php echo $cell ?></th>
        <?php
      }
      ?>
    </tr>
  </thead>
  <tbody>
      <?php foreach($displayRows as $row) { ?>
      <tr>
        <td><?php echo $row->region; ?></td>
        <td><?php echo $row->position; ?></td>
        <td><?php echo $row->gene; ?></td>
        <td></td>
        <?php foreach($row->data as $cell) { ?>
          <td style="background-color: rgb(<?php echo 255 - $cell * 255 ?>, 255, 255)"><?php echo $cell; ?></td>
        <?php } ?>
      </tr>
      <?php } ?>
  </tbody>
</table>
<?php

