<?php
	class ViewController
	{
		
		function __construct()
		{
			return ;
		}

		static function overview() {
			$data = array(
				"title" => "Simple HTML Editor | Overview",
				"data" => array(
					array("id" => 1, "title" => "This is the first title"),
					array("id" => 2, "title" => "This is the second title"),
					array("id" => 3, "title" => "This is the third title")
				)
			);
			return array(
				"file" => "overview.html",
				"data" => $data
			);
		}

		static function edit() {
			return array(
				"file" => "edit.html",
				"data" => array(
					"title" => "Simple HTML Editor | Edit"
				)
			);
		}
	}
?>