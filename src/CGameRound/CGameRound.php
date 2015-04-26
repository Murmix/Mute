<?php
class CGameRound {

    private $playerName;
    private $topDiceValue = 0;
    private $totalDiceValue = 0;
    public function getTotalDiceValue() {
        return $this->totalDiceValue;
    }
    
    private $isRoundActive;//is true until you roll a 1
    public function getIsRoundActive() {
        return $this->isRoundActive;
    }
    
    private $allDice = array();
    
    public function __construct($playerName) {
        $this->isRoundActive = true;
        $this->playerName = $playerName;
    }
    
    public function rollDice() {
    
        if ($this->isRoundActive === true) {
            $newDice = new CDice();
            $this->allDice[] = $newDice;

            $this->topDiceValue = $this->totalDiceValue;
            $newValue = $newDice->getFaceValue();

            if ($newValue === 1) {
                $this->totalDiceValue = 0;
                $this->isRoundActive = false;
            } else {
                $this->totalDiceValue += $newValue;
            }
            
            return $newValue;
        }
        return 0;
    }
    
    public function renderHtmlOutput() {
        
        $returnString = "";
        
        if ($this->totalDiceValue > 0) {
            $returnString .= "<p class='current-round-dice'>Denna omgång: " . $this->totalDiceValue . "</p>"; 
        } elseif ($this->topDiceValue > 0) {
            $returnString .= "<p class='current-round-dice'>Denna omgång: <span class='line-through'>" . $this->topDiceValue . "</span> 0 </p>"; 
        }
        
        $returnString .= "<ul class='dice'>";
        foreach($this->allDice as $eachDie) {
            $returnString .= $eachDie->renderHtmlOutput();
        }
        $returnString .= "</ul>";
        
        return $returnString;
    }
 
}; 