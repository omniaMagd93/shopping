<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of comments
 *
 * @author omnia
 */
class Comments extends BaseEntity{
    
     public $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function getComments($id)
    {
        $query = "SELECT * FROM comment_rate where scr_product = {$id} ORDER BY scr_createdat  DESC LIMIT " . NO_PER_PAGE;
        $result = $this->conn->query($query);
        $output = array();
        if($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                $output[] = new Comment($this->conn, $row);
            }
        }
        return $output;
    }
}
