<?php session_start();
include 'Unirest.php';
	
	/**
	 * Defines the URL that is used by the Words API based on the difficulty setting.
	 * @param unknown $difficulty
	 * @param unknown $url
	 */
	function createURL($difficulty, $url) {
		$wordLength;
		switch($difficulty) {
			case("easy"):
				$wordLength = 3;
				break;
			case("medium"):
				$wordLength = 5;
				break;
			case("hard"):
				$wordLength = 8;
				break;		
		}
		$url = $url . "lettersMin=" . $wordLength . "&lettersMax=" . $wordLength;
		return $url;
	}

	/**
	 * Fetches a json containing a randomly generated word from the API, based on the difficulty 
	 * setting. Returns the json.
	 */
	function retrieveRandomWord($url) {
		$response = Unirest\Request::get($url,
				array(
						"X-Mashape-Key" => "xJkqXGguDTmshoNIaGVnrMZlFPmUp1WrnZLjsn8DDx3DFQhNq5",
						"Accept" => "application/json"
				)
		);
		$wordJSON = json_decode($response->raw_body);
		
		//Loose idea for discarding words with low frequency
		/*
		$freq = $wordJSON->{"frequency"};
		if ($freq > 5) return $wordJSON->{"word"};
		else return retrieveNewWord($url);
		*/
		
		return $wordJSON->{"word"};
	}
	
	function setSessionVariables($word) {
		$_SESSION["word"] = $word;
		$_SESSION["chances"] = 7;
		$wordLength = strlen($word);
		for($i = 0; $i < $wordLength; $i++) {
			$_SESSION["char".$i] = "hidden";
		}
	}
	
	function initGraphics($word) {
		$wordLength = strlen($word);
		for($i = 0; $i < $wordLength; $i++) {
			echo "_ ";
		}
		echo '
		<form action="update.php" method="POST"><br>
		Guess: <input type="text" name="guess" maxlength="1"><br>
		<input type="submit" name="update" value="Submit Guess!">
		';
	}
	
	/**
	 * Main method
	 */
	$difficulty = $_POST['difficulty'];
	$url = createURL($difficulty, "https://wordsapiv1.p.mashape.com/words?random=true&");
	$randomWord = retrieveRandomWord($url);
	echo $randomWord . "<br>";
	setSessionVariables($randomWord);
	initGraphics($randomWord);
	
?>