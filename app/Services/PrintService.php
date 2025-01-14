<?php

namespace App\Services;

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class PrintService
{
    protected $printer;

    public function __construct()
    {
        $connector = new WindowsPrintConnector('POS-58');
        $this->printer = new Printer($connector);
    }

    protected $lineWidth = 30;

    /**
     * Center align text within the line width.
     *
     * @param string $text
     * @return string
     */
    public function centerAlignText($text)
    {
        $padding = ($this->lineWidth - strlen($text)) / 2;
        return str_repeat(' ', max(0, floor($padding))) . $text;
    }

    /**
     * Format total line for the receipt.
     *
     * @param string $label
     * @param string $amount
     * @return string
     */
    public function formatTotalLine($label, $amount)
    {
        return sprintf("%-20s %10s", $label, $amount);
    }

    /**
     * Format item line for the receipt with justified alignment.
     *
     * @param string $name
     * @param int $qty
     * @param string $price
     * @param string $total
     * @return string
     */
    public function formatItemLine($name, $qty, $price, $total)
    {
        // Nama barang pada baris pertama
        $itemLine = sprintf("%-30s", $name);

        // Detail qty, harga satuan, dan total harga pada baris kedua
        $detailsLine = sprintf(
            "%3d x %-10s %12s",
            $qty,
            $price,
            $total
        );

        return $itemLine . "\n  " . $detailsLine;
    }

    /**
     * Print the receipt to a file (simulate printer output).
     *
     * @param string $title
     * @param string $header
     * @param array $items
     * @param array $totals
     */
    public function printReceipt($header, $items, $totals)
    {
        $receipt = $header . "\n\n";
        $receipt .= implode("\n", $items) . "\n\n";
        $receipt .= implode("\n", $totals) . "\n";
        $receipt .= "-----------------------------\n";
        $receipt .= $this->centerAlignText("Thank You!") . "\n";
        
        // Start printing
        $this->printer->text($receipt);
        $this->printer->cut();
        $this->printer->close();
    }
}
