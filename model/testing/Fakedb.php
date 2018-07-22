<?php 


class Fakedb{

	public $num_rows = 1;
	public $insert_id = 1;


	public function query($str){
		return $this;
	}

	public function fetch_assoc(){

		return [
			[
				"id" => 1,
				"username" => "omnia magd",
				"name" => "omnia magd",
				"type" => "female",
				"photo" => "omnia photo",
				"email" => "omnia email",
			],
			[
				"id" => 2,
				"username" => "omnia magd2",
				"name" => "omnia magd2",
				"type" => "female",
				"photo" => "omnia photo2",
				"email" => "omnia email2",
			],
		];
	}
	
}