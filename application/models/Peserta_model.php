<?php

class Peserta_model extends CI_model
{
    public function getBioPeserta($email)
    {
        $this->db->select('*');
        $this->db->from('partisipants');
        $this->db->join('users', 'users.user_id = partisipants.user_id');
        $this->db->join('majors', 'majors.major_id = partisipants.major_id');
        $this->db->join('roles', 'roles.role_id = users.role_id');
        $this->db->where('email', $email);
        return $this->db->get()->row();
    }

    public function getPesertaMajors($major_id)
    {
        $this->db->select('*');
        $this->db->from('partisipants');
        $this->db->join('users', 'users.user_id = partisipants.user_id');
        $this->db->join('majors', 'majors.major_id = partisipants.major_id');
        $this->db->join('tapels', 'tapels.tapel_id = partisipants.tapel_id');
        $this->db->join('roles', 'roles.role_id = users.role_id');
        $this->db->where('partisipants.major_id', $major_id);
        $this->db->order_by('partisipants.tapel_id', 'DESC');
        $this->db->order_by('class', 'ASC');
        $this->db->order_by('name', 'ASC');
        return $this->db->get()->result();
    }

    public function getThisPeserta($partisipant_id)
    {
        $this->db->select('*');
        $this->db->from('partisipants');
        $this->db->join('users', 'users.user_id = partisipants.user_id');
        $this->db->join('roles', 'roles.role_id = users.role_id');
        $this->db->where('partisipant_id', $partisipant_id);
        return $this->db->get()->row();
    }

    public function getAllPresenceType()
    {
        return $this->db->get('presences_type')->result_array();
    }
    public function getAllKIKD()
    {
        return $this->db->get('kikds')->result_array();
    }
    public function getPresenceNow($parID)
    {
        $this->db->select('*');
        $this->db->from('presences');
        $this->db->where('presence_date', date('Y-m-d'));
        $this->db->where('partisipant_id', $parID);
        return $this->db->get()->row_array();
    }
    public function getPresenceByDate($parID, $date)
    {
        $this->db->select('*');
        $this->db->from('presences');
        $this->db->join('presences_type', 'presences_type.presence_type_id = presences.presence_type_id');
        $this->db->where('presence_date', $date);
        $this->db->where('partisipant_id', $parID);
        return $this->db->get()->row_array();
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
