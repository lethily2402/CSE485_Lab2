<?php
class News
{
    private $id;
    private $title;
    private $content;
    private $image;

    public function __construct($id, $title, $content, $image)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->image = $image;
    }
    public function getId(){
        return $this->id;
    }
    public function getTitle(){
        return $this->title;
    }
    public function getContent(){
        return $this->content;
    }
    public function getImage(){
        return $this->image;
    }
    public function setContent($newContent){
        $this->content = $newContent;
    }
    public function setTitle($newTitle){
        $this->title = $newTitle;
    }
}
