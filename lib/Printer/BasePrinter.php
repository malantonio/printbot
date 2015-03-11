<?php
namespace Printbot\Printer;
use Sunra\PhpSimple\HtmlDomParser;

abstract class BasePrinter implements PrinterInterface {

    const COUNT_URI = "";

    private $address;
    private $label;
    private $offline = true;

    public $counts = array(
        "copy" => array(
            "bw"    => null,
            "color" => null
        ),
        
        "print" => array(
            "bw"    => null,
            "color" => null
        )
    );

    public function __construct($address, $label = null) {
        $this->setAddress($address);
        $this->setLabel($label);
    }

    /**
     *  @return int
     */

    public function getCopyBW() {        
        return is_int($this->counts['copy']['bw'])
            ? $this->counts['copy']['bw']
            : $this->setCopyBW(0);
    }

    /**
     *  @return int
     */

    public function getPrintBW() {        
        return is_int($this->counts['print']['bw'])
            ? $this->counts['print']['bw']
            : $this->setPrintBW(0);
    }


    /**
     *  @return int
     */

    public function getCopyColor() {        
        return is_int($this->counts['copy']['color'])
            ? $this->counts['copy']['color']
            : $this->setCopyColor(0);
    }

    /**
     *  @return int
     */

    public function getPrintColor() {        
        return is_int($this->counts['print']['color'])
            ? $this->counts['print']['color']
            : $this->setPrintColor(0);
    }

    /**
     *  @return int
     */

    public function getCopyTotal() {
        return intval($this->getCopyColor())
             + intval($this->getCopyBW());
    }

    /**
     *  @return int
     */

    public function getPrintTotal() {
        return intval($this->getPrintColor())
             + intval($this->getPrintBW());
    }

    /**
     *  @return int
     */

    public function getTotal() {
        return intval($this->getCopyTotal())
             + intval($this->getPrintTotal());
    }

    /**
     *  @return Sunra\PhpSimple\HtmlDomParser object | null
     */

    public function getDOM() {
        // in order to access the constant value from an extended class,
        // we'll have to retrieve the class first
        $c = get_called_class();
        $url = $this->address . $c::COUNT_URI;
        $dom = @HtmlDomParser::file_get_html($url);
        return $dom;
    }

    /**
     *  @return string
     */

    public function getAddress() {
        return $this->address;
    }

    /**
     *  @return string
     */

    public function getLabel() {
        return $this->label;
    }

    /**
     *  @param  boolean
     *  @return boolean
     */

    public function isOffline($switch = null) {
        return is_bool($switch) ? $this->offline = $switch : $this->offline;
    }

    /**
     *  @param string
     */

    public function setAddress($address) {
        $this->address = preg_match("|https?://|", $address)
                       ? $address
                       : "http://" . $address;
    }

    /**
     *  @param  int
     *  @return int
     */

    public function setCopyBW($copyBWCount) {
        return $this->counts['copy']['bw'] = is_int($copyBWCount)
                                   ? $copyBWCount
                                   : intval($copyBWCount);
    }

    /**
     *  @param  int
     *  @return int
     */

    public function setPrintBW($printBWCount) {
        return $this->counts['print']['bw'] = is_int($printBWCount)
                                   ? $printBWCount
                                   : intval($printBWCount);
    }

    /**
     *  @param  int
     *  @return int
     */

    public function setCopyColor($copyColorCount) {
        return $this->counts['copy']['color'] = is_int($copyColorCount)
                                   ? $copyColorCount
                                   : intval($copyColorCount);
    }

    /**
     *  @param  int
     *  @return int
     */

    public function setPrintColor($printColorCount) {
        return $this->counts['print']['color'] = is_int($printColorCount)
                                   ? $printColorCount
                                   : intval($printColorCount);
    }


    /**
     *  @param string
     */

    public function setLabel($label = null) {
        if ( !$label ) {
            $this->label = $this->getAddress();
        } else {
            $this->label = $label;
        }
    }
}
