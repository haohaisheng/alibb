<?php
require_once(dirname(__FILE__) . '/../AndroidNotification.php');

class AndroidUnicast extends AndroidNotification {
	function __construct() {
		parent::__construct();
		$this->data["type"] = "customizedcast";
		//$this->data["device_tokens"] = NULL;
	}

}