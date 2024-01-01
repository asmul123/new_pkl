<?php

class Tapel_model extends CI_model
{
    public function getTapels()
    {
        $this->db->select('*');
        $this->db->from('tapels');
        $this->db->order_by('tapel', 'DESC');
        return $this->db->get()->result();
    }
}
