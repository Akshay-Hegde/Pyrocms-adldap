<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller {

    protected $section = 'main';
    
    public function __construct()
    {
	parent::__construct();
	$this->config->load('adldap');
	$this->load->library('adldap');
	$this->load->model('adldap_m');
	$this->load->library('form_validation');
	$this->lang->load('adldap');
        $this->adldap->connect();
    }
    
    public function index ()
    {
	$settings = $this->adldap_m->get_settings();
	$this->data->unitz = array('' => 'Select a unit'); foreach ($settings as $s) { $this->data->unitz[$s->id] = $s->name; }
	
	$result = array();
	foreach ($settings as $key => $setting)
	{
	    //Search for computers in the default computrs
	    //organization unit
	    
	    if (preg_match('/CN=Computers/', $setting->path, $matches))
	    {
		$units = explode('CN=', $matches[0]);
		$clean_units = array();
		foreach ($units as $keyz => $unit) { if (!empty($unit)) { $clean_units[$keyz] = $unit; }}	
		$info = $this->adldap->folder_list($clean_units, ADLDAP_CONTAINER, true, 'computer');
		$result[$key]['id'] = $setting->id;
		$result[$key]['name'] = $setting->name;
		$result[$key]['date'] = $setting->date;
		$result[$key]['path'] = $matches[0];
		$result[$key]['info'] = $info;
	    }
	    
	    else
	    {
		$units = str_replace(',', '', $setting->path);
		$units = explode('OU=', $units);
		$clean_units = array();
		foreach ($units as $keyz => $unit) { if (!empty($unit)) { $clean_units[$keyz] = $unit; }}	
		$info = $this->adldap->folder_list($clean_units, ADLDAP_FOLDER, true, 'computer');
		$result[$key]['id'] = $setting->id;
		$result[$key]['name'] = $setting->name;
		$result[$key]['date'] = $setting->date;
		$result[$key]['path'] = $setting->path;
		$result[$key]['info'] = $info;
	    }
	    
	}
	
	$this->template->title($this->module_details['name'])->set('result', $result)->build('/admin/index', $this->data);

    }
    
    public function move ()
    {
	$post_data = $this->input->post();
	if (empty($post_data))
	{
	    $this->session->set_flashdata('error', 'was an error (post isnt set)');
	    redirect ('/admin/adldap/');
	}
	else
	{
	    $computer = str_replace('$', '', $post_data["computer"]);
	    (int)$unit_id = $post_data["units"];
	    $path = $this->adldap_m->get_setting($unit_id)->path;
	    $res = $this->adldap->move_rename_account('computer', $computer, NULL, $path.','.$this->config->item('base_dn'));
	    if ($res == TRUE)
	    {
		$this->session->set_flashdata('success', $computer . ' moved successfully');
		redirect ('/admin/adldap/');
	    }
	    else
	    {
		$this->session->set_flashdata('error', 'was an error');
		redirect ('/admin/adldap/');
	    }
	}
    }
    public function delete ()
    {
	if ($_POST)
	{
	    $computer = str_replace('$', '', $this->input->post('c', TRUE));
	    $result = $this->adldap->delete('computer', $computer);
	    if ($result == TRUE) {
		print 1;
	    } else {
		print 0;
	    }
	}
	else
	{
	    print "this is not a POST request";
	}
    }
}