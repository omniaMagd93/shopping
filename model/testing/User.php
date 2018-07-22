<?php

class User extends BaseEntity {

    public $id;
    public $username;
    public $name;
    public $password;
    public $type;
    public $photo;
    public $email;
    

    function __construct($conn, $userId = false) {

        $this->conn = $conn;
        if ($userId) {

            $query = "SELECT * FROM user WHERE su_id={$userId}";

            $result = $this->conn->query($query);
            if ($result->num_rows > 0) {
                // output data of each row
                $row = $result->fetch_assoc();
                
                $this->id = $row['su_id'];
                $this->username = $row['su_username'];
                $this->name = $row['su_name'];
                $this->type = $row['su_type'];
                $this->photo = $row['su_photo'];
                $this->email = $row['su_email'];
                
            } 
        }
    }

    public function save() {

        
        $query = "INSERT INTO `user` (`su_name`, `su_username`, `su_photo`, `su_email`, `su_password`,`su_type`) "
                . "VALUES ('{$this->getUsername()}', '{$this->getUsername()}', '{$this->getPhoto()}', '{$this->getEmail()}', '{$this->getPassword()}', '2');";
          
        $result = $this->conn->query($query);
      

        if($this->conn->num_rows != 0)
        {
              $this->id = $this->conn->insert_id;
            return true;
        }else
        {
            return false;
        }
    }

    public function update() {

        $query = "UPDATE `user` SET `su_photo` = '{$this->getPhoto()}',`su_name` = '{$this->getName()}',`su_email` = '{$this->getEmail()}',`su_username` = '{$this->getUsername()}',`su_password` = '{$this->getPassword()}' WHERE `su_id` = '{$this->getId()}'";

       $this->conn->query($query);
       return $this->conn->num_rows ? true : false ;
    }

     public function deleteUser($UserId)
     {
       $query = "DELETE FROM `user` WHERE id = '{$UserId}'";
       $this->conn->query($query);
       return $this->conn->num_rows ? true : false ;
     }

     public function IsAdmin($UserId)
     {
       $query = "SELECT `su_type` FROM `user` WHERE id = '{$UserId}'";
       $this->conn->query($query);
       return $this->conn->num_rows ? true : false ;
     }



}
