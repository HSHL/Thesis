<?php

class TopicController {
    public function defaultAction(&$content) {
        $this->showOpenTopics($content);
    }
    
    public function showOpenTopics(&$content) {
        $order_by = isset($_REQUEST['order_by']) ? $_REQUEST['order_by'] : "publish_date";
        $topics = TopicRepository::getOpenTopics($order_by);
        
        global $smarty;
        $smarty->assign("topics", $topics);
        $content .= $smarty->fetch("open_topics.html");
    }
    
    public function showFinishedTopics(&$content) {
        $order_by = isset($_REQUEST['order_by']) ? $_REQUEST['order_by'] : "publish_date";
        $topics = TopicRepository::getFinishedTopics($order_by);
        
        global $smarty;
        $smarty->assign("topics", $topics);
        $content .= $smarty->fetch("finished_topics.html");
    }
    
    public function showMyTopics(&$content) {
        global $current_user, $smarty;
        
        if ($current_user == NULL) {
            $smarty->assign("error_msg", "Sie müssen eingeloggt sein, um Ihre Arbeiten zu sehen!");
            $content .= $smarty->fetch("error.html");
            return;
        }
        
        if ($current_user->isAdvisor()) {
            $order_by = isset($_REQUEST["order_by"]) ? $_REQUEST["order_by"] : "publish_date";
            $topics = TopicRepository::getTopicsOfAdvisor($current_user, $order_by);
            $smarty->assign("topics", $topics);
            $content .= $smarty->fetch("topics_of_advisor.html");
        } else {
            $order_by = isset($_REQUEST["order_by"]) ? $_REQUEST["order_by"] : "publish_date";
            $topics = TopicRepository::getTopicsOfStudent($current_user, $order_by);
            $smarty->assign("topics", $topics);
            $content .= $smarty->fetch("topics_of_student.html");
        }
    }
    
    public function showTopic(&$content) {
        if (!isset($_REQUEST["id"])) {
            $this->defaultAction($content);
            return;
        }
        
        $topic = TopicRepository::getTopic($_REQUEST["id"]);
        
        if ($topic == NULL) {
            $this->defaultAction ($content);
            return;
        }
        
        $advisor = $topic->getAdvisorId() != 0 ? UserRepository::getUser($topic->getAdvisorId()) : NULL;
        $student = $topic->getStudentId() != 0 ? UserRepository::getUser($topic->getStudentId()) : NULL;
                
        global $smarty;
        $smarty->assign("topic", $topic);
        $smarty->assign("advisor", $advisor);
        $smarty->assign("student", $student);
        $content .= $smarty->fetch("show_topic.html");
    }
    
    public function editTopic(&$content) {
        global $current_user, $smarty;
        
        if (!isset($_REQUEST["id"]) || $_REQUEST["id"] <= 0) {
            return;
        }
        
        $topic = TopicRepository::getTopic($_REQUEST["id"]);
        
        if ($current_user == null || $current_user->getId() != $topic->getAdvisorId()) {
            return;
        }
        
        $students = UserRepository::getStudents();

        $smarty->assign("topic", $topic);
        $smarty->assign("students", $students);
        $content .= $smarty->fetch("edit_topic.html");
    }
    
    public function saveTopic(&$content) {
        global $current_user, $smarty;
        
        if ($current_user == null || !$current_user->isAdvisor()) {
            return;
        }
        
        $topic = Topic::fromArray($_REQUEST);
        $topic->setAdvisorId($current_user->getId());
        
        if (empty($topic->getTitle())) {
            $smarty->assign("error", 1);
            $smarty->assign("title_error", 1);
            $smarty->assign("topic", $topic);
            $smarty->assign("students", UserRepository::getStudents());
            $content .= $smarty->fetch("edit_topic.html");
            return;
        }
        
        if ($_REQUEST["status"] > 0 && $_REQUEST["student_id"] == 0) {
            $smarty->assign("error", 1);
            $smarty->assign("student_error", 1);
            $smarty->assign("topic", $topic);
            $smarty->assign("students", UserRepository::getStudents());
            $content .= $smarty->fetch("edit_topic.html");
            return;            
        }
        
        TopicRepository::saveTopic($topic);
        $this->defaultAction($content);
    }
    
    public function newTopic(&$content) {
        global $current_user, $smarty;
        
        if ($current_user == null || !$current_user->isAdvisor()) {
            return;
        }
        
        $topic = new Topic();
        $smarty->assign("new_topic", 1);
        $smarty->assign("topic", $topic);
        $smarty->assign("students", UserRepository::getStudents());
        $content .= $smarty->fetch("edit_topic.html");
    }
    
    public function deleteTopic(&$content) {
        global $current_user, $smarty;
        
        if ($current_user == null || !$current_user->isAdvisor()) {
            return;
        }
        
        $topic = TopicRepository::getTopic($_REQUEST["id"]);
        if ($topic->getAdvisorId() != $current_user->getId()) {
            return;
        }
        
        TopicRepository::deleteTopic($topic);
        $this->defaultAction($content);
    }
    
    public function applyTopic(&$content) {
        
    }
}
