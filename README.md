# PamSdk-PHP
Client SDK to access PAM

## Requirements

 * PHP 5.6.0+

## Installation

 1. Include `pam4-sdk` library into your project

 1. Include the Composer autoloader:

    ```php
    require_once('pam4-sdk-php/vendor/autoload.php');
    ```
    
 1. Use PAM-SDK and create instance of SDK connection:
      
    ```
    use PAM4\Sdk;
        
    $pamUrl = 'https://pam4-stg-connect.sitespad.com';
    $appId = 'APP_ID';
    $appSecret = 'APP_SECRET';
        
    $sdk = new Sdk($pamUrl, $appId, $appSecret);
    ```
    
## Usage

### Install PAM script (Track page view)

 1. Add PAM Script on your HTML page (generate script from PAM CMS)
    
    ```html
    <!-- Pam4 Tracker -->
    <script>
    (function(d,t,sc,opt){var s=d.createElement(t);s.type='text/javascript';s.async=true;s.src=sc;
    s.onload=s.onreadystatechange=function(){var rs = this.readyState;if(rs)if(rs!='complete')if(rs!='loaded')return;
    try{window.pam=new pam4Tracker(opt);}catch(e){}};var x = d.getElementsByTagName(t)[0];x.parentNode.insertBefore(s, x);
    })(document, 'script', 'https://YOUR_SCRIPT_DOMAIN/YOUR_PATH/pam4-tracker.umd.js', {
    iframeOrigin: 'https://YOUR_IFRAME_DOMAIN/YOUR_PATH',
    trackerApi: 'https://YOUR_TRACKER_DOMAIN/trackers/events'
    });
    </script>
    <!-- End Pam4 Tracker -->
    ```
  
 1. After install the script in HTML page then verify the script by inspecting the network request from your browser when load page; you will see the POST request /events call with JSON response contact_id
     
     
### Make Form Submit

When you receive form submission from your website, you can forward those form data to PAM by calling `sendEvent($event, $params = [], $tags = '')` method

```php 
$result = $sdk->sendEvent(
  "event_name",
  [
    "key1" => "value1",
    "key2" => "value2"
  ],
  "tag1,tag2,tag3"
);
```
