<?php

namespace App\Services;

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Element\Text;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\Element\Title;
use PhpOffice\PhpWord\Element\Table;
use Smalot\PdfParser\Parser;

class ResumeParserService
{
    /**
     * Extract text from PDF, DOCX
     */
    public function extractText(string $filePath): string
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        return match ($extension) {
            'pdf'  => $this->extractFromPdf($filePath),
            'docx' => $this->extractFromDocx($filePath),
            default => '',
        };
    }

    /**
     * Extract text from PDF (text-based)
     */
    protected function extractFromPdf(string $filePath): string
    {
        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($filePath);
            $text = $pdf->getText();

            return $this->normalizeText($text);
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * Extract text from DOCX using PHPWord
     */
    protected function extractFromDocx(string $filePath): string
    {
        try {
            $phpWord = IOFactory::load($filePath);
            $text = '';

            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {

                    // Headings
                    if ($element instanceof Title) {
                        $text .= $element->getText() . PHP_EOL;
                    }

                    // Normal text
                    elseif ($element instanceof Text) {
                        $text .= $element->getText() . PHP_EOL;
                    }

                    // Text runs (most resumes)
                    elseif ($element instanceof TextRun) {
                        foreach ($element->getElements() as $child) {
                            if ($child instanceof Text) {
                                $text .= $child->getText() . ' ';
                            }
                        }
                        $text .= PHP_EOL;
                    }

                    // Tables (rare but possible)
                    elseif ($element instanceof Table) {
                        foreach ($element->getRows() as $row) {
                            foreach ($row->getCells() as $cell) {
                                foreach ($cell->getElements() as $cellElement) {
                                    if ($cellElement instanceof Text) {
                                        $text .= $cellElement->getText() . ' ';
                                    }
                                }
                            }
                            $text .= PHP_EOL;
                        }
                    }
                }
            }

            return $this->normalizeText($text);
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * Normalize extracted text
     */
    protected function normalizeText(string $text): string
    {
        $text = html_entity_decode($text);
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }
}
