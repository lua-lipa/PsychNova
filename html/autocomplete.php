<?php
include("../classes/connect.php");

if (isset($_POST['query'])) {
    $query = "SELECT * FROM organisation WHERE name LIKE '%" . $_POST['query'] . "%'";

    $db = new Database();
    $result = $db->read($query);
    if ($result) {
        foreach ($result as $row) {
          echo '<a href="#" value="' . $row['org_id'] . '" class="list-group-item list-group-item-action border-1">' . $row['name'] . '</a>';
        }
      } else {
        echo '<p class="list-group-item border-1">No Record</p>';
      }
    }

?>