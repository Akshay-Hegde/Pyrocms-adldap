<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Adldap_m extends MY_Model
{
    var $settings;
    
    function __construct ()
    {
        parent::__construct();
        $this->settings = 'adldap_units';
    }
    
    public function get_settings ()
    {
        return $this->db->get($this->settings)->result();
    }
    
    public function get_setting ($id)
    {
        $this->db->where('id', $id);
        return $this->db->get($this->settings)->row();
    }
    
    public function update_settings($input)
    {
	$data = array(
        'name' => $input['name'],
        'path' => $input['path'],
        );
	$this->db->where('id', $input['id']);
	$this->db->update($this->settings, $data);
        return $this->db->affected_rows();
    }
    
    public function add_settings($input)
    {
        $this->db->set('name', $input['name']);
        $this->db->set('path', $input['path']);
	$this->db->insert($this->settings);
        return $this->db->affected_rows();
    }
    
    public function delete_settings ($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->settings);
    }
    
    
}