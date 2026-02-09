<?php

require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Element\Text;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\Element\Title;

$filePath = __DIR__ . '/sample.docx';

$phpWord = IOFactory::load($filePath);

$text = '';

foreach ($phpWord->getSections() as $section) {
    foreach ($section->getElements() as $element) {

        if ($element instanceof Text) {
            $text .= $element->getText() . PHP_EOL;
        } elseif ($element instanceof TextRun) {
            foreach ($element->getElements() as $child) {
                if ($child instanceof Text) {
                    $text .= $child->getText() . ' ';
                }
            }
            $text .= PHP_EOL;
        } elseif ($element instanceof Title) {
            $text .= $element->getText() . PHP_EOL;
        }
    }
}

echo $text;
