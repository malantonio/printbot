<?php
namespace Printbot\Printer;

class RicohAficioSP8300DN extends BasePrinter {

    const COUNT_URI = "/web/guest/en/websys/status/getUnificationCounter.cgi";

    public function getCounts() {
        $this->getPrintBW();
        
        // zero-out the others
        $this->setCopyBW(0);
        $this->setCopyColor(0);
        $this->setPrintColor(0);

        return $this->counts;
    }

    public function getPrintBW() {
        // the default for each counts is null
        if ( is_int($this->counts['print']['bw']) ) {
            return $this->counts['print']['bw'];
        }

        $dom = $this->getDOM();
   
        if ( !$dom ) {
            $this->isOffline(true);
            
            $this->setPrintBW(0);
            return false;
        } else {
            $this->isOffline(false);
            $selector = ".staticProp";
            $els = $dom->find($selector);

            // grab the cells w/in the row
            $printBW = $els[2]->find('td');

            return $this->setPrintBW($printBW[3]->plaintext);
        }
    }
}
