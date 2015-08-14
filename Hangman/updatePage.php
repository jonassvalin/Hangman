<?php
include_once 'hangmanPage.php';

class updatePage extends hangmanPage {

	/**
	* Returns the HTML code for the specific content of webpage
	*/
	function getContentHtml() {
		$word = $_SESSION["word"];
		$html = '<img src="images/hang' . $_SESSION["failed"] . '.gif" height="190" width="190"><br>';
		for($i = 0; $i < strlen($word); $i++) {
			$char = $_SESSION["char".$i];
			if($char == "hidden") $html .= "_ ";
			else $html .= $word[$i]." ";
		}
		$html .= '
		<form action="hangman.php" method="POST"><br>
		Guess: <input type="text" name="guess" pattern="[A-Za-z]{1,1}"  required title="Use only lower case letters"><br><br>
		<input type="submit" name="update" value="Submit Guess!"><br><br>
		Used characters:
		';
		$alphabet = $GLOBALS['alphabet'];
		foreach ($alphabet as $letter) {
			if($_SESSION[$letter] == "used") $html .= $letter . " ";
		}
		return $html;
	}

	/**
	* Performs the underlying functionality of the webpage
	*/
	function performPageFunctionality() {
		$GLOBALS['alphabet'] = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K",
		"L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
		$guess = strtoupper($_POST["guess"]);
		$word = $_SESSION["word"];
		$wordLength = strlen($word);
		$failedAttempts = $_SESSION["failed"];
		if (!$this->checkGuess($guess, $word, $wordLength)) $failedAttempts++;
		$this->checkStatus($failedAttempts, $word, $wordLength);
	}

	/**
	* Checks whether the guessed character is contained within the word.
	* Returns true if it was, otherwise false.
	*/
	private function checkGuess($guess, $word, $wordLength) {
		$_SESSION[$guess] = "used";
		$correctGuess = false;
		for($i = 0; $i < $wordLength; $i++) {
			if($word[$i] == $guess) {
				$_SESSION["char".$i] = "found";
				$correctGuess = true;
			}
		}
		return $correctGuess;
	}

	/**
	* Checks if the player has either won or lost the game. If either is the case
	* the game is ended.
	*/
	private function checkStatus($failedAttempts, $word, $wordLength) {
		$allCorrect = true;
		for($i = 0; $i < $wordLength; $i++) {
			$char = $_SESSION["char".$i];
			if($char == "hidden") $allCorrect = false;
		}

		if($allCorrect) {
			$this->finishGame("You Win!", $word, $failedAttempts);
		} else if ($failedAttempts > 9) {
			$this->finishGame("You Lose!", $word, $failedAttempts);
		}

		$_SESSION["failed"] = $failedAttempts;
	}

	/**
	* Finishes the game, displays the correct word and inquiries the player if
	* he/she would like to play again.
	*/
	private function finishGame($output, $word, $failedAttempts) {
		echo $this->getIntroHtml();
		echo '<img src="images/hang' . $failedAttempts . '.gif" height="190" width="190"><br><br>';
		session_destroy();
		echo $output . ' The correct answer was: <b>' . $word . '</b>';
		echo '
		<form action="index.php" method="POST"><br>
		<input type="submit" name="restart" value="Restart Game?"><br><br><br><br>
		';
		echo $this->getOutroHtml();
		exit();
	}
}

?>
