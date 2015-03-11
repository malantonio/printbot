<?php
namespace Printbot\Printer;

interface PrinterInterface {
    
    public function getPrintBW();
    public function getCopyBW();
    public function getPrintColor();
    public function getCopyColor();

    public function getPrintTotal();
    public function getCopyTotal();

    public function getTotal();
    public function getDOM();
}