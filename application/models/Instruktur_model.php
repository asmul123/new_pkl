<?php

class Instruktur_model extends CI_model
{
    public function getBioInstruktur($email)
    {
        $this->db->select('*');
        $this->db->from('instrukturs');
        $this->db->join('users', 'users.user_id = instrukturs.user_id');
        $this->db->join('dudikas', 'dudikas.dudika_id = instrukturs.dudika_id');
        $this->db->join('roles', 'roles.role_id = users.role_id');
        $this->db->where('email', $email);
        return $this->db->get()->row();
    }

    public function getInstrukturs()
    {
        $this->db->select('*');
        $this->db->from('instrukturs');
        $this->db->join('dudikas', 'dudikas.dudika_id = instrukturs.dudika_id');
        $this->db->join('users', 'users.user_id = instrukturs.user_id');
        return $this->db->get()->result();
    }

    public function getInstrukturMentors($mentor_id)
    {
        $this->db->select('*, dudikas.name as dudika, instrukturs.name as instruktur, count(partisipant_id) as jml_peserta');
        $this->db->from('instrukturs');
        $this->db->join('dudikas', 'dudikas.dudika_id = instrukturs.dudika_id');
        $this->db->join('ploatings', 'ploatings.dudika_id = instrukturs.dudika_id');
        $this->db->join('users', 'users.user_id = instrukturs.user_id');
        $this->db->where('mentor_id', $mentor_id);
        $this->db->where('ploatings.instruktur_id !=', '');
        $this->db->group_by('ploatings.instruktur_id');
        return $this->db->get()->result();
    }

    public function getThisInstruktur($instrukturID)
    {
        $this->db->select('*, instrukturs.name as instruktur');
        $this->db->from('instrukturs');
        $this->db->join('dudikas', 'dudikas.dudika_id = instrukturs.dudika_id');
        $this->db->join('users', 'users.user_id = instrukturs.user_id');
        $this->db->where('instruktur_id', $instrukturID);
        return $this->db->get()->row();
    }

    public function getInstrukturPloating($instrukturID)
    {
        $this->db->select('*');
        $this->db->from('ploatings');
        $this->db->join('dudikas', 'dudikas.dudika_id = instrukturs.dudika_id');
        $this->db->join('partisipants', 'partisipants.partisipant_id = ploatings.partisipant_id');
        $this->db->where('instruktur_id', $instrukturID);
        return $this->db->get()->result();
    }
}
