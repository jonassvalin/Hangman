<html>
<head>
<title>Duke Hangem' 3D</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	color: red;
    background: black;
}
</style>
</head>
<body>
<h1>Duke Hangem' 3D</h1>
<img src="images/duke.jpg" height="250" width="250"><br>
<form action="initialize.php" method="POST">
	Difficulty: 
	<select name="difficulty">
		<option value="easy">Piece Of Cake</option>
		<option value="medium">Let's Rock</option>
		<option value="hard">Come Get Some</option>
	</select><br>
	Start New Game:
	<input type="submit" name="newgame" value="Go!">
</form>

</body>
</html>