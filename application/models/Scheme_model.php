<?php

class Scheme_model extends CI_model
{
    public function getWorkingScheme($ploatingID, $date)
    {
        $this->db->select('*');
        $this->db->from('working_schemes');
        $this->db->where('ploating_id', $ploatingID);
        $this->db->where('status', '1');
        $this->db->where('start_date <=', $date);
        $this->db->where('finish_date >=', $date);
        return $this->db->get();
    }
}
