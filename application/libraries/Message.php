<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Message
{
	const OPERATING_SUCCESS = 1;
	const SYSTEM_DB_ERROR = 9999;
	const ARGUMENT_INPUT_ERROR = 9000;
	const SYSTEM_OTHER_ERROR = 9100;
	const LOGIN_FAILURE = 1001;
	const MISSING_INFORMATION = 1002;
	const CREATE_USER_FAILURE = 1003;
	const CREATE_USER_ACCOUNT_EXIST = 1004;
	const CREATE_USER_SUCCESS = 1005;
	const LOGIN_SUCCESS = 1006;
	const LOGIN_OVERTIME = 1007;
	const FILE_UPLOAD_SUCCESS = 1008;
	const NO_DATA_FOUND = 1009;
	const PASSWORD_ERROR = 1010;
	const OLD_AND_NEW_PASSWORDS_CANNOT_BE_THE_SAME = 1011;
	const CONFIRM_PASSWORD_IS_DIFFERENT = 1012;

	public static $msg = [
		self::OPERATING_SUCCESS => '操作成功。',
		self::SYSTEM_DB_ERROR => '系統錯誤，請確認操作步驟或洽詢管理員。',
		self::ARGUMENT_INPUT_ERROR => '傳入引數錯誤。',
		self::SYSTEM_OTHER_ERROR => '系統其他錯誤：「%s」',
		self::LOGIN_FAILURE => '登入失敗，請檢查帳號或密碼。',
		self::LOGIN_SUCCESS => '登入成功。',
		self::MISSING_INFORMATION => '填寫的資料有缺少，請檢查輸入的內容。',
		self::CREATE_USER_FAILURE => '建立帳號失敗，請確認帳號密碼必須大於6位，信箱格式是否錯誤。',
		self::CREATE_USER_ACCOUNT_EXIST => '建立帳號失敗，使用者帳號已存在。',
		self::CREATE_USER_SUCCESS => '建立帳號成功。',
		self::LOGIN_OVERTIME => '帳號登入期限已過，請重新登入。',
		self::FILE_UPLOAD_SUCCESS => '檔案上傳成功。',
		self::NO_DATA_FOUND => '查無資料。',
		self::PASSWORD_ERROR => '密碼錯誤。',
		self::OLD_AND_NEW_PASSWORDS_CANNOT_BE_THE_SAME => '新密碼不能與舊密碼相同。',
		self::CONFIRM_PASSWORD_IS_DIFFERENT => '新密碼與確認密碼輸入不一樣。',
	];

	public function __construct()
	{
	}

}
