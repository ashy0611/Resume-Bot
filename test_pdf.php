<?php

require __DIR__ . '/vendor/autoload.php';

use Smalot\PdfParser\Parser;

$filePath = __DIR__ . '/sample.pdf';

if (!file_exists($filePath)) {
    die("❌ PDF file not found at: " . $filePath);
}

$parser = new Parser();
$pdf = $parser->parseFile($filePath);

$text = $pdf->getText();

echo "✅ Extracted PDF Text:\n\n";
echo $text;
