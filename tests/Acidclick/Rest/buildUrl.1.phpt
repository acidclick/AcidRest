<?php

require __DIR__ . '/../../bootstrap.php';

use Tester\Assert,
	Acidclick\Rest\Fluent;

$url = 'http://www.example.com';

$fluent = new Fluent($url);

Assert::exception(function() use ($fluent){ $fluent->buildUrl(); }, '\Exception');

Assert::same($fluent->get()->buildUrl(), 'http://www.example.com');

Assert::same($fluent->product(1)->buildUrl(), 'http://www.example.com/product/1');

Assert::same($fluent->review()->buildUrl(), 'http://www.example.com/product/1/review');