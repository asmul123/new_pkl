<?php

class Akun_model extends CI_model
{
    public function getAkun($user_id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_id', $user_id);
        return $this->db->get()->row();
    }
}
