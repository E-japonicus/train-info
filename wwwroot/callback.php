<?php // callback.php
define("LINE_MESSAGING_API_CHANNEL_SECRET", '46afb0ed09143f10ae194e7518658a3f');
define("LINE_MESSAGING_API_CHANNEL_TOKEN", 'sGBhsJYSplyvorJ3rePgiB/EFumwMJeiNIC8Rn6+CxacsRESoUOwNPPfctkBOs9rit0v69cXI0Ev5q/CmLfMzgZfJbVzL69eOf6p5prDe2blB4irpKbTlLKhjLX3082z37NpWsv9vhFVFvW3IXr32QdB04t89/1O/w1cDnyilFU=');

require __DIR__."/../vendor/autoload.php";

$bot = new \LINE\LINEBot(
    new \LINE\LINEBot\HTTPClient\CurlHTTPClient(LINE_MESSAGING_API_CHANNEL_TOKEN),
    ['channelSecret' => LINE_MESSAGING_API_CHANNEL_SECRET]
);

$signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
$body = file_get_contents("php://input");

$events = $bot->parseEventRequest($body, $signature);

foreach ($events as $event) {
    if ($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage) {
        $reply_token = $event->getReplyToken();
        $text = $event->getText();
        $bot->replyText($reply_token, $text);
    }
}

echo "OK";