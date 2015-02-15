# AcidRest

Simple REST API fluent PHP library

## Basic usage
```php
	$f = new Acidclick\Rest\Fluent('http://url/api');

	// retrieve product with id = 1 -> http://url/api/product/1?token=123456
	$f->query('token', '123456')->get()->product(1)->execute();

	// insert product
	$f->query('token', '123456')->post()->product()->body(['name' => 'Test'])->execute();

	// update product
	$f->query('token', '123456')->put()->product(1)->body(['name' => 'Test1'])->execute();
	$f->query('token', '123456')->post()->product(1)->body(['name' => 'Test1'])->execute();	

	// delete product
	$f->query('token', '123456')->delete()->product(1)->execute();

	// get product reviews -> http://url/api/product/1/review?token=123456
	$f->query('token', '123456')->get()->product(1)->review()->execute();

	// add product review
	$f->query('token', '123456')->post()->product(1)->review()->body(['from' => 'Thomas', 'text' => 'Great product'])->execute();
```

## Warning
Requires Guzzle.