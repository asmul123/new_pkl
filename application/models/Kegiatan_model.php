<?php

class Kegiatan_model extends CI_model
{
    public function getEvents()
    {
        $this->db->select('*');
        $this->db->from('events');
        $this->db->join('majors', 'majors.major_id = events.major_id');
        return $this->db->get()->result();
    }

    public function getEventMajors($majorID)
    {
        $this->db->select('*');
        $this->db->from('events');
        $this->db->join('majors', 'majors.major_id = events.major_id');
        $this->db->where('events.major_id', $majorID);
        return $this->db->get()->result();
    }

    public function getThisEvent($eventID)
    {
        $this->db->select('*');
        $this->db->from('events');
        $this->db->join('majors', 'majors.major_id = events.major_id');
        $this->db->where('event_id', $eventID);
        return $this->db->get()->row();
    }
}
