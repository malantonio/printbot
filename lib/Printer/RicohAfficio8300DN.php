<?php
namespace Printbot\Printer;

class RicohAfficio8300DN extends BasePrinter {

    const COUNT_URI = "/web/guest/en/websys/status/getUnificationCounter.cgi";

    public function getBW() {

        // the default for each counts is null
        if ( is_int($this->counts['bw']) ) {
            return $this->counts['bw'];
        }

        $dom = $this->getDOM();
        
        if ( !$dom ) {
            $this->isOffline(true);
            return $this->setBW(0);
        } else {
            $this->isOffline(false);

            $selector = ".staticProp";
            $els = $dom->find($selector);

            $bingo = $els[2];

            $str = "";

            foreach($bingo->childNodes() as $td) {
                $str .= htmlspecialchars_decode($td->plaintext);
            }

            $ex = explode(":", $str);
            return $this->setBW(intval($ex[1]));
        }
    }
}
