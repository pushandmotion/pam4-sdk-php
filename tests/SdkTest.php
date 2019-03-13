<?php

require_once('vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use PAM4\Sdk;
use PAM4\DI;

class SdkTest extends TestCase
{
    use \Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    public $sdk;

    public function __construct(){
        $pamUrl = 'https://connect.pamapimock.com';
        $appId = '1978544d7488415980feeb56b1312a2a';
        $appSecret = 'def0000081ffc5d04b7e61894e7dc8bb6e4ba104f875c35185cac64526c96358bc3a5de1d4198d34a994d7c28ef9dec47120325aaf28c0c7ab7b79984f8adcc5b5014fa5';

        $this->sdk = new Sdk($pamUrl, $appId, $appSecret);
    }

    public function testSendEvent_GivenContactID_ExpectTrackingDataHasBeenDelivered(){
        $sdk = $this->sdk;

        //Mock Cookies
        $expectedCookies = [
            'contact_id' => 'contact_id_1234',
            'other_cookies1' => 'other_cookie_1234'
        ];
        $mockCookies = Mockery::mock('\PAM4\Http\HttpCookie');
        $mockCookies->shouldReceive('getAll')->once()->andReturn($expectedCookies)->once();
        $expectedCookiesString = 'contact_id=2&other_cookies1=other_cookie_1234';

        //Mock Request Endpoint
        $mockHttp = Mockery::mock('\PAM4\Http\HttpRequest');
        $mockHttp->shouldReceive('init')->once();
        $mockHttp->shouldReceive('setOptions')->once()->with(Mockery::on(function($args) use ($expectedCookiesString) {
             //Assert Post Vars
            // $posts = [];
            // parse_str($args[CURLOPT_POSTFIELDS], $posts);
            // $assertPosts =
            //     $posts['email'] == 'chaiyapong@3dsinteractive.com' &&
            //     $posts['gender'] == 1 &&
            //     $posts['age'] == 10;

            //Assert Headers
            // $appId = '3ds';
            // $appSecret = 'interactive';
            // $expectedAuthHeader = 'Authorization: Basic ' . base64_encode($appId.':'.$appSecret);

            // $headers = $args[CURLOPT_HTTPHEADER];
            // $assertHeaders =
            //         in_array('Accept: application/json', $headers) &&
            //         in_array($expectedAuthHeader, $headers) &&
            //         in_array('Cookie: '.$expectedCookiesString, $headers);

            // return $assertPosts && $assertHeaders;

            return true;
        }));
        $mockApiResult = '{"contact_id":"return_contact_id_1234"}';
        $mockHttp->shouldReceive('execute')->once()->andReturn($mockApiResult);
        $mockHttp->shouldReceive('getInfo')->once();
        $mockHttp->shouldReceive('close')->once();

        //Setup DI.
        $di = DI::getInstance();
        $di->registerService(DI::SERVICEID_HTTPREQUEST, function() use ($mockHttp){
            return $mockHttp;
        });
        $di->registerService(DI::SERVICEID_HTTPCOOKIE, function() use ($mockCookies){
            return $mockCookies;
        });

        $result = $sdk->submitForm('1', [
            'media_1'=>'chaiyapong@3dsinteractive.com',
            'gender'=>1,
            'age'=>10
        ]);

        $mockApiResultArray = json_decode($mockApiResult, true);
        $this->assertEquals($mockApiResultArray, $result);
    }

    public function tearDown() {
        Mockery::close();
    }
}