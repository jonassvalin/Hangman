<?php session_start();
include 'graphics.php';

/**
* Main operations
*/
$GLOBALS['alphabet'] = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
		"l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "x", "y", "z");
$guess = $_POST["guess"];
$word = $_SESSION["word"];
$wordLength = strlen($word);
$failedAttempts = $_SESSION["failed"];
if (!checkGuess($guess, $word, $wordLength)) $failedAttempts++;
checkStatus($failedAttempts, $word, $wordLength);
updateGraphics($failedAttempts, $word, $wordLength);

/**
* Checks whether the guessed character is contained within the word.
* Returns true if it was, otherwise false.
*/
function checkGuess($guess, $word, $wordLength) {
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
function checkStatus($failedAttempts, $word, $wordLength) {
	$allCorrect = true;
	for($i = 0; $i < $wordLength; $i++) {
		$char = $_SESSION["char".$i];
		if($char == "hidden") $allCorrect = false;
	}

	if($allCorrect) {
		finishGame("You Win!", $word, $failedAttempts);
	} else if ($failedAttempts > 9) {
		finishGame("You Lose!", $word, $failedAttempts);
	}

	$_SESSION["failed"] = $failedAttempts;
}

/**
* Updates the visuals to represent the current state of the game.
*/
function updateGraphics($failedAttempts, $word, $wordLength) {
	echo getIntroHtml();
	echo '<img src="images/hang' . $failedAttempts . '.gif" height="190" width="190"><br>';
	for($i = 0; $i < $wordLength; $i++) {
		$char = $_SESSION["char".$i];
		if($char == "hidden") echo "_ ";
		else echo $word[$i]." ";
	}
	echo '
		<form action="update.php" method="POST"><br>
		Guess: <input type="text" name="guess" pattern=".{1,1}"   required title="1 characters minimum"><br><br>
		<input type="submit" name="update" value="Submit Guess!"><br><br>
			Used characters:
		';
	$alphabet = $GLOBALS['alphabet'];
	foreach ($alphabet as $letter) {
		if($_SESSION[$letter] == "used") echo $letter . " ";
	}
	echo getOutroHtml();
}

/**
* Finishes the game, displays the correct word and inquiries the player if
* he/she would like to play again.
*/
function finishGame($output, $word, $failedAttempts) {
	echo getIntroHtml();
	echo '<img src="images/hang' . $failedAttempts . '.gif" height="190" width="190"><br><br>';
	session_destroy();
	echo $output . ' The correct answer was: <b>' . $word . '</b>';
	echo '
		<form action="index.php" method="POST"><br>
		<input type="submit" name="restart" value="Restart Game?"><br><br><br><br>
		';
	echo getOutroHtml();
	exit();
}

?>
