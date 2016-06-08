<?php

class UserApi {
    public function getSalt() {
        if (empty($_REQUEST["email"]))
            return;
        
        echo User::getSalt();
    }
}