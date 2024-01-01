<?php

class Program_model extends CI_model
{
    public function getMajors()
    {
        $this->db->select('*');
        $this->db->from('majors');
        return $this->db->get()->result();
    }
}
