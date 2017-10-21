<?php
	include_once "db.php";
	DB::update("users", [
		"location" => $_POST["cords"]
	], "id=%s", $_POST["id"]);
	$a = DB::queryFirstRow("SELECT isSomeoneLookingForMe as a, who_is_looking as b from users WHERE id=%s", $_POST["id"]);
	$location = null;
	if ($a["b"]) {
		$location = DB::queryFirstRow("SELECT location FROM users WHERE id=%s", $a["b"])["location"];
	}
	$name = null;
	if ($a["b"]) {
		$name = DB::queryFirstRow("SELECT name FROM users WHERE id=%s", $a["b"])["name"];
	}
	$result = array(
		"isSomeoneLookingForMe" => $a["a"],
		"who_is_looking" => $a["b"],
		"who_is_looking_name" => $name,
		"location" => $location,
	);
	echo json_encode($result);
	if ($a["a"] == 1) {
		DB::update("users", [
			"isSomeoneLookingForMe" => 0,
			"who_is_looking" => null,
			"who_is_looking_name" => null,
			"location" => null,
		], "id=%s", $_POST["id"]);
	}
?>