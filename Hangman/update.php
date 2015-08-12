<?php session_start();

$GLOBALS['alphabet'] = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
		"l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "x", "y", "z");
$guess = $_POST["guess"];
$word = $_SESSION["word"];
$wordLength = strlen($word);
$failedAttempts = $_SESSION["failed"];

if (!checkGuess($guess, $word, $wordLength)) $failedAttempts++;
checkStatus($failedAttempts, $word, $wordLength);
updateGraphics($failedAttempts, $word, $wordLength);

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

function checkStatus($failedAttempts, $word, $wordLength) {
	$allCorrect = true;
	for($i = 0; $i < $wordLength; $i++) {
		$char = $_SESSION["char".$i];
		if($char == "hidden") $allCorrect = false;
	}
	
	if($allCorrect) {
		restartGame("You Win!", $word, $failedAttempts);
	} else if ($failedAttempts > 9) {
		restartGame("You Lose!", $word, $failedAttempts);
	}
	
	$_SESSION["failed"] = $failedAttempts;
}

function updateGraphics($failedAttempts, $word, $wordLength) {
	echo '<img src="images/hang' . $failedAttempts . '.gif" height="150" width="150"><br>';
	for($i = 0; $i < $wordLength; $i++) {
		$char = $_SESSION["char".$i];
		if($char == "hidden") echo "_ ";
		else echo $word[$i]." ";
	}
	echo '
		<form action="update.php" method="POST"><br>
		Guess: <input type="text" name="guess" maxlength="1"><br>
		<input type="submit" name="update" value="Submit Guess!"><br><br>
			Used characters:  
		';
	$alphabet = $GLOBALS['alphabet'];
	foreach ($alphabet as $letter) {
		if($_SESSION[$letter] == "used") echo $letter . " ";
	}
}

function restartGame($output, $word, $failedAttempts) {
	echo '<img src="images/hang' . $failedAttempts . '.gif" height="150" width="150"><br>';
	session_destroy();
	echo $output . " The correct answer was: " . $word;
	echo '
		<form action="index.php" method="POST"><br>
		<input type="submit" name="restart" value="Restart Game?">
		';
	exit();
}

?>