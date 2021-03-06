<?php namespace PAM4;

use PAM4\DI;

class Sdk {

    private $baseURL;
    private $appId;
    private $appSecret;

    public function __construct($baseURL, $appId='', $appSecret=''){
        $this->baseURL = $baseURL;
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    public function sendEvent($event, $params = [], $tags = '') {
        // Call api and return response from api synchronously

        /** @var \PAM4\Http\HttpRequest $rqt */
        $rqt = DI::getInstance()->getService(DI::SERVICEID_HTTPREQUEST);
	    $rqt->init($this->baseURL . "/trackers/events");

	    $options = [];

	    $headers = [
		    "Content-Type: application/json",
		    $this->createAuthHeader($this->appId, $this->appSecret),
		    $this->createCookiesHttpHeader()
	    ];
	    if ($headers && !empty($headers)) {
		    $options[CURLOPT_HTTPHEADER] = $headers;
	    }

	    $postData = [
	    	"event" => $event,
	        "form_fields" => $params,
		    "tags" => $tags
	    ];
	    if ($postData && !empty($postData)) {
		    $options[CURLOPT_POST] = true;
		    $options[CURLOPT_POSTFIELDS] = json_encode($postData);
	    }

	    $options[CURLOPT_RETURNTRANSFER] = true;
	    $options[CURLOPT_SSL_VERIFYHOST] = false;
	    $options[CURLOPT_SSL_VERIFYPEER] = false;
	    $options[CURLOPT_CONNECTTIMEOUT] = 5;

	    $rqt->setOptions($options);

	    $data = $rqt->execute();
	    $rqt->close();

        return json_decode($data, true);
    }

	private function createAuthHeader($appId, $appSecret)
	{
		return "Authorization: Basic " . base64_encode($appId.':'.$appSecret);
	}

	private function createCookiesHttpHeader()
	{
		/** @var \PAM\Http\HttpCookie $httpCookie */
		$httpCookie = DI::getInstance()->getService(DI::SERVICEID_HTTPCOOKIE);
		$allCookies = $httpCookie->getAll();
		$cookiesString = http_build_query($allCookies);
		return "Cookie: ".$cookiesString;
	}
}