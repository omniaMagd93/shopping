<?php
use PHPUnit\Framework\TestCase;

include "./Fakedb.php";
include '../model/BaseEntity.php';
include "./User.php";


class UserTest extends TestCase{

	public $user;


 
	public function setUp(){
      $this->user->username = "Omnia Magd";
      $this->user->name = "Omnia Magd";
      $this->user->password = "Omnia pass";
      $this->user->type = "female";
      $this->user->photo = "Omnia Photo";
      $this->user->email = "Omnia Email";
	}

	public function tearDown(){
		$this->user = NULL;
	}

	public function testSave()
	{
		$result = $this->user->save();
		 $this->assertEquals(true, $result);
	}

	public function testUpdate()
	{
		$result = $this->user->update();
		 $this->assertEquals(true, $result);
	}
        
        public function testDeleteUSer()
        {
            $result = $this->user->deleteUser(2);
		 $this->assertEquals(true, $result);
        }
        
        public function testIsAdmin()
        {
            $result = $this->user->IsAdmin(1);
		 $this->assertEquals(true, $result);
        }
}