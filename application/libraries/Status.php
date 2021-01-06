<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Status
{
	const STATUS_OK = 0;

	// 前端對應動作的 status code
	const STATUS_ALERT = -1;
	const STATUS_REFRESH = -2;
	const STATUS_REDIRECTION = -3;
	const STATUS_ALERT_REDIRECTION = -4;
	const STATUS_ERROR = -999;
	public static $statusCode = [
		self::STATUS_OK => 'ok',
		self::STATUS_ALERT => 'alert',
		self::STATUS_REFRESH => 'refresh',
		self::STATUS_REDIRECTION => 'redirection',
		self::STATUS_ALERT_REDIRECTION => 'alert and redirection',
		self::STATUS_ERROR => 'error',
	];

	public function __construct()
	{
	}

}
