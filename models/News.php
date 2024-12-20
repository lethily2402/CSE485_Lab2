<?php
class News
{
    private $id;
    private $title;
    private $content;
    private $image;
    private $categoryId;
    private $categoryName;
    private $createdAt;

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param mixed $categoryId
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }

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
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;
    }

    public function getCategoryName()
    {
        return $this->categoryName;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
