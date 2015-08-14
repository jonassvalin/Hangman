<?php
include_once 'hangmanPage.php';
include_once 'Unirest.php';

class initializationPage extends hangmanPage {

	/**
	* Returns the HTML code for the specific content of webpage
	*/
	function getContentHtml() {
		$html = '<img src="images/hang0.gif" height="190" width="190"><br>';
		$wordLength = strlen($_SESSION["word"]);
		for($i = 0; $i < $wordLength; $i++) {
			$html .= "_ ";
		}
		$html .= '
		<form action="hangman.php" method="POST"><br>
		Guess: <input type="text" name="guess" pattern="[A-Za-z]{1,1}"   required title="Use only lower case letters"><br><br>
		<input type="submit" name="update" value="Submit Guess!"><br><br>
		Used characters:
		';
		return $html;
	}

	/**
	* Performs the underlying functionality of the webpage
	*/
	function performPageFunctionality() {
		$GLOBALS['alphabet'] = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", 
		"L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
		$difficulty = $_POST['difficulty'];
		$url = $this->createURL($difficulty, "https://wordsapiv1.p.mashape.com/words?random=true&");
		$randomWord = $this->retrieveRandomWord($url);
		$this->setSessionVariables($randomWord);
	}

		/**
		* Defines the URL to call the Words API based on the difficulty setting.
		*/
		private function createURL($difficulty, $url) {
			$wordLength;
			switch($difficulty) {
				case("easy"):
				$minLength = 3;
				$maxLength = 4;
				break;
				case("medium"):
				$minLength = 5;
				$maxLength = 7;
				break;
				case("hard"):
				$minLength = 8;
				$maxLength = 10;
				break;
			}
			$url = $url . "lettersMin=" . $minLength . "&lettersMax=" . $maxLength;
			return $url;
		}

		/**
		* Fetches a json containing a randomly generated word from the API, based on the difficulty
		* setting. Returns the json.
		* @param unknown $url
		*/
		private function retrieveRandomWord($url) {
			$response = Unirest\Request::get($url,
			array(
				"X-Mashape-Key" => "xJkqXGguDTmshoNIaGVnrMZlFPmUp1WrnZLjsn8DDx3DFQhNq5",
				"Accept" => "application/json"
			)
		);
		$wordJSON = json_decode($response->raw_body);
		$word = $wordJSON->{"word"};

		/*
		* The API provides some weird words (if you can even call them that) like "dr. j" which I don't think should be included.
		* If such a word is provided, the function instead calls itself recursively to get a new word.
		*/

		if (strpos($word,'.') !== false || strpos($word,' ') !== false) {
			return retrieveRandomWord($url);
		} else {
			return strtoupper($word);
		}

		/*Loose idea for discarding words with too low frequency. API seems to be broken however,
		* sometimes the frequency parameter doesn't exist, unsure of the cause (nothing stated in docs).
		*
		*
		* $freq = $wordJSON->{"frequency"};
		* if ($freq > 3.5) return $wordJSON->{"word"};
		* else return retrieveRandomWord($url);
		*/
	}

	/**
	* Sets variables that are needed globally when playing the game
	*/
	private function setSessionVariables($word) {
		$_SESSION["word"] = $word;
		$_SESSION["failed"] = 0;
		$wordLength = strlen($word);
		for($i = 0; $i < $wordLength; $i++) {
			$_SESSION["char".$i] = "hidden";
		}

		$alphabet = $GLOBALS['alphabet'];
		foreach ($alphabet as $letter) {
			$_SESSION[$letter] = "unused";
		}
	}
}

?>
