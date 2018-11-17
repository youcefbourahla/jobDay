<?php
class Menu
{
    private $id;
    private $title;
    private $description;
    private $parentId;
    private $active;


    function __construct( $id, $title, $description, $parentId, $active )
    {
      $this->id = $id;
      $this->title = $title;
      $this->description = $description;
      $this->parentId = $parentId;
      $this->active = $active;
    }

    public function getId() {
      return $this->id;
    }
    public function setId($id) {
      $this->id = $id;
    } 

    public function getTitle() {
      return $this->title;
    }
    public function setTitle($title) {
      $this->title = $title;
    } 

    public function getDescription() {
      return $this->description;
    }
    public function setDescription($description) {
      $this->description = $description;
    } 

    public function getParentId() {
      return $this->parentId;
    }
    public function setParentId($parentId) {
      $this->parentId = $parentId;
    } 

    public function getActive() {
      return $this->active;
    }
    public function setActive($active) {
      $this->active = $active;
    } 
}