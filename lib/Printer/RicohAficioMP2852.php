<?php
namespace Printbot\Printer;

class RicohAficioMP2852 extends BasePrinter {

    const COUNT_URI = "/web/guest/en/websys/status/getUnificationCounter.cgi";

    public function getCounts() {
        $dom = $this->getDOM();
        
        if ( !$dom ) {
            $this->isOffline(true);
            return $this->setPrintBW(0);
        } else {
            $this->isOffline(false);
        
            $selector = '.staticProp';

            $els = $dom->find($selector);

            $this->setCopyBW($els[2]->find('td')[3]->plaintext);
            $this->setPrintBW($els[3]->find('td')[3]->plaintext);
            
            // no color options here
            $this->setPrintColor(0);
            $this->setCopyColor(0);
        }

        return $this->counts;
    }

    public function getCopyBW() {
        if ( is_int($this->counts['copy']['bw']) ) {
            return $this->counts['copy']['bw'];
        }
        
        $dom = $this->getDOM();
        
        if ( !$dom ) {
            $this->isOffline(true);
            return $this->setCopyBW(0);
        } else {
            $this->isOffline(false);
        
            $selector = '.staticProp';

            $els = $dom->find($selector);

            return $this->setCopyBW($els[2]->find('td')[3]->plaintext);
        }
    }

    public function getPrintBW() {
        if ( is_int($this->counts['print']['bw']) ) {
            return $this->counts['print']['bw'];
        }
        
        $dom = $this->getDOM();
        
        if ( !$dom ) {
            $this->isOffline(true);
            return $this->setPrintBW(0);
        } else {
            $this->isOffline(false);
        
            $selector = '.staticProp';

            $els = $dom->find($selector);

            return $this->setPrintBW($els[3]->find('td')[3]->plaintext);
        }
    }
}
