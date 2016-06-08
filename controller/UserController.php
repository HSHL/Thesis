<?php

class UserController {
    public function defaultAction(&$content) {
        $this->showLoginForm($content);
    }
    
    public function showLoginForm(&$content) {
        global $smarty;
        $content .= $smarty->fetch("login.html");
    }
    
    private function loginDataHasErrors(&$content) {
        global $smarty, $current_user;
        
        if ($_REQUEST['email'] == "" || !filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
            $smarty->assign("email", $_REQUEST["email"]);
            $smarty->assign("email_error", 1);
            $content .= $smarty->fetch("login.html");
            return true;
        }
        
        return false;
    }
    
    public function login(&$content) {
        global $smarty;
        
        if ($this->loginDataHasErrors($content))
            return;
        
        $user = UserRepository::getUserByEmail($_REQUEST["email"]);
        if ($user == NULL || !$user->hasPassword($_REQUEST["password"])) {
            $smarty->assign("email", $_REQUEST["email"]);
            $smarty->assign("user_not_found", 1);
            $content .= $smarty->fetch("login.html");
            return;
        }
        
        $_SESSION["user_id"] = $user->getId();
        $current_user = $user;
        $smarty->assign("current_user", $current_user);
        $controller = new TopicController();
        $controller->defaultAction($content);
    }
    
    public function logout(&$content) {
        global $smarty;
        session_unset();
        $smarty->assign("current_user", NULL);
        $controller = new TopicController();
        $controller->defaultAction($content);
    }
    
    public function showSignInForm(&$content) {
        global $smarty;
        $smarty->assign("user", new User());
        $content .= $smarty->fetch("sign_in.html");
    }
    
    public function signIn(&$content) {
        global $smarty;
        
        $user = new User();
        $user->fill($_REQUEST);
        $error = $user->validate();
        
        if ($error->hasErrors()) {
            $smarty->assign("error", $error);
            $smarty->assign("user", $user);
            $content .= $smarty->fetch("sign_in.html");   
            return;
        }
        
        UserRepository::save($user);

        $_SESSION['user_id'] = $user->getId();
        $smarty->assign("current_user", $user);
        $content .= $smarty->fetch("welcome_new_user.html");
    }
}