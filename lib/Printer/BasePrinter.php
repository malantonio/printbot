<?php
namespace Printbot\Printer;
use Sunra\PhpSimple\HtmlDomParser;

class BasePrinter implements PrinterInterface {

    const COUNT_URL = "";

    private $address;
    private $label;
    private $offline = true;

    public $counts = array(
        "bw"    => null,
        "color" => null
    );

    public function __construct($address, $label = null) {
        $this->setAddress($address);
        $this->setLabel($label);
    }

    /**
     *  @return int
     */

    public function getBW() {
        return is_int($this->counts['bw']) 
            ? $this->counts['bw']
            : $this->setBW(0);
    }

    /**
     *  @return int
     */

    public function getColor() {
        return is_int($this->counts['color']) 
            ? $this->counts['color']
            : $this->setColor(0);
    }

    /**
     *  @return int
     */

    public function getCount() {
        return $this->getBW() + $this->getColor();
    }

    /**
     *  @return Sunra\PhpSimple\HtmlDomParser object | null
     */

    public function getDOM() {
        $url = $this->address . self::COUNT_URL;
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
        $this->address = $address;
    }

    /**
     *  @param  int
     *  @return int
     */

    public function setBW($bwCount) {
        return $this->counts['bw'] = is_int($bwCount) 
                                   ? $bwCount 
                                   : intval($bwCount);
    }

    /**
     *  @param  int
     *  @return int
     */

    public function setColor($colorCount) {
        return $this->counts['color'] = is_int($colorCount) 
                                      ? $colorCount 
                                      : intval($colorCount);
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