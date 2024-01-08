<?php

class Izin_model extends CI_model
{
    public function getParentPermission($ploatingID)
    {
        $this->db->select('*');
        $this->db->from('parent_permissions');
        $this->db->join('ploatings', 'ploatings.ploating_id = parent_permissions.ploating_id');
        $this->db->join('partisipants', 'partisipants.partisipant_id = ploatings.partisipant_id');
        $this->db->where('parent_permissions.ploating_id', $ploatingID);
        return $this->db->get()->row();
    }
}
