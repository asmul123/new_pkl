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

    public function getPesertaPloatings($mentor_id)
    {
        $this->db->select('*, partisipants.name as peserta, dudikas.name as dudika, instrukturs.name as instruktur, ploatings.start_date as sd, ploatings.finish_date as fd, ploatings.start_time as st, ploatings.finish_time as ft');
        $this->db->from('ploatings');
        $this->db->join('partisipants', 'partisipants.partisipant_id = ploatings.partisipant_id');
        $this->db->join('dudikas', 'dudikas.dudika_id = ploatings.dudika_id');
        $this->db->join('instrukturs', 'instrukturs.instruktur_id = ploatings.instruktur_id');
        $this->db->join('tapels', 'tapels.tapel_id = partisipants.tapel_id');
        $this->db->where('ploatings.mentor_id', $mentor_id);
        $this->db->order_by('partisipants.tapel_id', 'DESC');
        $this->db->order_by('ploatings.dudika_id', 'DESC');
        return $this->db->get()->result();
    }

    public function getPesertaBelumPloatings($mentor_id)
    {
        $this->db->select('*, partisipants.name as peserta, dudikas.name as dudika');
        $this->db->from('ploatings');
        $this->db->join('partisipants', 'partisipants.partisipant_id = ploatings.partisipant_id');
        $this->db->join('dudikas', 'dudikas.dudika_id = ploatings.dudika_id');
        $this->db->join('tapels', 'tapels.tapel_id = partisipants.tapel_id');
        $this->db->where('ploatings.mentor_id', $mentor_id);
        $this->db->where('ploatings.instruktur_id', NULL);
        $this->db->order_by('partisipants.tapel_id', 'DESC');
        $this->db->order_by('ploatings.dudika_id', 'DESC');
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
}
