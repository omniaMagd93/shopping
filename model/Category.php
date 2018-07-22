<?php

class Category extends BaseEntity
{
    public $id;
    public $name;
    
    
    function __construct($conn,$categoryArray) {
        $this->conn = $conn;
        $this->id = $categoryArray['sc_id'];
        $this->name = $categoryArray['sc_name'];
      
        
    }
   
     

}