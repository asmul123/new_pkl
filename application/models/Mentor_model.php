<?php

class Mentor_model extends CI_model
{
    public function getBioMentor($email)
    {
        $this->db->select('*');
        $this->db->from('mentors');
        $this->db->join('users', 'users.user_id = mentors.user_id');
        $this->db->join('majors', 'majors.major_id = mentors.major_id');
        $this->db->join('roles', 'roles.role_id = users.role_id');
        $this->db->where('email', $email);
        return $this->db->get()->row();
    }

    public function getPanduan($mentorID)
    {
        $this->db->select('document');
        $this->db->from('ploatings');
        $this->db->join('events', 'events.event_id = ploatings.event_id');
        $this->db->where('mentor_id', $mentorID);
        return $this->db->get()->row();
    }

    public function getMentors()
    {
        $this->db->select('*');
        $this->db->from('mentors');
        $this->db->join('majors', 'majors.major_id = mentors.major_id');
        $this->db->join('users', 'users.user_id = mentors.user_id');
        return $this->db->get()->result();
    }

    public function getMentorMajors($major_id)
    {
        $this->db->select('*');
        $this->db->from('mentors');
        $this->db->join('majors', 'majors.major_id = mentors.major_id');
        $this->db->join('users', 'users.user_id = mentors.user_id');
        $this->db->where('mentors.major_id', $major_id);
        return $this->db->get()->result();
    }

    public function getThisMentor($mentorID)
    {
        $this->db->select('*');
        $this->db->from('mentors');
        $this->db->join('majors', 'majors.major_id = mentors.major_id');
        $this->db->join('users', 'users.user_id = mentors.user_id');
        $this->db->where('mentor_id', $mentorID);
        return $this->db->get()->row();
    }
}
