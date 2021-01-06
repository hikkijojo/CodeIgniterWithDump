<?php
defined('BASEPATH') or exit('No direct script access allowed');
// 使用在 CI 上的方式 先載入 library
// $this->load->library( 'azdg' );
//echo $this->azdg->encode( '許功蓋' );
//echo $this->azdg->decode( 'VOlT/QLkVO4GjVTLBegDkwbd' );

class Azdg
{
	private $strPrivateKey = '';
	private $strPrivateDefaultKey = 'niv3aq';
	private $strDefaultCharset = 'utf8';
	private $strTargetCharset = '';
	private $strSourceText = '';
	private $intSourceLength = 0;

	/**
	 * 將字串進行加密。
	 *
	 * @param String $arg_strSourceText
	 *            需要加密字串
	 * @param null $arg_strPrivateKey
	 *            私匙(預設編碼'0123456789')
	 * @param null $arg_strCharset
	 *            程式目前運行的編碼(預設編碼 utf8
	 * @return String 加密後字串。
	 * @throws Exception
	 */
	public function encode($arg_strSourceText, $arg_strPrivateKey = NULL, $arg_strCharset = NULL)
	{
		$this->strSourceText = $arg_strSourceText;
		$this->intSourceLength = strlen($this->strSourceText);
		$this->strPrivateKey = is_null($arg_strPrivateKey) ? '' : $arg_strPrivateKey;
		if (!is_null($arg_strCharset) && !empty($arg_strCharset)) {
			$this->strTargetCharset = $arg_strCharset;
			if (!$this->convert_encoding()) {
				throw new Exception('Encoding conversion failed');
			}
		}
		$strCRCKey = md5(microtime());
		$intCRCLength = 0;
		$strTmp = "";
		for ($i = 0; $i < $this->intSourceLength; ++$i) {
			if ($intCRCLength > 31) {
				$intCRCLength = 0;
			}
			$strTmp .= $strCRCKey[$intCRCLength] . ($this->strSourceText[$i] ^ $strCRCKey[$intCRCLength++]);
		}
		return base64_encode($this->private_key_crypt($strTmp));
	}

	private function convert_encoding()
	{
		// 預設轉碼失敗
		$blnIconvPassed = FALSE;
		if (function_exists('iconv') && $strEncodedData = iconv($this->strDefaultCharset, $this->strTargetCharset . '//TRANSLIT', $this->strSourceText)) {
			$blnIconvPassed = TRUE;
			$this->strSourceText = $strEncodedData;
		} // 如果 iconv 轉換失敗，再嚐試用mb_convert_encoding編碼
		else if (!$blnIconvPassed && function_exists('mb_convert_encoding') && $strEncodedData = @mb_convert_encoding($this->strSourceText, $this->strTargetCharset, $this->strDefaultCharset)) {
			$blnIconvPassed = TRUE;
			$this->strSourceText = $strEncodedData;
		}
		return $blnIconvPassed;
	}

	/**
	 * AzDG 加解密物件
	 */
	private function private_key_crypt($arg_strSourceText)
	{
		$strEncryptKey = md5($this->strPrivateKey === '' ? $this->strPrivateDefaultKey : $this->strPrivateKey);
		$intCRCLength = 0;
		$strReturn = "";
		$intSourceLength = strlen($arg_strSourceText);
		for ($i = 0; $i < $intSourceLength; ++$i) {
			if ($intCRCLength > 31) {
				$intCRCLength = 0;
			}
			$strReturn .= ($arg_strSourceText[$i] ^ $strEncryptKey[$intCRCLength++]);
		}
		return $strReturn;
	}

	/**
	 * 將字串進行解密。
	 *
	 * @param String $arg_strSourceText
	 *            需要解密字串
	 * @param null $arg_strPrivateKey
	 *            私匙(預設編碼'0123456789')
	 * @param null $arg_strCharset
	 *            程式目前運行的編碼(預設編碼 utf8
	 * @return String 解密後字串。
	 * @throws Exception
	 */
	public function decode($arg_strSourceText, $arg_strPrivateKey = NULL, $arg_strCharset = NULL)
	{
		$this->strPrivateKey = is_null($arg_strPrivateKey) ? '' : $arg_strPrivateKey;
		if (!is_null($arg_strCharset) && !empty($arg_strCharset)) {
			$this->strTargetCharset = $arg_strCharset;
			if (!$this->convert_encoding()) {
				throw new Exception('Encoding conversion failed');
			}
		}
		$this->strSourceText = $this->private_key_crypt(base64_decode($arg_strSourceText));
		$this->intSourceLength = strlen($this->strSourceText);
		$strReturn = '';
		for ($i = 0; $i < $this->intSourceLength; ++$i) {
			@$strReturn .= ($this->strSourceText[$i++] ^ $this->strSourceText[$i]);
		}
		return $strReturn;
	}
}
