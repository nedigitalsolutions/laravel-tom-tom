<?php namespace Hirealite\LaravelTomTom;

use GuzzleHttp;
use GuzzleHttp\Handler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\ResponseInterface;

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

	public function showObjectReport($opts = [])
	{
		$response = $this->client->get('', [
			'query' => array_merge([
				'action' => 'showObjectReportExtern'
			], $opts)
		]);

		$this->checkErrors($response);

		return $this->formatResponse($response);
	}

	public function showVehicleReport($opts = [])
	{
		$response = $this->client->get('', [
			'query' => array_merge([
				'action' => 'showVehicleReportExtern'
			], $opts)
		]);

		$this->checkErrors($response);

		return $this->formatResponse($response);
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
			'handler' => $stack
		]);
	}

	/**
	 * Private clone method to prevent cloning of the instance of the
	 * *Singleton* instance.
	 *
	 * @return void
	 */
	private function __clone() {}

	private function checkErrors(ResponseInterface $response)
	{
		$headers = $response->getHeaders();

		if(isset($headers['X-Webfleet-Errorcode'])) {
			throw new TomTomException($headers['X-Webfleet-Errormessage'][0], (float) $headers['X-Webfleet-Errorcode'][0]);
		}
	}

	private function formatResponse(ResponseInterface $response)
	{
		return json_decode($response->getBody()->getContents());
	}

}

class TomTomException extends \Exception {};
