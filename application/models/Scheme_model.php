<?php

class Scheme_model extends CI_model
{
    public function getWorkingScheme($ploatingID, $date)
    {
        $this->db->select('*');
        $this->db->from('working_schemes');
        $this->db->where('ploating_id', $ploatingID);
        $this->db->where('status', '2');
        $this->db->where('start_date <=', $date);
        $this->db->where('finish_date >=', $date);
        return $this->db->get();
    }

    public function getAllWorkingScheme($partisipantID)
    {
        $this->db->select('dudikas.name, working_schemes.start_date, working_schemes.finish_date, working_schemes.start_time, working_schemes.finish_time, working_schemes.status, working_schemes.off_days, working_schemes.scheme_id');
        $this->db->from('working_schemes');
        $this->db->join('ploatings', 'ploatings.ploating_id = working_schemes.ploating_id');
        $this->db->join('dudikas', 'dudikas.dudika_id = ploatings.dudika_id');
        $this->db->where('partisipant_id', $partisipantID);
        return $this->db->get()->result();
    }

    public function getThisScheme($scheme_id)
    {
        $this->db->select('*');
        $this->db->from('working_schemes');
        $this->db->where('scheme_id', $scheme_id);
        return $this->db->get()->row();
    }

    public function getSchemeThisInstruktur($instruktur_id, $status = null)
    {
        $this->db->select('partisipants.name, working_schemes.start_date, working_schemes.finish_date, working_schemes.start_time, working_schemes.finish_time, working_schemes.status, working_schemes.off_days, working_schemes.scheme_id');
        $this->db->from('working_schemes');
        $this->db->join('ploatings', 'ploatings.ploating_id = working_schemes.ploating_id');
        $this->db->join('partisipants', 'partisipants.partisipant_id = ploatings.partisipant_id');
        $this->db->where('instruktur_id', $instruktur_id);
        $this->db->where('status', $status);
        return $this->db->get()->result();
    }

    public function getSchemeThisMentor($mentor_id, $status = null)
    {
        $this->db->select('partisipants.name, working_schemes.start_date, working_schemes.finish_date, working_schemes.start_time, working_schemes.finish_time, working_schemes.status, working_schemes.off_days, working_schemes.scheme_id');
        $this->db->from('working_schemes');
        $this->db->join('ploatings', 'ploatings.ploating_id = working_schemes.ploating_id');
        $this->db->join('partisipants', 'partisipants.partisipant_id = ploatings.partisipant_id');
        $this->db->where('mentor_id', $mentor_id);
        $this->db->where('status', $status);
        return $this->db->get()->result();
    }

    public function cekSchemeInstruktur($instrukturID, $skemaID)
    {
        $this->db->select('*');
        $this->db->from('working_schemes');
        $this->db->join('ploatings', 'ploatings.ploating_id = working_schemes.ploating_id');
        $this->db->where('instruktur_id', $instrukturID);
        $this->db->where('scheme_id', $skemaID);
        return $this->db->get()->num_rows();
    }

    public function cekSchemeMentor($mentorID, $skemaID)
    {
        $this->db->select('*');
        $this->db->from('working_schemes');
        $this->db->join('ploatings', 'ploatings.ploating_id = working_schemes.ploating_id');
        $this->db->where('mentor_id', $mentorID);
        $this->db->where('scheme_id', $skemaID);
        return $this->db->get()->num_rows();
    }
}
