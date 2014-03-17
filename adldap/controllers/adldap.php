<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Adldap extends Public_Controller
{
    protected $section = 'Frontend';
    
    public function __construct()
    {
	parent::__construct();
	redirect('adldap/frontend');
    }
    
}