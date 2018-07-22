<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Comments
 *
 * @author omnia
 */
class Comment extends BaseEntity{
    //put your code here
    
    public $id;
    public $comment;
    public $userId;
    public $rate;
    public $product;
    public $createdAt;

    public function __construct($conn, $commentArray = false)
    {
        $this->conn = $conn;
        $this->id = $commentArray['scr_id'];
        $this->comment = $commentArray['scr_comment'];
        $this->userId = new User($this->conn, $commentArray['scr_user']);
        $this->rate = $commentArray['scr_rate'];
        $this->product = $commentArray['scr_product'];
        $this->createdAt = $commentArray['scr_createdat'];
    }
    
      public function save() {
             
        $query = "INSERT INTO `comment_rate` (`scr_user`,`scr_comment`, `scr_rate`, `scr_product`,`scr_createdat`) "
                . "VALUES ('{$this->getUserId()}', '{$this->getComment()}', '{$this->getRate()}', '{$this->getProduct()}', '{$this->getCreatedAt()}');";

        mysqli_query($this->conn, $query) or die(mysqli_error($this->conn));
        $this->id = mysqli_insert_id($this->conn);
        return $this->id;
    }
}
