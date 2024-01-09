<?php

class Presensi_model extends CI_model
{
    public function getPresenceNow($ploatingID)
    {
        $this->db->select('*');
        $this->db->from('presences');
        $this->db->where('presence_date', date('Y-m-d'));
        $this->db->where('ploating_id', $ploatingID);
        return $this->db->get();
    }

    public function getPresenceThisDate($ploatID, $date)
    {
        $this->db->select('*');
        $this->db->from('presences');
        $this->db->where('presence_date', $date);
        $this->db->where('ploating_id', $ploatID);
        return $this->db->get()->row();
    }

    public function getPresenceThisInstruktur($instrukturID, $status = null)
    {
        $this->db->select('*');
        $this->db->from('presences');
        $this->db->join('ploatings', 'ploatings.ploating_id = presences.ploating_id');
        $this->db->join('partisipants', 'partisipants.partisipant_id = ploatings.partisipant_id');
        $this->db->where('instruktur_id', $instrukturID);
        $this->db->where('status', $status);
        return $this->db->get()->result();
    }

    public function getPresenceThisMentor($mentorID, $status = null)
    {
        $this->db->select('*');
        $this->db->from('presences');
        $this->db->join('ploatings', 'ploatings.ploating_id = presences.ploating_id');
        $this->db->join('partisipants', 'partisipants.partisipant_id = ploatings.partisipant_id');
        $this->db->where('mentor_id', $mentorID);
        $this->db->where('status', $status);
        return $this->db->get()->result();
    }

    public function cekPresensceInstruktur($instrukturID, $presenceID)
    {
        $this->db->select('*');
        $this->db->from('presences');
        $this->db->join('ploatings', 'ploatings.ploating_id = presences.ploating_id');
        $this->db->join('partisipants', 'partisipants.partisipant_id = ploatings.partisipant_id');
        $this->db->where('instruktur_id', $instrukturID);
        $this->db->where('presence_id', $presenceID);
        return $this->db->get()->num_rows();
    }

    public function getAllPresenceType()
    {
        return $this->db->get('presences_type')->result_array();
    }
    public function getAllKIKD()
    {
        return $this->db->get('kikds')->result_array();
    }
    public function getAllPresence($parID)
    {
        $this->db->select('*');
        $this->db->from('presences');
        $this->db->join('presences_type', 'presences_type.presence_type_id = presences.presence_type_id');
        $this->db->where('partisipant_id', $parID);
        $this->db->order_by('presence_date', 'DESC');
        return $this->db->get()->result_array();
    }
    public function getAllJurnal($parID)
    {
        $this->db->select('*,count(*) as jml');
        $this->db->from('jurnals');
        $this->db->where('partisipant_id', $parID);
        $this->db->group_by('jurnal_date');
        $this->db->order_by('jurnal_date', 'DESC');
        return $this->db->get()->result_array();
    }
    public function getJurnalByID($jurID)
    {
        $this->db->select('*');
        $this->db->from('jurnals');
        $this->db->where('jurnal_id', $jurID);
        return $this->db->get()->row_array();
    }
    public function getJurnalByDate($parID, $date)
    {
        $this->db->select('*');
        $this->db->from('jurnals');
        $this->db->join('kikds', 'kikds.kikd_id = jurnals.kikd_id');
        $this->db->where('partisipant_id', $parID);
        $this->db->where('jurnal_date', $date);
        return $this->db->get()->result_array();
    }
}
