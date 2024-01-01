<?php

class Kaprog_model extends CI_model
{
    public function getBioKaprog($email)
    {
        $this->db->select('*');
        $this->db->from('kaprogs');
        $this->db->join('users', 'users.user_id = kaprogs.user_id');
        $this->db->join('majors', 'majors.major_id = kaprogs.major_id');
        $this->db->join('roles', 'roles.role_id = users.role_id');
        $this->db->where('email', $email);
        return $this->db->get()->row();
    }

    public function getKaprogs()
    {
        $this->db->select('*');
        $this->db->from('kaprogs');
        $this->db->join('majors', 'majors.major_id = kaprogs.major_id');
        $this->db->join('users', 'users.user_id = kaprogs.user_id');
        return $this->db->get()->result();
    }

    public function getThisKaprog($kaprogID)
    {
        $this->db->select('*');
        $this->db->from('kaprogs');
        $this->db->join('majors', 'majors.major_id = kaprogs.major_id');
        $this->db->join('users', 'users.user_id = kaprogs.user_id');
        $this->db->where('kaprog_id', $kaprogID);
        return $this->db->get()->row();
    }
}
