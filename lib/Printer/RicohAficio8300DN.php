<?php
namespace Printbot\Printer;

class RicohAficio8300DN extends BasePrinter {

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
   
        $selector = ".staticProp";
        $els = $dom->find($selector);

        return $this->setPrintBW($els[2]->find('td')[3]->plaintext);
    }
}
