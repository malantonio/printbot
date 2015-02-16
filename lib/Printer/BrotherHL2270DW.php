<?php
namespace Printbot\Printer;

class BrotherHL2270DW extends BasePrinter {

    const COUNT_URI = "/printer/main.html";

    public function getBW() {
        $dom = $this->getDOM();
        if ( !$dom ) { 
            $this->isOffline(true);
            return $this->setBW(0);
        } else {
            $selector = ".elemwhite";
            $elCollection = $dom->find($selector);

            // grab the last element
            $countEl = $elCollection[count($elCollection) - 1];
            $text = html_entity_decode($countEl->plaintext);
            
            $count = preg_replace("/[^\d]/", "", $text);
            return $this->setBW($count);
        }
    }
}