<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cdump
{
	public function __construct()
	{
		require_once APPPATH . 'third_party/var-dumper-3.4.46/autoload.php';
	}
}
