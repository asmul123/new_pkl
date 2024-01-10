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

    public function getThisJurnal($jurnal_id)
    {
        $this->db->select('*');
        $this->db->from('jurnals');
        $this->db->where('jurnal_id', $jurnal_id);
        return $this->db->get()->row();
    }

    public function getJurnalDetail($jurnal_id)
    {
        $this->db->select('*');
        $this->db->from('jurnal_details');
        $this->db->where('jurnal_id', $jurnal_id);
        return $this->db->get()->result();
    }

    public function getThisJurnalDetail($jurnal_id)
    {
        $this->db->select('*');
        $this->db->from('jurnal_details');
        $this->db->join('jurnals', 'jurnals.jurnal_id = jurnal_details.jurnal_id');
        $this->db->where('jurnal_detail_id', $jurnal_id);
        return $this->db->get()->row();
    }

    public function cekThisJurnalInstruktur($instruktur_id, $jurnal_id)
    {
        $this->db->select('*');
        $this->db->from('jurnal_details');
        $this->db->join('jurnals', 'jurnals.jurnal_id = jurnal_details.jurnal_id');
        $this->db->join('ploatings', 'ploatings.ploating_id = jurnals.ploating_id');
        $this->db->where('jurnal_detail_id', $jurnal_id);
        $this->db->where('instruktur_id', $instruktur_id);
        return $this->db->get()->num_rows();
    }

    public function getJurnalThisInstruktur($instrukturID, $status = null)
    {
        $this->db->select('*');
        $this->db->from('jurnal_details');
        $this->db->join('jurnals', 'jurnals.jurnal_id = jurnal_details.jurnal_id');
        $this->db->join('ploatings', 'ploatings.ploating_id = jurnals.ploating_id');
        $this->db->join('partisipants', 'partisipants.partisipant_id = ploatings.partisipant_id');
        $this->db->where('instruktur_id', $instrukturID);
        $this->db->where('status', $status);
        return $this->db->get()->result();
    }

    public function getJurnalThisMentor($mentorID, $status = null)
    {
        $this->db->select('*');
        $this->db->from('jurnal_details');
        $this->db->join('jurnals', 'jurnals.jurnal_id = jurnal_details.jurnal_id');
        $this->db->join('ploatings', 'ploatings.ploating_id = jurnals.ploating_id');
        $this->db->join('partisipants', 'partisipants.partisipant_id = ploatings.partisipant_id');
        $this->db->where('mentor_id', $mentorID);
        $this->db->where('status', $status);
        return $this->db->get()->result();
    }
}
