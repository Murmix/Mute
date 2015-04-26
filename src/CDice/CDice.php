<?php
class CDice {

    private $faceValue;
    public function getFaceValue() {
        return $this->faceValue;
    }

    public function __construct($numFaces = 6) {
        $this->faceValue = rand(1, $numFaces);
    }

    public function renderHtmlOutput() {
        return "<li class='dice-$this->faceValue'></li>";
    }    
}; 