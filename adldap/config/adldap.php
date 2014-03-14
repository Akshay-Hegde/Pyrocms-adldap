<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['account_suffix']	= '@you-domain.com';
$config['base_dn']		= 'DC=you-domain,DC=com';
$config['domain_controllers']	= array ('you-controller-ip-or-fqdn-name');
$config['ad_username']		= 'you-login';
$config['ad_password']		= 'you-password';
$config['real_primarygroup']	= true;
$config['use_ssl']		= false;
$config['use_tls'] 		= false;
$config['recursive_groups']	= true;