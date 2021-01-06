<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Exceptions extends CI_Exceptions
{

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Taipei');
	}

	protected function outputAlertJson($_message, $_tracingArr = [], $_status = 'alert', $_httpCode = 500)
	{
		set_status_header($_httpCode);
		$outputArr = [
			'data' => $_tracingArr,
			'datetime' => date('Y-m-d H:i:s', time()),
			'msg' => $_message,
			'msgCode' => -9999,
			'status' => $_status,
			'statusCode' => -1
		];
		if (ob_get_contents()) {
			ob_end_flush();
			dd($outputArr);
		} else {
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($outputArr, TRUE);
			exit;
		}
	}

	public function show_404($page = '', $log_error = TRUE)
	{
		$heading = '404 Page Not Found: ';
		if ($log_error) {
			log_message('error', $heading . $page);
		}
		$this->outputAlertJson($heading . $page);
	}

	/**
	 * Native PHP error handler
	 *
	 * @param int $severity Error level
	 * @param string $message Error message
	 * @param string $filepath File path
	 * @param int $line Line number
	 * @return    void
	 */
	public function show_php_error($severity, $message, $filepath, $line)
	{
		$errorArr[] = $filepath . ':' . $line . ' {' . $message . '}';
		$this->outputAlertJson($message, $errorArr, 500);
	}

	public function show_exception($exception)
	{
		$errorArr = [
			'message' => $exception->getMessage(),
			'file' => $exception->getFile(),
			'line' => $exception->getLine(),
			'trace' => $exception->getTrace(),
		];
		$this->outputAlertJson($errorArr['message'], $errorArr, 500);
	}

}
