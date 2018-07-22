<?php

class Products extends BaseEntity
{

    public $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

   public function getProducts()
    {   
        $query = "SELECT * FROM product";
        $result = $this->conn->query($query);
        $output = array();
        if($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                $output[] = new Product($this->conn, $row);
              
            }
        }
        return $output;
    }
    
     public function filter($cat)
    {
        // console.log("in filter db");
//         echo "in filter";
//         die();
        if($cat == "no")
        {
           // console.log("in cat = 0");
         $query = "SELECT * FROM product"; 
        
        }
        else
        {
        $query = "SELECT * FROM product WHERE sp_category = {$cat}";
        }
        $result = $this->conn->query($query);
        $output = array();
        if($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                $output[] = $row;
            }
        }
        return $output;
    }
    
    public function search($keyword)
    {
         $query = "SELECT * FROM product WHERE sp_name like '%{$keyword}%'";
        $result = $this->conn->query($query);
        $output = array();
        if($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                $output[] = new Product($this->conn, $row);
            }
        }
        return $output;
    }
    
       public function getproductsNew()
    {   
        $query = "SELECT * FROM product";
        $result = $this->conn->query($query);
        $output = array();
        if($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                $output[] = $row;
            }
        }
        return $output;
    }
    
          public function getproductsByID($id)
    {   
        $query = "SELECT * FROM product WHERE sp_id = {$id}";
        $result = $this->conn->query($query);
        $output = array();
        if($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
              $output[] = new Product($this->conn, $row);
            }
        }
        return $output;
    }
    
     public function getproductsByIDV2($id)
    {   
        $query = "SELECT * FROM product WHERE sp_id = {$id}";
        $result = $this->conn->query($query);
        $output = array();
        if($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {  
               $output = $row;
               
            }
        }
        return $output;
    }
    
    
    function deleteProduct($proid)
    {
        $query = "DELETE FROM `product` WHERE sp_id={$proid}";
        $result = $this->conn->query($query);
        return $result ;
    }

}

