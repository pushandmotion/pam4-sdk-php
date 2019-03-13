<?php namespace PAM;

use PAM4\Http\HttpRequest;
use PAM4\Http\HttpServer;
use PAM4\REST\Event;

class Sdk {

    private $baseURL;
    private $appId;
    private $appSecret;
    private $di;

    public function __construct($baseURL, $appId='', $appSecret=''){
        $this->baseURL = $baseURL;
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    public function sendEvent($event, $tags = [], $params = []) {
        // Call api and return response from api synchronously
        return [];
    }
}