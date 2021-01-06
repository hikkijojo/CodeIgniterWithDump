<?php

use Symfony\Component\VarDumper\Dumper\HtmlDumper as SymfonyHtmlDumper;

/**
 * Class HtmlDumper
 */
class HtmlDumper extends SymfonyHtmlDumper
{
	/**
	 * Colour definitions for output.
	 *
	 * @var array
	 */
	protected $styles = [
		'default' => 'background-color:#fff; color:#222; line-height:1.2em; font-weight:normal; font:12px Monaco, Consolas, monospace; word-wrap: break-word; white-space: pre-wrap; position:relative; z-index:100000',
		'num' => 'color:#a71d5d',
		'const' => 'color:#795da3',
		'str' => 'color:#df5000',
		'cchr' => 'color:#222',
		'note' => 'color:#a71d5d',
		'ref' => 'color:#a0a0a0',
		'public' => 'color:#795da3',
		'protected' => 'color:#795da3',
		'private' => 'color:#795da3',
		'meta' => 'color:#b729d9',
		'key' => 'color:#df5000',
		'index' => 'color:#a71d5d',
	];
}

if (!function_exists('dd')) {
	/**
	 * Dump the passed variables and end the script.
	 *
	 * @param mixed
	 * @return void
	 */
	function dd(...$args)
	{
		foreach ($args as $x) {
			\Symfony\Component\VarDumper\VarDumper::dump($x);
		}
		die(1);
	}
}

if (!function_exists('dump')) {
	/**
	 * Dump the passed array variables and end the script.
	 *
	 * @param mixed
	 * @return void
	 */
	function dump(...$args)
	{
		ob_start();
		$debugTrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
		echo "<pre>{$debugTrace[0]['file']}: {$debugTrace[0]['line']}</pre>";
		foreach ($args as $x) {
			\Symfony\Component\VarDumper\VarDumper::dump($x);
		}
	}
}
