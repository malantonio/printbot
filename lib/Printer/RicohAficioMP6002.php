<?php
namespace Printbot\Printer;

class RicohAficioMP6002 extends BasePrinter {

    const COUNT_URI = "/web/guest/en/websys/status/getUnificationCounter.cgi";

    public function getCounts() {
        $dom = $this->getDOM();
        
        if ( !$dom ) {
            $this->isOffline(true);
            
            $this->setPrintBW(0);
            $this->setPrintColor(0);
            $this->setPrintColor(0);
            $this->setCopyColor(0);
            return false;

        } else {
            $this->isOffline(false);
        
            $selector = '.staticProp';

            $els = $dom->find($selector);

            $this->setCopyBW(intval($els[2]->find('td')[3]->plaintext));
            $this->setPrintBW(intval($els[3]->find('td')[3]->plaintext));
            
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
            $count = $els[2]->find('td')[3]->plaintext;

            return $this->setCopyBW(intval($count));
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
            $count = $els[3]->find('td')[3]->plaintext;

            return $this->setPrintBW(intval($count));
        }
    }
}
