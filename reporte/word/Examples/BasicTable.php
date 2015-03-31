<?php
require_once '../PHPWord.php';

// New Word Document
$PHPWord = new PHPWord();

// New portrait section
$section = $PHPWord->createSection();

// Add table
$table = $section->addTable();

for($r = 1; $r <= 10; $r++) { // Loop through rows
	// Add row
	$table->addRow();
	
	for($c = 1; $c <= 5; $c++) { // Loop through cells
		// Add Cell
		$table->addCell(1750)->addText("Row $r, Cell $c");
	}
}

// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Prueba.docx"');
header('Cache-Control: max-age=0');

$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save('php://output');
exit;
?>