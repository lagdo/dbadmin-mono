<?php
function adminer_object() {
	class AdminerPgSQL14 extends Adminer\Adminer {

		function name() {
			// custom name in title and heading
			return 'PostgreSQL 14';
		}

		function credentials() {
			return array('dbadmin-pgsql-14', 'postgres', 'dbadmin');
		}

		function database() {
			// will be escaped by Adminer
			return 'chinook';
		}

		function login($login, $password) {
			// username: 'admin', password: anything
			return ($login == 'dbadmin' /*&& $password == 'dbadmin'*/);
		}

		// function tableName($tableStatus) {
		// 	// tables without comments would return empty string and will be ignored by Adminer
		// 	return Adminer\h($tableStatus["Comment"]);
		// }

		// function fieldName($field, $order = 0) {
		// 	if ($order && preg_match('~_(md5|sha1)$~', $field["field"])) {
		// 		return ""; // hide hashes in select
		// 	}
		// 	// display only column with comments, first five of them plus searched columns
		// 	if ($order < 5) {
		// 		return Adminer\h($field["comment"]);
		// 	}
		// 	foreach ((array) $_GET["where"] as $key => $where) {
		// 		if ($where["col"] == $field["field"] && ($key >= 0 || $where["val"] != "")) {
		// 			return Adminer\h($field["comment"]);
		// 		}
		// 	}
		// 	return "";
		// }
	}

	return new AdminerPgSQL14;
}

$_GET["pgsql"] = ""; // Load the PostgreSQL driver
if (isset($_POST["auth"]) && is_array($_POST["auth"])) {
	$_POST["auth"]["driver"] = "pgsql";
}

include "./index.php";
