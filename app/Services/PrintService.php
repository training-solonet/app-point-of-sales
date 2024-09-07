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

    public function printReceipt($title, $header, $items, $totals)
    {
        $this->printer->text($title."\n");
        $this->printer->text($header."\n");

        $this->printer->text(str_repeat('-', 32)."\n");

        foreach ($items as $item) {
            $this->printer->text($item."\n\n");
        }

        $this->printer->text(str_repeat('-', 32)."\n");

        foreach ($totals as $total) {
            $this->printer->text($total."\n");
        }

        $this->printer->text("\n----------THANK YOU----------\n");
        $this->printer->text("\n\n");

        $this->printer->cut();
        $this->printer->feed(3);
        $this->printer->close();
    }

    public function formatItemLine($name, $qty, $price, $total)
    {
        $nameLine = $name;
        $detailLine = sprintf('%5s x %7s %10s', $qty, $price, $total);

        return $nameLine."\n".$detailLine;
    }

    public function formatTotalLine($label, $amount)
    {
        return sprintf('%-20s %10s', $label, $amount);
    }
}
