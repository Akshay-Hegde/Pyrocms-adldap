<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Adldap extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'AD Manage',
				'ru' => 'Управление AD',
			),
			'description' => array(
				'en' => 'You can to manage Active Directory accounts',
				'ru' => 'Вы можете управлять учетными записями Active Directory',
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => 'utilities',
			'sections' => array(
				'main' => array(
				    'name' => 'admin::main::title',
				    'uri' => 'admin/adldap',
				),
				'units' => array(
				    'name' => 'admin::units::title',
				    'uri' => 'admin/adldap/units',
					'shortcuts'	=> array(
						array(
					 	   'name'	=> 'admin::units::add_unit',
						   'uri'	=> 'admin/adldap/units/add',
						   'class'	=> 'add'
						)
					)
				),
			),
		);
	}

	public function install()
	{	
		$this->dbforge->drop_table('adldap_units');
		
		$adldap_units = "
			CREATE TABLE ".$this->db->dbprefix('default_adldap_units')." (
			  id int(11) NOT NULL AUTO_INCREMENT,
			  name varchar(255) DEFAULT NULL,
			  path varchar(255) DEFAULT NULL,
			  date timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			  PRIMARY KEY (id)
			)
			ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
			INSERT INTO ".$this->db->dbprefix('default_adldap_units')." (`id`, `name`, `path`) VALUES (1, 'Default', 'CN=Computers');
		";
		
		if($this->db->query($adldap_units))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('adldap_units');
		return TRUE;
	}


	public function upgrade($old_version)
	{
		return TRUE;
	}

	public function help()
	{
		return "Нет документации.";
	}
}
