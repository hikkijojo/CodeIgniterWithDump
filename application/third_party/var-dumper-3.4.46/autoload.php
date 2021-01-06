<?php
//autoload.php
function var_dump_autoload($class) {

	$namespace_map = ['Symfony\\Component\\VarDumper' => __DIR__ . '/'];

	foreach ($namespace_map as $prefix => $dir) {
		/* First swap out the namespace prefix with a directory... */
		$path = str_replace($prefix, $dir, $class);

		/* replace the namespace separator with a directory separator... */
		$path = str_replace('\\', '/', $path);

		/* and finally, add the PHP file extension to the result. */
		$path = $path . '.php';

		/* $path should now contain the path to a PHP file defining $class */
		if (file_exists($path)) {
			include $path;
		}
	}
}
spl_autoload_register('var_dump_autoload');
require_once 'HtmlDumper.php';
