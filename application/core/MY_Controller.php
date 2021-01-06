<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

/**
 * Class MY_Controller
 * 不需要登入的繼承 MY_Controller
 */
class MY_Controller extends REST_Controller
{
	
	public $userData;

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Taipei');
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Credentials: true");
		$this->load->library('message');
		$this->load->library('status');
		$this->load->helper('date');
	}

	public function getReturnData()
	{
		return $this->output->data;
	}

	public function setReturnData($_returnData)
	{
		$this->output->data = $_returnData;
		return $this->output;
	}

	public function ok($_messageCode = NULL, $_httpCode = 200)
	{
		$this->output->ok($_messageCode, $_httpCode);
	}

	public function alert($_messageCode = NULL, $_httpCode = 200)
	{
		$this->output->alert($_messageCode, $_httpCode);
	}

	public function refresh($_messageCode = NULL, $_httpCode = 200)
	{
		$this->output->refresh($_messageCode, $_httpCode);
	}

	public function redirection($_url, $_messageCode = NULL, $_httpCode = 200)
	{
		$this->output->redirection($_url, $_messageCode, $_httpCode);
	}

	public function alertAndRedirection($_url, $_messageCode = NULL, $_httpCode = 200)
	{
		$this->output->alertAndRedirection($_url, $_messageCode, $_httpCode);
	}

}



/**
 * Class API_Controller
 * 需要登入的使用 API_Controller
 * 僅有 GET 不需要驗證
 */
class API_Controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		if (strtolower($_SERVER['REQUEST_METHOD']) !== 'get') {
			$this->checkToken();
		}
	}

	public function checkToken()
	{
		$this->load->model('AdminUser_model');
		$this->userData = $this->AdminUser_model->checkTokenIsEffectiveAndReturnData();
		if ($this->userData === FALSE) {
			$this->alertAndRedirection('/login', Message::LOGIN_OVERTIME);
		}
	}

}
