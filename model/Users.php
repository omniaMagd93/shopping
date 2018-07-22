<?php

class Users extends BaseEntity
{

    public $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

   public function getUser($pass,$username)
    {   
      
        $query = "SELECT * FROM user where su_password = {$pass} and su_username = '{$username}'";
    
        $result = $this->conn->query($query);
        $output =array() ;
        if($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
             $output[] =  new User($this->conn, $row['su_id']);
            }
        }
        return $output;
    }
    
     public function getUserName($id)
     {
      $query = "SELECT su_username FROM user where su_id = {$id}";
    
        $result = $this->conn->query($query);
      
        $output ;
        if($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
             $output = $row['su_username'];
            }
        }
        return $output;   
     }
}
?>