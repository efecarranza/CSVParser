<?php

  $frpFile = 'input.txt';
  $outputFile = 'output.csv';

  $fin = fopen($frpFile, 'r');
  $fout = fopen($outputFile, 'w');

   $categories = array(
      'Air Flow' => array('ACA', 'VACA', 'PAPA'),
      'Electrical' => array('APP', 'BAA', 'BABA'),
    );

  $headers = array(
          'Item Code',
          'Main Category',
          'Sub-Category',
          'Item Name',
          'Description (optional)',
          'Retail Price Standard',
          'Retail Price Overtime)',
      );
  fputcsv($fout, $headers);

  while (!feof($fin)) {
    $linesToCsv = array();
    $line = fgets($fin);
    $lineSanitized = explode("\t", $line);

    array_push($linesToCsv, $lineSanitized[1]);
    $mainCategory = DetermineCategory($lineSanitized[0], $categories);
    array_push($linesToCsv, $mainCategory);
    array_push($linesToCsv, $lineSanitized[0]);
    array_push($linesToCsv, $lineSanitized[2]);
    array_push($linesToCsv, $lineSanitized[3]);
    array_push($linesToCsv, $lineSanitized[15]);
    array_push($linesToCsv, $lineSanitized[20]);

    fputcsv($fout, $linesToCsv);

  }

  fclose($fin);
  fclose($fout);

  function DetermineCategory($subcategory, $categories) {
    foreach($categories as $categoryKey => $category) {
      if (in_array($subcategory, $category)) {
        return $categoryKey;
      }
    }
  }

?>
