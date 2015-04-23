<?php
require_once '../PHPWord.php';

// New Word Document
$PHPWord = new PHPWord();

// New portrait section
$section = $PHPWord->createSection();

// Add text elements


$section->addText('I am inline styled.', array('name'=>'Verdana', 'color'=>'006699'));
$section->addTextBreak(2);

$PHPWord->addFontStyle('rStyle', array('bold'=>true, 'italic'=>true, 'size'=>16));
$PHPWord->addParagraphStyle('pStyle', array('align'=>'center', 'spaceAfter'=>100));
$section->addText('I am styled by two style definitions.', 'rStyle', 'pStyle');
$section->addText('I have only a paragraph style definition.', null, 'pStyle');
$text="This is the ñojó symbol";
$text=iconv("UTF-8", "ISO-8859-1//TRANSLIT", $text);// 
$section->addText($text,null,null);
$section->addTextBreak(2);


// Save File
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save('Text.docx');
?>