<?php

$dir = "";

$messages = array();

switch($_REQUEST['type']) {
	case "draft":
		$dir = __DIR__ . DIRECTORY_SEPARATOR . "drafts";
		break;
	case "sent":
		$dir = __DIR__ . DIRECTORY_SEPARATOR . "sent";
		break;
}

if ($dh = opendir($dir)) {
	while (false !== ($entry = readdir($dh))) {
		if ( ($entry !== ".") || ($entry !== "..") ) {
			$messages[] = array(
				"url" => $entry,
				"title" => $entry
			);
		}
	}
}

header("content-type:text/json");

echo json_encode($messages);