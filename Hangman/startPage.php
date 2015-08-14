<?php
include_once 'hangmanPage.php';

class startPage extends hangmanPage {

	/**
	* Returns the HTML code for the specific content of webpage
	*/
	function getContentHtml() {
		return '<img src="images/duke.jpg" height="250" width="250"><br><br>
		<form action="hangman.php" method="POST">
		Difficulty:
			<select name="difficulty">
			<option value="easy">Piece Of Cake</option>
			<option value="medium">Let\'s Rock</option>
			<option value="hard">Come Get Some</option>
			</select><br><br>
			Start New Game:
			<input type="submit" name="newgame" value="Go!">';
		}

		/**
		* Performs the underlying functionality of the webpage
		*/
		function performPageFunctionality() {
			//I don't need to do nuthin'!
		}
}
?>
