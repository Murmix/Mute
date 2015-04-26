<?php
class CDiceGame {

    private $extraInfoText;

    private $currentGameRound = 0; // 0 = Not started, -1 = Finished
    private function setCurrentGameRound($newval) {
        $this->currentGameRound = $newval;
        $_SESSION['currentGameRound'] = $newval;
    }
    
    private $totalScore = array(0,0);
    private function setTotalScore($newval) {
        $this->totalScore[$this->currentPlayerIndex] = $newval;
        $_SESSION['totalScore'] = $this->totalScore;
    }

    private $gameRounds;
    private $currentPlayerIndex = 0;
    private function setCurrentPlayerIndex($newval) {
        $this->currentPlayerIndex = $newval;
        $_SESSION['currentPlayerIndex'] = $newval;
    }
    
    private $players = array();//string array: 'player-one', 'player-two' or 'player-cpu'
    private function getPlayerCount() {
        if (isset($this->players))
            return count($this->players);
        return 0;
    }
        
    const IntroText = "Välkommen till Tärningsspelet 100. Det gäller att samla ihop poäng för att komma först till 100. I varje omgång kastar en spelare tärning tills hon väljer att stanna och spara poängen eller tills det dyker upp en 1:a och hon förlorar alla poäng som samlats in i rundan.";
    
    public function __construct() {
    
        $this->currentGameRound = isset($_SESSION['currentGameRound']) ? $_SESSION['currentGameRound'] : 0;
        $this->currentPlayerIndex = isset($_SESSION['currentPlayerIndex']) ? $_SESSION['currentPlayerIndex'] : 0;
        if (isset($_SESSION['totalScore']))
            $this->totalScore = $_SESSION['totalScore'];
        if (isset($_SESSION['gameRounds']))
            $this->gameRounds = $_SESSION['gameRounds'];
        if (isset($_SESSION['players']))
            $this->players = $_SESSION['players'];
    
    }
    
    public function main() {
    
        //convert $_GET parameters to function calls
        $this->parseGetParameters();
        
        return $this->renderHtmlOutput();
    }
    
    private function renderHtmlOutput() {
        $returnString = ""; 
        
        if ($this->getPlayerCount() > 0) {
            $returnString .= "<div class='dicegame-content {$this->players[$this->currentPlayerIndex]}'>"; 
            //score boxes for all players visible at all times:
            $returnString .= "<div class='player-one score-info'>Spelare 1 (Grön): {$this->totalScore[0]} poäng</div>";
            if ($this->getPlayerCount() > 1) {
                //no time for pretty code: we know it's either player-two or player-cpu
                $playerTwoName = "Spelare 2 (Blå)";
                if ($this->players[1]==="player-cpu")
                    $playerTwoName = "Datorspelare (Grå)";
                    
                $returnString .= "<div class='{$this->players[1]} score-info'>$playerTwoName: {$this->totalScore[1]} poäng</div>";
            }
            $returnString .= "<div style='clear:both;'></div>";
            
        } else {
            $returnString .= "<div class='dicegame-content'>"; 
        }
        //Info text
        $returnString .= "<div class='gameinfo'>";
        if ($this->currentGameRound == 0) {
            $returnString .= "<p>" . self::IntroText . "</p>"; 
        } elseif ($this->currentGameRound == -1) {
            //$returnString .= "<p class='total-score'>Din poäng: " . $this->totalScore[$this->currentPlayerIndex] . "</p>"; 
            $returnString .= "<p class='total-score'>&nbsp;</p>"; 
            $returnString .= "<p class='extra-info-text'>" . $this->extraInfoText . "</p>"; 
        } else {
            $returnString .= "<p class='total-score'>&nbsp;</p>"; 
            $returnString .= "<p class='current-round'>Omgång: " . $this->currentGameRound . "</p>"; 
            //$returnString .= "<p class='total-score'>Din poäng: " . $this->totalScore[$this->currentPlayerIndex] . "</p>"; 
            $returnString .= $this->gameRounds[$this->currentPlayerIndex][$this->currentGameRound]->renderHtmlOutput(); 
            $returnString .= "<p class='extra-info-text'>" . $this->extraInfoText . "</p>"; 
        }
        $returnString .= "</div>";
        
        //Buttons
        $returnString .= "<div class='buttons'>";
        if ($this->currentGameRound == 0) {
            $returnString .= "<a href='?startGame1'>Starta nytt spel</a>";
            $returnString .= "<a href='?startGame2'>Två spelare</a>";
            $returnString .= "<a href='?startGameCPU'>Spela mot datorn</a>";
        } elseif ($this->currentGameRound == -1) {
            $returnString .= "<a class='end-game' href='?endGame'>Avsluta spelet</a>";
        } elseif ($this->currentPlayerIndex > 0 && $this->players[1]==="player-cpu") {
                $returnString .= "<a class='next-round' href='?startNextRound'>Nästa omgång</a>";
                $returnString .= "<a class='end-game-premature' href='?endGame' onclick=\"return confirm('Alla poäng kommer att försvinna. Är du säker på att du vill avsluta spelet?');\">X</a>";
        } else {
            if ($this->gameRounds[$this->currentPlayerIndex][$this->currentGameRound]->getIsRoundActive()) {
                $returnString .= "<a class='roll-dice' href='?rollDice'>Kasta en tärning</a>";
            }
            if ($this->gameRounds[$this->currentPlayerIndex][$this->currentGameRound]->getTotalDiceValue() > 0) {
                $returnString .= "<a class='save-round' href='?startNextRound'>Spara omgångens poäng</a>";
            } elseif ($this->gameRounds[$this->currentPlayerIndex][$this->currentGameRound]->getIsRoundActive() === false) {
                $returnString .= "<a class='next-round' href='?startNextRound'>Nästa omgång</a>";
            }
            $returnString .= "<a class='end-game-premature' href='?endGame' onclick=\"return confirm('Alla poäng kommer att försvinna. Är du säker på att du vill avsluta spelet?');\">X</a>";
        }
        $returnString .= "</div>";

        $returnString .= "</div>";
        
        return $returnString;
    }
    
    private function parseGetParameters() {
    
        if(isset($_GET['startGame1']))
            $this->startGame(1);
        elseif(isset($_GET['startGame2']))
            $this->startGame(2);
        elseif(isset($_GET['startGameCPU']))
            $this->startGame(3);
        elseif(isset($_GET['endGame']))
            $this->endGame();
        elseif(isset($_GET['rollDice']))
            $this->rollDice();
        elseif(isset($_GET['startNextRound']))
            $this->startNextRound();
 
    }
    
    private function rollDice() {
        $rollValue = $this->gameRounds[$this->currentPlayerIndex][$this->currentGameRound]->rollDice();
        $rollValueText = array("nolla?!", "etta! Omgången är förlorad!", "tvåa.", "trea.", "fyra.", "femma.", "sexa.");
        if ($rollValue > 0)
            $this->extraInfoText = "Du slog en {$rollValueText[$rollValue]}";
            
        return $rollValue;
    }
    
    private function computerPlayerRollsDice() {
        $rollValue = $this->rollDice();
        while($rollValue > 1) {
            if (rand(1,5) != 5) //20% chance for computer to decide to quit every throw
                $rollValue = $this->rollDice();
            else
                return;
        }
    }
    
    private function startNextRound() {

        $addPoints = 0;
        if ($this->currentGameRound > 0) {
            $addPoints = $this->gameRounds[$this->currentPlayerIndex][$this->currentGameRound]->getTotalDiceValue();
            $this->setTotalScore($this->totalScore[$this->currentPlayerIndex] + $addPoints);
        }
        
            
        if ($this->currentGameRound > 0 && $this->totalScore[$this->currentPlayerIndex] >= 100) {
            $this->extraInfoText = "Grattis, du klarade spelet på $this->currentGameRound omgångar.";
            $this->setCurrentGameRound(-1);
        } else {
        
            if ($this->currentPlayerIndex < $this->getPlayerCount()-1) {
                $this->setCurrentPlayerIndex($this->currentPlayerIndex+1);
            } else {
                $this->setCurrentGameRound($this->currentGameRound + 1);
                $this->setCurrentPlayerIndex(0);
            }
            
            $this->gameRounds[$this->currentPlayerIndex][$this->currentGameRound] = new CGameRound($this->players[$this->currentPlayerIndex]);
            $_SESSION['gameRounds'] = $this->gameRounds;
            if ($this->getPlayerCount() > 1) {
            
                if ($this->currentPlayerIndex > 0 && $this->players[1]==="player-cpu") {
                    $this->computerPlayerRollsDice();
                    $this->extraInfoText = "Datorspelarens tur. Det gick snabbt.";
                } else {
                    $this->extraInfoText = "Förra spelaren fick $addPoints poäng. Kasta tärningen och lycka till!";
                }
            } elseif ($addPoints > 0) {
                $this->extraInfoText = "Du stannar och lägger undan $addPoints poäng. Nu börjar omgång $this->currentGameRound.";
            } else {
                $this->extraInfoText = "Du fick $addPoints poäng i förra omgången. Bättre lycka i omgång $this->currentGameRound.";
            }
        }
    }
    
    private function startGame($gameMode) {
    
        if ($gameMode === 1)
            $this->players = array("player-one");
        elseif ($gameMode === 2)
            $this->players = array("player-one", "player-two");
        else //if ($gameMode === 3)
            $this->players = array("player-one", "player-cpu");
        
        $_SESSION['players'] = $this->players;

        $this->setCurrentGameRound(0);
        $this->setTotalScore(0);
        $this->setCurrentPlayerIndex(999);
        
        $this->gameRounds = array(array());
        $this->startNextRound();
        
        $this->extraInfoText = "Nu börjar spelet. Kasta tärningen tills du är nöjd eller tills du slår en etta.";
    }

    private function endGame() {
        $this->setCurrentGameRound(0);
        unset($this->totalScore);
        unset($_SESSION['totalScore']);
        unset($this->gameRounds);
        unset($_SESSION['gameRounds']);
        unset($this->players);
        unset($_SESSION['players']);
        $this->setCurrentPlayerIndex(0);
        unset($_SESSION['currentPlayerIndex']);
        
        $this->extraInfoText = "";
        
    }
    
}; 