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

    public function printText($text)
    {
        $this->printer->text($text);
        $this->printer->cut();
        $this->printer->close();
    }
}
