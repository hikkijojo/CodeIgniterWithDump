<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Output extends CI_Output
{

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Taipei');
		$this->setDatetime();
	}

	/**
	 * api 處理時間戳
	 * @var false|string
	 */
	public $datetime = FALSE;

	/**
	 * 回傳前端對應狀態敘述
	 * @var string
	 */
	public $status;

	/**
	 * 回傳前端對應狀態代碼
	 * @var integer
	 */
	public $statusCode;

	/**
	 * api回傳訊息對應代碼
	 * @var integer|null
	 */
	public $msgCode;

	/**
	 * api回傳訊息對應文字
	 * @var string
	 */
	public $msg = '';

	/**
	 * api回傳資料
	 * @var array|object
	 */
	public $data = [];

	public function setMsg($_messageCode)
	{
		if (!is_null($_messageCode)) {
			if (isset(Message::$msg[$_messageCode])) {
				$this->msgCode = $_messageCode;
				$this->msg = Message::$msg[$_messageCode];
			} else {
				$this->msgCode = Message::SYSTEM_OTHER_ERROR;
				$this->msg = sprintf(Message::$msg[Message::SYSTEM_OTHER_ERROR], $_messageCode);
			}
		}
	}

	public function setDatetime()
	{
		$this->datetime = date('Y-m-d H:i:s', time());
	}

	public function setStatus($_statusCode)
	{
		if (!is_null($_statusCode)) {
			$this->statusCode = $_statusCode;
			$this->status = Status::$statusCode[$_statusCode];
		}
	}

	public function setErrorPostData($_ci)
	{
		$thisObj = json_decode(json_encode($this->getApiOutputContent(), TRUE), TRUE);
		$thisObj['post'] = $_ci->input->post();
		$thisObj['get'] = $_ci->input->get();
		$thisObj['request_headers'] = $_ci->input->request_headers();
		$thisObj['method'] = $_ci->input->method();
		$thisObj['ip_address'] = $_ci->input->ip_address();
		$thisObj['user_agent'] = $_ci->input->user_agent();
		$thisObj['url'] = $_ci->input->server('PHP_SELF');
		return json_encode($thisObj);
	}

	public function getApiOutputContent()
	{
		return (object)[
			'data' => $this->data,
			'datetime' => $this->datetime,
			'msg' => $this->msg,
			'msgCode' => $this->msgCode,
			'status' => $this->status,
			'statusCode' => $this->statusCode,
		];
	}

	protected function outputJson($_httpCode = 200)
	{
		$this->set_status_header($_httpCode);
		if ($this->msgCode === Message::SYSTEM_DB_ERROR) {
			// 另外多存的 log 紀錄。
			log_message('error', $this->setErrorPostData($this));
		}
		if (ob_get_contents()) {
			ob_end_flush();
			dd($this->getApiOutputContent());
		} else {
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($this->getApiOutputContent(), TRUE);
			exit;
		}
	}

	public function ok($_messageCode = NULL, $_httpCode = 200)
	{
		$this->setMsg($_messageCode);
		$this->setStatus(Status::STATUS_OK);
		$this->outputJson($_httpCode);
	}

	public function alert($_messageCode = NULL, $_httpCode = 200)
	{
		$this->setMsg($_messageCode);
		$this->setStatus(Status::STATUS_ALERT);
		$this->outputJson($_httpCode);
	}

	public function refresh($_messageCode = NULL, $_httpCode = 200)
	{
		$this->setMsg($_messageCode);
		$this->setStatus(Status::STATUS_REFRESH);
		$this->outputJson($_httpCode);
	}

	public function redirection($_url, $_messageCode = NULL, $_httpCode = 200)
	{
		$this->setMsg($_messageCode);
		$this->setStatus(Status::STATUS_REDIRECTION);
		$returnData['redirectionUrl'] = $_url;
		$this->outputJson($_httpCode);
	}

	public function alertAndRedirection($_url, $_messageCode = NULL, $_httpCode = 200)
	{
		$this->setMsg($_messageCode);
		$this->setStatus(Status::STATUS_ALERT_REDIRECTION);
		$returnData['redirectionUrl'] = $_url;
		$this->outputJson($_httpCode);
	}

}
