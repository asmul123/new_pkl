<?php

class Ploating_model extends CI_model
{
    public function getPloatingPeserta($major_id)
    {
        $this->db->select('*, partisipants.name as peserta, mentors.name as pembimbing, dudikas.name as dudika');
        $this->db->from('ploatings');
        $this->db->join('partisipants', 'partisipants.partisipant_id = ploatings.partisipant_id');
        $this->db->join('mentors', 'mentors.mentor_id = ploatings.mentor_id');
        $this->db->join('dudikas', 'dudikas.dudika_id = ploatings.dudika_id');
        $this->db->where('partisipants.major_id', $major_id);
        return $this->db->get()->result();
    }
}
