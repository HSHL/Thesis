<?php

class UserRepository {
    public static function save($user) {
        global $db;
        $stmt = $db->prepare("insert into users (firstname, lastname, email, password_hash, is_advisor) values ("
                . ":firstname,:lastname,:email,:password_hash,:is_advisor)");
        $stmt->bindValue(':firstname', $user->getFirstname(), PDO::PARAM_STR);
        $stmt->bindValue(':lastname', $user->getLastname(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':password_hash', $user->getPasswordHash(), PDO::PARAM_STR);
        $stmt->bindValue(':is_advisor', $user->isAdvisor(), PDO::PARAM_INT);
        $stmt->execute();
    }
    
    public static function getUserByEmail($email) {
        global $db;
        $stmt = $db->prepare("select * from users where email=:email");
        $stmt->bindValue(':email', strtolower($email), PDO::PARAM_STR);
        $stmt->execute();
        
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $obj = User::fromArray($row);
            return $obj;
        } else {
            return NULL;
        }
    }
    
    public static function getUser($id) {
        global $db;
        $stmt = $db->prepare("select * from users where user_id=:id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $obj = User::fromArray($row);
            return $obj;
        } else {
            return NULL;
        }
    }
    
    public static function getStudents() {
        global $db;
        $result = array();
        
        $stmt = $db->prepare("select * from users where is_advisor=0 order by lastname, firstname");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($rows as $row) {
            $result[] = User::fromArray($row);
        }
        
        return $result;
    }
}