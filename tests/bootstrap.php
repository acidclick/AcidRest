<?php
namespace {

if (@!include __DIR__ . '/../vendor/autoload.php') {
	echo 'Install Nette Tester using `composer update --dev`';
	exit(1);
}

Tester\Environment::setup();

date_default_timezone_set('Europe/Prague');

$_GET = $_POST = $_COOKIE = array();

define('TEMP_DIR', __DIR__ . '/tmp/' . getmypid());
@mkdir(dirname(TEMP_DIR)); 
Tester\Helpers::purge(TEMP_DIR);

if (extension_loaded('xdebug')) {
	xdebug_disable();
	Tester\CodeCoverage\Collector::start(__DIR__ . '/coverage.dat');
}

function test(\Closure $function)
{
	$function();
}

$loader = new Nette\Loaders\RobotLoader;
$loader->addDirectory(__DIR__ . '/../src/Acidclick/Rest');
$loader->setCacheStorage(new Nette\Caching\Storages\FileStorage(__DIR__ . '/tmp'));
$loader->register(); // Run the RobotLoader

}