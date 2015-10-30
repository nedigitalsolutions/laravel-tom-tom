<?php namespace Hirealite\LaravelTomTom;

use GuzzleHttp;
use GuzzleHttp\Handler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Psr7\Uri;

class TomTomAPI
{
	private static $instance;

	private $client;
	private $default_queries = [];

	public static function getInstance()
	{
		if (static::$instance == null)
			static::$instance = new static();

		return static::$instance;
	}

	public function createSession()
	{

		return $this->client->get('', [
			'action' => 'createSession'
		]);
	}

	public function showUsers()
	{
		return $this->client->get('', [
			'query' => [
				'action' => 'showObjectReportExtern'
			]
		]);
	}

	public function showOrderReport()
	{
		return $this->client->get('', [
			'query' => [
				'action' => 'showOrderReportExtern',
				'range_pattern' => 'w-1'
			]
		]);
	}

	public function queryValueMiddleware($key, $value)
	{
		return Middleware::mapRequest(function (RequestInterface $request) use ($key, $value) {
			return $request->withUri(Uri::withQueryValue($request->getUri(), $key, $value));
		});
	}

	/**
	 * Protected constructor to prevent creating a new instance of the
	 * *Singleton* via the `new` operator from outside of this class.
	 */
	protected function __construct() {
		$this->default_queries = [
			'account' => \Config::get("laravel-tom-tom::account"),
			'username' => \Config::get("laravel-tom-tom::username"),
			'password' => \Config::get("laravel-tom-tom::password"),
			'apikey' => \Config::get("laravel-tom-tom::apikey"),
			'lang' => 'en',
			'outputformat' => 'json'
		];

		$stack = HandlerStack::create(new Handler\CurlHandler());

		foreach($this->default_queries as $key => $value) {
			$stack->push($this->queryValueMiddleware($key, $value));
		}

		$this->client = new GuzzleHttp\Client([
			'base_uri' => \Config::get("laravel-tom-tom::base_url"),
			'handler' => $stack,
		]);
	}

	/**
	 * Private clone method to prevent cloning of the instance of the
	 * *Singleton* instance.
	 *
	 * @return void
	 */
	private function __clone() {}

	/**
	 * Private unserialize method to prevent unserializing of the *Singleton*
	 * instance.
	 *
	 * @return void
	 */
	private function __wakeup() {}

}
