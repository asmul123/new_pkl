<?php

class Ploating_model extends CI_model
{
    public function getPloatingPeserta($major_id)
    {
        $this->db->select('*, partisipants.name as peserta, mentors.name as pembimbing, dudikas.name as dudika');
        $this->db->from('ploatings');
        $this->db->join('partisipants', 'partisipants.partisipant_id = ploatings.partisipant_id');
        $this->db->join('events', 'events.event_id = ploatings.event_id');
        $this->db->join('mentors', 'mentors.mentor_id = ploatings.mentor_id');
        $this->db->join('dudikas', 'dudikas.dudika_id = ploatings.dudika_id');
        $this->db->join('tapels', 'tapels.tapel_id = dudikas.tapel_id');
        $this->db->where('partisipants.major_id', $major_id);
        return $this->db->get()->result();
    }

    public function getThisPloating($ploatingID)
    {
        $this->db->select('*, partisipants.name as peserta, mentors.name as pembimbing, dudikas.name as dudika');
        $this->db->from('ploatings');
        $this->db->join('partisipants', 'partisipants.partisipant_id = ploatings.partisipant_id');
        $this->db->join('events', 'events.event_id = ploatings.event_id');
        $this->db->join('mentors', 'mentors.mentor_id = ploatings.mentor_id');
        $this->db->join('dudikas', 'dudikas.dudika_id = ploatings.dudika_id');
        $this->db->join('tapels', 'tapels.tapel_id = dudikas.tapel_id');
        $this->db->where('ploating_id', $ploatingID);
        return $this->db->get()->row();
    }

    public function getPloatingDudika($dudikaID)
    {
        $this->db->select('*');
        $this->db->from('ploatings');
        $this->db->join('partisipants', 'partisipants.partisipant_id = ploatings.partisipant_id');
        $this->db->where('dudika_id', $dudikaID);
        return $this->db->get()->result_array();
    }

    public function getEventDudika($dudikaID)
    {
        $this->db->select('events.start_date as sd, events.finish_date as fd');
        $this->db->from('ploatings');
        $this->db->join('events', 'events.event_id = ploatings.event_id');
        $this->db->where('dudika_id', $dudikaID);
        return $this->db->get()->row_array();
    }
}
