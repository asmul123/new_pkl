<?php

class Jurnal_model extends CI_model
{
    public function getJurnalPartisipant($partisipantID)
    {
        $this->db->select('dudikas.name as dudika, jurnals.*');
        $this->db->from('jurnals');
        $this->db->join('ploatings', 'ploatings.ploating_id = jurnals.ploating_id');
        $this->db->join('dudikas', 'dudikas.dudika_id = ploatings.dudika_id');
        $this->db->join('partisipants', 'partisipants.partisipant_id = ploatings.partisipant_id');
        $this->db->where('ploatings.partisipant_id', $partisipantID);
        return $this->db->get()->result();
    }

    public function getJurnalDetail($jurnal_id)
    {
        $this->db->select('*');
        $this->db->from('jurnal_details');
        $this->db->where('jurnal_id', $jurnal_id);
        return $this->db->get()->result();
    }
}
