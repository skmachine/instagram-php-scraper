<?php
ini_set('display_errors', '1');
require __DIR__ . '/../vendor/autoload.php';

// media proxy is used to render <img> and <video> tags retrieved from Instagram, on your own website.
// if shown directly, media will not be displayed and in browser console the net::ERR_BLOCKED_BY_RESPONSE will be shown.
// so on your website, in html, instead of <img src="{{INSTAGRAM_IMG_URL}}" /> you put <img src="mediaProxy.php?url={{urlencode(INSTAGRAM_IMG_URL)}}" />

use InstagramScraper\MediaProxy;

$proxy = new MediaProxy(['allowedReferersRegex' => "/(yourwebsite\.com|anotherdomain\.com)$/"]);


$_GET = [];
$_GET['url'] = "https://scontent-hel3-1.cdninstagram.com/v/t51.2885-15/e35/262297699_616695756121153_4891415643549631829_n.jpg?_nc_ht=scontent-hel3-1.cdninstagram.com&_nc_cat=1&_nc_ohc=ywU85RlzlNUAX9hHG0S&edm=ABfd0MgBAAAA&ccb=7-4&oh=ca10a5414885b4bc803940d787a93e25&oe=61BC5C39&_nc_sid=7bff83";

// launch this file in browser - this will fail in CLI mode!
$proxy->handle($_GET, $_SERVER);
