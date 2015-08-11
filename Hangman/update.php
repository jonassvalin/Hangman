<?php session_start();

$guess = $_POST["guess"];
$word = $_SESSION["word"];
$wordLength = strlen($word);
$chancesLeft = $_SESSION["chances"];

if (!checkGuess($guess, $word, $wordLength)) $chancesLeft--;
checkStatus($chancesLeft, $wordLength);
updateGraphics($chancesLeft, $word, $wordLength);

function checkGuess($guess, $word, $wordLength) {
	$correctGuess = false;
	for($i = 0; $i < $wordLength; $i++) {
		if($word[$i] == $guess) {
			$_SESSION["char".$i] = "found";
			$correctGuess = true;
		}
	}
	return $correctGuess;
}

function checkStatus($chancesLeft, $wordLength) {
	$allCorrect = true;
	for($i = 0; $i < $wordLength; $i++) {
		$char = $_SESSION["char".$i];
		if($char == "hidden") $allCorrect = false;
	}
	
	if($allCorrect) {
		echo "You Win!";
		exit();
	} else if ($chancesLeft < 1) {
		echo "You Lose!";
		exit();
	}
	
	$_SESSION["chances"] = $chancesLeft;
}

function updateGraphics($chancesLeft, $word, $wordLength) {
	echo "Chances left: " . $chancesLeft . "<br>";
	for($i = 0; $i < $wordLength; $i++) {
		$char = $_SESSION["char".$i];
		if($char == "hidden") echo "_ ";
		else echo $word[$i]." ";
	}
	echo '
		<form action="update.php" method="POST"><br>
		Guess: <input type="text" name="guess" maxlength="1"><br>
		<input type="submit" name="update" value="Submit Guess!">
		';
}

?>