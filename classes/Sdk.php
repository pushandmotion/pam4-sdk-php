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

    public function sendEvent($event, $params = [], $tags = []) {
        // Call api and return response from api synchronously

        /** @var \PAM4\Http\HttpRequest $rqt */
        $rqt = DI::getInstance()->getService(DI::SERVICEID_HTTPREQUEST);

        return [];
    }
}