<?php

class Dudika_model extends CI_model
{
    public function getDudikas()
    {
        $this->db->select('*');
        $this->db->from('dudikas');
        $this->db->join('majors', 'majors.major_id = dudikas.major_id');
        $this->db->join('tapels', 'tapels.tapel_id = dudikas.tapel_id');
        return $this->db->get()->result();
    }

    public function getThisDudika($dudikaID)
    {
        $this->db->select('*');
        $this->db->from('dudikas');
        $this->db->join('majors', 'majors.major_id = dudikas.major_id');
        $this->db->join('tapels', 'tapels.tapel_id = dudikas.tapel_id');
        $this->db->where('dudika_id', $dudikaID);
        return $this->db->get()->row();
    }
}
