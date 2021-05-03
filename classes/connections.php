<?php

class connections
{

    public function getPendingConnections($userid)
    {
        $query = "SELECT connection_id, user_inviter FROM connection WHERE state='pending' AND user_invited = $userid ORDER BY connection_id DESC";
        $db = new Database();
        return $db->read($query);
    }

    public function acceptPendingConnection($connectionid)
    {
        $query = "UPDATE connection SET state = 'accepted' WHERE connection_id = $connectionid";
        $db = new Database();
        return $db->save($query);
    }

    public function rejectPendingConnection($connectionid)
    {
        $query = "DELETE FROM connection WHERE connection_id = $connectionid";
        $db = new Database();
        return $db->save($query);
    }

    public function getUserConnections($userid)
    {
        $query = "SELECT * FROM connection WHERE (user_invited = $userid OR user_inviter = $userid) AND state = 'accepted'";
        $db = new Database();
        return $db->read($query);
    }

    public function getNumberOfPendingConnections($userid)
    {
        $query = "SELECT COUNT(*) FROM connection WHERE user_invited = $userid";
        $db = new Database();
        return $db->read($query);
    }

    public function getNumberOfConnections($userid)
    {
        $query = "SELECT COUNT(*) FROM connection WHERE user_invited = $userid OR user_inviter = $userid";
        $db = new Database();
        return $db->read($query);
    }

    public function areConnected($user_a_id, $user_b_id)
    {
        $query = "SELECT connection_id FROM connection WHERE ((user_invited = $user_a_id AND user_inviter = $user_b_id) OR (user_invited = $user_b_id AND user_inviter = $user_a_id))";
        $db = new Database();
        return $db->read($query);
    }

    public function sendConnectionRequest($from_user_id, $to_user_id)
    {
        $query = "INSERT INTO connection(user_inviter, user_invited, state) VALUES ($from_user_id, $to_user_id, 'pending')";
        $db = new Database();
        return $db->read($query);
    }
}
