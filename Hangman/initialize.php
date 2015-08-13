<?php session_start();
include 'Unirest.php';
include 'graphics.php';

/**
* Main operations
*/
$GLOBALS['alphabet'] = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
"l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "x", "y", "z");
$difficulty = $_POST['difficulty'];
$url = createURL($difficulty, "https://wordsapiv1.p.mashape.com/words?random=true&");
$randomWord = retrieveRandomWord($url);
setSessionVariables($randomWord);
initGraphics($randomWord);

/**
* Defines the URL to call the Words API based on the difficulty setting.
*/
function createURL($difficulty, $url) {
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
function retrieveRandomWord($url) {
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
		return $wordJSON->{"word"};
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
function setSessionVariables($word) {
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

/**
* Initializes the graphics for the hangman game. Submit button will POST
* the update.php.
*/
function initGraphics($word) {
	echo getIntroHtml();
	echo '<img src="images/hang0.gif" height="190" width="190"><br>';
	$wordLength = strlen($word);
	for($i = 0; $i < $wordLength; $i++) {
		echo "_ ";
	}
	echo '
	<form action="update.php" method="POST"><br>
	Guess: <input type="text" name="guess" maxlength="1"><br><br>
	<input type="submit" name="update" value="Submit Guess!"><br><br>
	Used characters:
	';
	echo getOutroHtml();
}

?>
