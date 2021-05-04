<?php

class Post
{

    public function getPostsData()
    {
        $query = "SELECT * FROM posts ORDER BY post_id DESC";
        $db = new Database();
        return $db->read($query);
    }

    public function sendPost($userId, $data)
    {
        $post = $data['postcontent'];

        $query = "INSERT INTO posts 
                    (user_id, post, date_of_post, time_of_post) 
                  VALUES 
                    ('$userId', '$post', 'CURRDATE()', 'CURRTIME()')";


        $db = new Database();
        return $db->save($query);
    }

    public function deletePost($post_id)
    {
        $query = "DELETE FROM posts WHERE post_id=$post_id";
        $db = new Database();
        return $db->save($query);
    }
}
