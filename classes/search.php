<?php

class Search {

    public function searchUser($data) {
        $searchInput = $data['searchinput'];

        $query = "SELECT * FROM user WHERE
                    first_name LIKE '%$searchInput' ||
                    last_name LIKE '%$searchInput'";
        $db = new Database();
        return $db->read($query);
    }
}
