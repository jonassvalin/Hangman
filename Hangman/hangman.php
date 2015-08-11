<?php
require_once(__DIR__.'/unirest-php/src/Unirest.php');
$difficulty = $_POST['difficulty'];
getNewWord();

	/*
	 * Fetches our new word based on the difficulty setting chosen by the player
	 */
	function getNewWord() {
		// These code snippets use an open-source library. http://unirest.io/php
		$response = Unirest\Request::get("https://wordsapiv1.p.mashape.com/words/bump/also",
				array(
						"X-Mashape-Key" => "xJkqXGguDTmshoNIaGVnrMZlFPmUp1WrnZLjsn8DDx3DFQhNq5",
						"Accept" => "application/json"
				)
		);
		echo $response->raw_body;
	}
?>