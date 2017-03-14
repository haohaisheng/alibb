<?php
require_once(dirname(__FILE__) . '/../IOSNotification.php');

class IOSUnicast extends IOSNotification {
	function __construct() {
		parent::__construct();
		$this->data["type"] = "customizedcast";
		//$this->data["device_tokens"] = NULL;
	}

}