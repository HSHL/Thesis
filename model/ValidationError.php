<?php

class ValidationError {
    private $errors = array();
    
    public function hasErrors() {
        return count($this->errors) > 0;
    }
    
    public function addError($error) {
        $this->errors[] = $error;
    }
    
    public function hasError($error) {
        return in_array($error, $this->errors);
    }
}