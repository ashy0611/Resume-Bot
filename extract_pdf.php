<?php
require __DIR__ . '/vendor/autoload.php';

use Smalot\PdfParser\Parser;

// Path to your PDF
$pdfFile = __DIR__ . '/test.pdf';

if (!file_exists($pdfFile)) {
    die("PDF file not found!");
}

$parser = new Parser();
$pdf = $parser->parseFile($pdfFile);

// Extract text
$text = $pdf->getText();

// Display extracted text
echo nl2br($text); // nl2br adds line breaks for browser view
