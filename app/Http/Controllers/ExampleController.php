<?php

namespace App\Http\Controllers;

use GuzzleHttp;
use Log;

class ExampleController extends Controller {
	public $accountid = "1";
	public $token;
	public $canvasUrl;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		//
		$this->token = env ( 'API_TOKEN' );
		$this->canvasUrl = env ( 'CANVAS_URL' );
		Log::debug ( $this->token );
		Log::debug ( $this->canvasUrl );
	}
	public function setupUser() {
		return response ()->json ( $this->getUser () );
	}
	private function getUser() {
		$client = new GuzzleHttp\Client ();
		$res = $client->request ( 'GET', $this->getUrl ( '/api/v1/accounts/%s/users' ), [ 
				'headers' => [ 
						'Authorization' => 'Bearer ' . $this->token 
				] 
		] );
		return json_encode ( $res->getBody () );
	}
	private function getAccounts() {
		$client = new GuzzleHttp\Client ();
		$res = $client->request ( 'GET', $this->getUrl ( '/api/v1/accounts' ), [ 
				'headers' => [ 
						'Authorization' => 'Bearer ' . $this->token 
				] 
		] );
		return json_encode ( $res->getBody () );
	}
	private function getSingleAccount() {
		$client = new GuzzleHttp\Client ();
		$res = $client->request ( 'GET', $this->getUrl ( '/api/v1/accounts/%s' ), [ 
				'headers' => [ 
						'Authorization' => 'Bearer ' . $this->token 
				] 
		] );
		return json_encode ( $res->getBody () );
	}
	private function getUrl($url) {
		return $this->canvasUrl . sprintf ( $url, $this->accountid );
	}
	//
}

