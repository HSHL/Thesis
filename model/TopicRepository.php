<?php

class TopicRepository {
    public static function getTopic($id) {
        global $db;
        $stmt = $db->prepare("select * from topics where topic_id=:id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $obj = Topic::fromArray($row);
            return $obj;
        } else {
            return NULL;
        }        
    }
    
    public static function getOpenTopics($order_by = "publish_date", $page = 0) {
        global $db;
        $result = array();
        
        $stmt = $db->prepare("select * from topics,users where topics.advisor_id=users.user_id and "
                . "status=0 order by :order limit :limit,10");
        $stmt->bindValue(':order', $order_by, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $page*10, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($rows as $row) {
            $topic = Topic::fromArray($row);
            $advisor = User::fromArray($row);
            $result[] = array("topic" => $topic, "advisor" => $advisor);
        }
        
        return $result;
    }
    
    public static function getFinishedTopics($order_by = "publish_date", $page = 0) {
        global $db;
        $result = array();
        
        $stmt = $db->prepare("select * from topics,users where topics.student_id=users.user_id and "
                . "status=100 order by :order limit :limit,10");
        $stmt->bindValue(':order', $order_by, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $page*10, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($rows as $row) {
            $topic = Topic::fromArray($row);
            $student = User::fromArray($row);
            $result[] = array("topic" => $topic, "student" => $student);
        }
        
        return $result;
    }
    
    public static function getTopicsOfAdvisor($advisor, $order_by = "publish_date", $page = 0) {
        global $db;
        $result = array();
        
        $stmt = $db->prepare("select * from topics where advisor_id=:advisor_id order by :order limit :limit,10");
        $stmt->bindValue(':advisor_id', $advisor->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':order', $order_by, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $page*10, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($rows as $row) {
            $result[] = Topic::fromArray($row);
        }
        
        return $result;
    }
    
    public static function getTopicsOfStudent($student, $order_by = "publish_date", $page = 0) {
        global $db;
        $result = array();
        
        $stmt = $db->prepare("select * from topics where student_id=:student_id order by :order limit :limit,10");
        $stmt->bindValue(':student_id', $student->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':order', $order_by, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $page*10, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($rows as $row) {
            $result[] = Topic::fromArray($row);
        }
        
        return $result;
    }
    
    public static function saveTopic($topic) {
        global $db;
        
        if ($topic->getId() == 0) {
            $stmt = $db->prepare("insert into topics (title, description, status, "
                    . "advisor_id, publish_date, finish_date, student_id) values ("
                    . ":title,:description,:status,:advisor_id,:publish_date,:finish_date,:student_id)");
        } else {
            $stmt = $db->prepare("update topics set title=:title,description=:description,status=:status,"
                    . "advisor_id=:advisor_id,publish_date=:publish_date,finish_date=:finish_date,student_id=:student_id"
                    . " where topic_id=:topic_id");
            $stmt->bindValue(":topic_id", $topic->getId(), PDO::PARAM_INT);
        }
        
        $stmt->bindValue(':title', $topic->getTitle(), PDO::PARAM_STR);
        $stmt->bindValue(':description', $topic->getDescription(), PDO::PARAM_STR);
        $stmt->bindValue(':status', $topic->getStatus(), PDO::PARAM_INT);
        $stmt->bindValue(':advisor_id', $topic->getAdvisorId(), PDO::PARAM_INT);
        $stmt->bindValue(':publish_date', $topic->getPublishDate(), PDO::PARAM_STR);
        $stmt->bindValue(':finish_date', $topic->getFinishDate(), PDO::PARAM_STR);
        $stmt->bindValue(':student_id', $topic->getStudentId(), PDO::PARAM_INT);
        $stmt->execute();
    }
    
    public static function deleteTopic($topic) {
        global $db;
        
        $stmt = $db->prepare("delete from topics where topic_id=:topic_id");
        $stmt->bindValue(":topic_id", $topic->getId(), PDO::PARAM_INT);
        $stmt->execute();
    }
}