<?php

namespace Acidclick\Rest;

use Nette,
	AcidORM,
	GuzzleHttp;

class Fluent
{

	private $url;
	private $token;

	private $types = [];
	private $method = null;
	private $ids = [];
	private $query = [];
	private $body = null;

	private $request = null;
	private $response = null;

	public function __construct($url)
	{
		$this->url = $url;
		$this->request = new GuzzleHttp\Client();
	}

	public static function create($url)
	{
		$fluent = new Fluent($url);
		return $fluent;
	}

	public function __call($name, $args)
	{
		if(in_array($name, ['get', 'post', 'put', 'delete'])){
			$this->method = $name;
			if(isset($args[0])) $this->ids[] = $args[0];
		} else if($name === 'query'){
			$this->query[$args[0]] = $args[1];
		} else if($name === 'body'){
			$body = $args[0];
			try{
				$body = (string)$args[0];
				if($body !== $args[0]) $body = json_encode($args[0]);
			} catch (\Exception $ex){
				$body = json_encode($args[0]);
			}
			$this->body = $args[0];
		} else {
			$this->types[] = $name;
			if(isset($args[0])) $this->ids[] = $args[0];
		}
		return $this;
	}

	public function execute()
	{
		$url = $this->buildUrl();
		$this->response = $this->request->{$this->method}($url, ['body' => $this->body, 'query' => $this->query]);
		return json_decode($this->response->getBody());
	}

	public function validate()
	{
		if($this->method === null){
			throw new \Exception('Missing method');
		}
	}

	public function buildUrl()
	{
		$this->validate();

		$url = $this->url;
		if(preg_match('/\/$/', $url)) $url = preg_replace('/\/$/', '', $url);
		foreach($this->types as $index => $type){
			$url .= '/' . $type;
			if(isset($this->ids[$index])) $url .= '/' . $this->ids[$index];
		}
		return $url;
	}

	public function getFullUrl()
	{
		return $this->buildUrl() . (!empty($this->query) ? '?' . http_build_query($this->query) : '');
	}

	public function getBody()
	{
		return $this->body;
	}

}