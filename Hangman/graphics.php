<?php

/**
* Returns the HTML code for the header/beginning of webpage
*/
function getIntroHtml() {
		return '
		<html>
		<head>
		<title>Duke Hangem\' 3D</title>
		<link href="style.css" rel="stylesheet" type="text/css" />
		</head>
		<body>
		<div id="container">
		<div id="header">
		<h1>Duke Hangem\' 3D</h1>
		</div>
		<div id="content">';
}

/**
* Returns the HTML code for the footer/end of webpage
*/
function getOutroHtml() {
	return '</div>
	<div id="footer">
	<i>"It\'s time to guess words and chew bubble gum, and I\'m all out of gum"</i> - Duke Hangem\'
	</div>
	</div>
	</body>
	</html>';
}
?>
