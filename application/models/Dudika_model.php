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

    public function getDudikaMajors($major_id)
    {
        $this->db->select('*');
        $this->db->from('dudikas');
        $this->db->join('majors', 'majors.major_id = dudikas.major_id');
        $this->db->join('tapels', 'tapels.tapel_id = dudikas.tapel_id');
        $this->db->where('dudikas.major_id', $major_id);
        return $this->db->get()->result();
    }

    public function getDudikaPloatings($mentor_id)
    {
        $this->db->select('*');
        $this->db->from('dudikas');
        $this->db->join('ploatings', 'ploatings.dudika_id = dudikas.dudika_id');
        $this->db->where('mentor_id', $mentor_id);
        $this->db->group_by('ploatings.dudika_id');
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
