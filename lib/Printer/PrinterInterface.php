<?php
namespace Printbot\Printer;

interface PrinterInterface {
    
    public function getBW();
    public function getColor();
    public function getCount();
    public function getDOM();
}