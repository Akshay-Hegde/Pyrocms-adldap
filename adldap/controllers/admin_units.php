<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_units extends Admin_Controller {

    protected $section = 'units';
    
    public function __construct()
    {
	parent::__construct();
	$this->load->library('adldap');
	$this->load->model('adldap_m');
	$this->load->library('form_validation');
	$this->lang->load('adldap');
        $this->adldap->connect();
    }
    
    public function index ()
    {
	$this->data->units = $this->adldap_m->get_settings();
	$this->template->title($this->module_details['name'])->build('admin/units/index', $this->data);
    }
    
    public function edit ($id = null)
    {
	$this->data->form_url = 'admin/adldap/units/edit/'.$id.'?action=save';
	if (is_null($id))
	{
	    $this->session->set_flashdata('error', 'id is null');
	    redirect ('/admin/adldap/units');
	}
	else
	{
	    $this->form_validation->set_rules('name', 'Name', 'trim|required');
	    $this->form_validation->set_rules('path', 'Unit', 'trim|required');
	    
	    if ($this->form_validation->run() == FALSE)
	    {
		$this->data->unit = $this->adldap_m->get_setting($id);
		$this->template->title($this->module_details['name'])->build('admin/units/form', $this->data);
	    }
	    else
	    {
		if(isset($_GET['action']) && $_GET['action']=='save')
		{
		    if(isset($_POST['id']) && $_POST['id'] != "")
		    {
			$this->adldap_m->update_settings($_POST);
			$this->session->set_flashdata('success', 'updated successfully');
			redirect ('/admin/adldap/units');
		    }
		}
	    }
	}
    }
    public function add ()
    {
	$this->form_validation->set_rules('name', 'Name', 'trim|required');
	$this->form_validation->set_rules('path', 'Unit', 'trim|required');
	
	if ($this->form_validation->run() == FALSE)
	{
	    $this->data->form_url = 'admin/adldap/units/add/?action=save';
	    $this->template->title($this->module_details['name'])->build('admin/units/form', $this->data);
	}
	else
	{
	    if(isset($_GET['action']) && $_GET['action']=='save' && isset($_POST))
	    {
		$this->adldap_m->add_settings($_POST);
		$this->session->set_flashdata('success', 'added successfully');
		redirect ('/admin/adldap/units');
	    }
	}
    }
    public function delete ($id = null)
    {
	if (is_null($id))
	{
	    $this->session->set_flashdata('error', 'id is null');
	    redirect ('/admin/adldap/units');
	}
	$this->adldap_m->delete_settings($id);
	$this->session->set_flashdata('success', 'deleted successfully');
	redirect ('/admin/adldap/units');
    }
}