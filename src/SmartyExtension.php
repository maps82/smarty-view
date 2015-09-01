<?php

namespace Slim\Views;

class SmartyExtension
{
	/**
	 * @var \Slim\Interfaces\RouterInterface
	 */
	private $router;

	/**
	 * @var string|\Slim\Http\Uri
	 */
	private $uri;

	public function __construct($router, $uri)
	{
		$this->router = $router;
		$this->uri = $uri;
	}

	public function getPlugins()
	{
		return [
			'path_for' => [
				'type' => 'function',
				'callback' => array($this, 'pathFor')
			],
			'base_url' => [
				'type' => 'function',
				'callback' => array($this, 'baseUrl')
			]
		];
	}

	public function pathFor($args)
	{
		$name = $args['name'];
		$data = isset($args['options']) ? $args['options'] : [];
		$queryParams =  isset($args['queryParams']) ? $args['queryParams'] : [];
		return $this->router->pathFor($name, $data, $queryParams);
	}

	public function baseUrl()
	{
		if (is_string($this->uri))
		{
			return $this->uri;
		}
		if (method_exists($this->uri, 'getBaseUrl'))
		{
			return $this->uri->getBaseUrl();
		}
	}
}
