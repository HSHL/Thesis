<?php

class Topic {
    private $data;
    
    public function __construct() {
        $data = array(
            "id" => 0,
            "title" => "",
            "description" => "",
            "status" => 0,
            "advisor_id" => 0,
            "publish_date" => date("Y-m-d"),
            "finish_date" => date("Y-m-d"),
            "student_id" => 0
        );
    }
    
    public function getId() {
        return $this->data["id"];
    }
    
    public function setId($value) {
        $this->data["id"] = $value;
    }
    
    public function getTitle() {
        return $this->data["title"];
    }
    
    public function setTitle($value) {
        $this->data["title"] = $value;
    }
    
    public function getDescription() {
        return $this->data["description"];
    }
    
    public function setDescription($value) {
        $this->data["description"] = $value;
    }
    
    public function getStatus() {
        return $this->data["status"];
    }
    
    public function setStatus($value) {
        $this->data["status"] = $value;
    }
    
    public function getPublishDate() {
        return $this->data["publish_date"];
    }
    
    public function setPublishDate($value) {
        $this->data["publish_date"] = $value;
    }
    
    public function getAdvisorId() {
        return $this->data["advisor_id"];
    }
    
    public function setAdvisorId($value) {
        $this->data["advisor_id"] = $value;
    }
    
    public function getFinishDate() {
        return $this->data["finish_date"];
    }
    
    public function setFinishDate($value) {
        $this->data["finish_date"] = $value;
    }
    
    public function getStudentId() {
        return $this->data["student_id"];
    }
    
    public function setStudentId($value) {
        $this->data["student_id"] = $value;
    }
    
    public function toArray() {
        return $this->data;
    }
    
    public function toJson() {
        $userRepo = new UserRepository();
        $advisor = $userRepo->getUser($this->getAdvisorId());
        $student = $userRepo->getUser($this->getStudentId());
        
        $json_array = $data;
        $json_array["advisor"] = $advisor->toArray();
        $json_array["student"] = $student->toArray();
        return json_encode($json_array);
    }
    
    public static function fromArray($row) {
        $obj = new Topic();
        $obj->setId($row['topic_id']);
        $obj->setTitle($row['title']);
        $obj->setDescription($row['description']);
        $obj->setStatus($row['status']);
        $obj->setAdvisorId($row["advisor_id"]);
        $obj->setPublishDate($row["publish_date"]);
        $obj->setFinishDate($row["finish_date"]);
        $obj->setStudentId($row["student_id"]);
        return $obj;
    }
}