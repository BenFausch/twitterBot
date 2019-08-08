<?php
require_once '.private-keys.php';
date_default_timezone_set('America/Denver');
require "twitteroauth/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

function getConnectionWithAccessToken($oauth_token, $oauth_token_secret)
{
    $connection = new TwitterOAuth(Twitter_auth::twitter_oauth, Twitter_auth::twitter_oauth_secret, $oauth_token, $oauth_token_secret);
    
    return $connection;
}

$connection = getConnectionWithAccessToken(Twitter_auth::oauth_token, Twitter_auth::oauth_token_secret);

$bookmarks_file = file_get_contents("/home/benfausch/webapps/twitterbot/chrome_bookmarks.json");
$bookmarks      = json_decode($bookmarks_file, true);

function build_tweet($bookmarks, $connection)
{
    $random_bookmark = array_rand($bookmarks);

    if (!empty($bookmarks[$random_bookmark]['title']) && !empty($bookmarks[$random_bookmark]['url']) && $bookmarks[$random_bookmark]['parentId'] == 234) {
        // $short = shorten_link($bookmarks[$random_bookmark]['url']);
        $tweet = $bookmarks[$random_bookmark]['title'] . ' #webdev #php #js ' . $bookmarks[$random_bookmark]['url'];
        send_tweet($tweet, $connection);
    } else {
        echo 'Trying again';
        build_tweet($bookmarks, $connection);
    }
}

build_tweet($bookmarks, $connection);

function send_tweet($tweet, $connection)
{

    $content = $connection->post("statuses/update", ["status" => $tweet]);

    $errors = $content->errors;

    if (!empty($errors)) {
        $errormsg = $errors[0]->message;
        error_log('there was an error yo' . $errormsg);
    } else {
        $timestamp = $content->created_at;
        $tweet     = $content->text;

        echo ('yo dawg you tweeted at: ' . $timestamp . ' : ' . $tweet . '');
    }

}

function shorten_link($link)
{
    $api_key = Google_shorten::google_url;

    $cmd = "curl https://www.googleapis.com/urlshortener/v1/url?key=" . $api_key . " \
  -H 'Content-Type: application/json' \
  -d '{
    \"longUrl\": \"" . $link . "\"
  }'";
    exec($cmd, $result);

    $result_json = '';
    foreach ($result as $r) {
        $result_json .= $r;
    }
    $result_json = json_decode($result_json, true);

    return $result_json['id'];

}
