<html>
<head>
<title>Super Hangman 64</title>
<link href="style.css" rel="stylesheet" type="text/css"> 
<body>
<h1>Super Hangman 64</h1>
<form action="hangman.php" method="POST">
	Difficulty: 
	<select name="difficulty">
		<option value="easy">Piece of Cake</option>
		<option value="medium">Let's Rock</option>
		<option value="hard">Come Get Some</option>
	</select><br>
	Start New Game:
	<input type="submit" name="newgame" value="Go!">
</form>

</body>
</head>
</html>