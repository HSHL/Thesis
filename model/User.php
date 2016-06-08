<?php

class User {
    private $data;
    
    public function __construct() {
        $data = array(
            "id" => 0,
            "firstname" => "",
            "lastname" => "",
            "email" => "",
            "study" => "",
            "password_hash" => "",
            "is_advisor" => 0
        );
    }
    
    public static function getSalt() {
        return "oc1zYC4UJlM9NLD815bQ18GXUFctLbZ3";
    }
    
    public function getId() {
        return $this->data["user_id"];
    }
    
    public function setId($value) {
        $this->data["user_id"] = $value;
    }
    
    public function getFirstname() {
        return $this->data["firstname"];
    }
    
    public function setFirstname($value) {
        $this->data["firstname"] = trim($value);
    }
    
    public function getLastname() {
        return $this->data["lastname"];
    }
    
    public function setLastname($value) {
        $this->data["lastname"] = trim($value);
    }
    
    public function getEmail() {
        return $this->data["email"];
    }
    
    public function setEmail($value) {
        $this->data["email"] = strtolower(trim($value));
    }
    
    public function getPasswordHash() {
        return $this->data["password_hash"];
    }
    
    public function hasPassword($value) {
        return hash('sha256', User::getSalt() . $value) === $this->data["password_hash"];
    }
    
    public function setPasswordHash($value) {
        $this->data["password_hash"] = $value;
    }
    
    public function setPassword($value) {
        $this->data["password_hash"] = hash('sha256', User::getSalt() . $value);
    }
    
    public function getStudy() {
        return $this->data["study"];
    }
    
    public function setStudy($value) {
        $this->data["study"] = $value;
    }
    
    public function isAdvisor() {
        return $this->data["is_advisor"] == 1;
    }
    
    public function setAdvisor($value) {
        $this->data["is_advisor"] = $value;
    }
    
    public function fill($array) {
        $this->data["user_id"] = isset($array["user_id"]) ? $array["user_id"] : 0;
        $this->data["firstname"] = isset($array["firstname"]) ? $array["firstname"] : "";
        $this->data["lastname"] = isset($array["lastname"]) ? $array["lastname"] : "";
        $this->data["email"] = isset($array["email"]) ? $array["email"] : "";
        $this->data["password"] = isset($array["password"]) ? $array["password"] : "";
        $this->data["password_hash"] = isset($array["password_hash"]) ? $array["password_hash"] : "";
        $this->data["password_repeat"] = isset($array["password_repeat"]) ? $array["password_repeat"] : "";
        $this->data["study"] = isset($array["study"]) ? $array["study"] : "";
        $this->data["is_advisor"] = isset($array["is_advisor"]) ? $array["is_advisor"] : 0;
        
        if (isset($array["password"])) {
            $this->setPassword($array["password"]);
        }
    }
    
    public function validate() {
        $error = new ValidationError();

        if (empty($this->data["firstname"])) {
            $error->addError("firstname_empty");
        }
        
        if (empty($this->data["lastname"])) {
            $error->addError("lastname_empty");
        }
        
        if (empty($this->data["email"])) {
            $error->addError("email_empty");
        } else if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
            $error->addError("email_invalid");
        } else {
            $user = UserRepository::getUserByEmail($this->data["email"]);
            if ($user != NULL) {
                $error->addError("email_exists");
            }
        }
        
        if (empty($this->data["password"])) {
            $error->addError("password_empty");
        } else if (empty($this->data["password_repeat"])) {
            $error->addError("password_repeat_empty");
        } else if ($this->data["password"] != $this->data["password_repeat"]) {
            $error->addError("password_repeat_not_equal");
        } else if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,50}$/', $this->data["password"])) {
            $error->addError("password_not_valid");
        }
        
        return $error;
    }
    
    public static function fromArray($row) {
        $obj = new User();
        $obj->fill($row);
        return $obj;
    }
}