<?php
include 'graphics.php';

echo getIntroHtml();
echo '<img src="images/duke.jpg" height="250" width="250"><br><br>
			<form action="initialize.php" method="POST">
				Difficulty:
				<select name="difficulty">
					<option value="easy">Piece Of Cake</option>
					<option value="medium">Let\'s Rock</option>
					<option value="hard">Come Get Some</option>
				</select><br><br>
				Start New Game:
				<input type="submit" name="newgame" value="Go!">';
echo getOutroHtml();
?>
