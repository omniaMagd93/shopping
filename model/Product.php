<?php

class Product extends BaseEntity
{
    public $id;
    public $name;
    public $category;
    public $price;
    public $description;
    public $image;
    
    function __construct($conn,$productArray = false) {
        $this->conn = $conn;
        $this->id = $productArray['sp_id'];
        $this->name = $productArray['sp_name'];
        $this->price = $productArray['sp_price'];
        $this->description = $productArray['sp_description'];
        $this->image = $productArray['sp_image'];
        $this->category = $productArray['sp_category'];
        
    }
    
    function insertProduct()
    { 
        
        $query = "INSERT INTO `product` (`sp_name`, `sp_description`, `sp_price`,`sp_category`,`sp_image`)VALUES ('{$this->getName()}', '{$this->getDescription()}','{$this->getPrice()}','{$this->getCategory()}','{$this->getImage()}')";
        $result = $this->conn->query($query);
        return $result;
    }
   
    
    function updateproduct()
    {
      
        $query = "UPDATE `product` SET `sp_name` = '{$this->getName()}', `sp_description` = '{$this->getDescription()}', `sp_price` = '{$this->getPrice()}',`sp_category` = '{$this->getCategory()}',`sp_image` = '{$this->getImage()}' WHERE `sp_id`= '{$this->getId()}'";
     
        $result = $this->conn->query($query);
     
        return $result;
    }     

}