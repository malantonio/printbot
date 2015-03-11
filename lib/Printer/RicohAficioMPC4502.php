<?php
namespace Printbot\Printer;

class RicohAficioMPC4502 extends BasePrinter {

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
            $this->setCopyColor($els[3]->find('td')[3]->plaintext);
            $this->setPrintBW($els[6]->find('td')[3]->plaintext);
            $this->setPrintColor($els[7]->find('td')[3]->plaintext);
        }

        return $this->counts;
    }

    public function getCopyBW() {
        // the default for each counts is null
        if ( is_int($this->counts['copy']['bw']) ) {
            return $this->counts['copy']['bw'];
        }

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

    public function getCopyColor() {
        // the default for each counts is null
        if ( is_int($this->counts['copy']['color']) ) {
            return $this->counts['copy']['color'];
        }

        if ( !$dom ) {
            $this->isOffline(true);
            return $this->setCopyColor(0);
        } else {
            $this->isOffline(false);
        
            $selector = '.staticProp';

            $els = $dom->find($selector);
            
            $count = $els[3]->find('td')[3]->plaintext;
            return $this->setCopyColor($count);
        }
    }

    public function getPrintBW() {
        // the default for each counts is null
        if ( is_int($this->counts['print']['bw']) ) {
            return $this->counts['print']['bw'];
        }

        if ( !$dom ) {
            $this->isOffline(true);
            return $this->setPrintBW(0);
        } else {
            $this->isOffline(false);
            $selector = '.staticProp';
            $els = $dom->find($selector);

            $count = $els[6]->find('td')[3]->plaintext;
            return $this->setPrintBW(intval($count));
        }
    }

    public function getPrintColor() {
        // the default for each counts is null
        if ( is_int($this->counts['print']['color']) ) {
            return $this->counts['print']['color'];
        }

        if ( !$dom ) {
            $this->isOffline(true);
            return $this->setPrintBW(0);
        } else {
            $this->isOffline(false);
            $selector = '.staticProp';
            $els = $dom->find($selector);

            $count = $els[7]->find('td')[3]->plaintext;
            return $this->setPrintBW(intval($count));
        }
    }

}