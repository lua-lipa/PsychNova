<?php

class Post {

    public function getData() {
        $query = "SELECT * FROM posts";
        $db = new Database();
        return $db->read($query);
    }

    public function sendPost($userId, $data) {
        $post = $data['postcontent'];

        $query = "INSERT INTO posts 
                    (post_id, user_id, post, date_of_post, time_of_post) 
                  VALUES 
                    ('126', '$userId', '$post', 'CURRDATE()', 'CURRTIME()')"; 


        $db = new Database();
        return $db->save($query);
    }

}