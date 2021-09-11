<?php
require './vendor/autoload.php';

class SimpleJsonRequest
{
    private static function makeRequest(string $method, string $url, array $parameters = null, array $data = null, string $key)
    {

        $redis = new Predis\Client()

        $opts = [
            'http' => [
                'method' => $method,
                'header' => 'Content-type: application/json',
                'content' => $data ? json_encode($data) : null
            ]
        ];

        $url .= ($parameters ? '?' . http_build_query($parameters) : '');

		//check key isEmpty
        if (!$redis->get($key)) {
            if($method == 'GET'){
				//cache data
                $redis->set($key, json_encode(file_get_contents($url, false, stream_context_create($opts))));
            }else{
				//remove cache data
                $redis->delete($key);
            }
            $redis->expire($key, 10);
            return file_get_contents($url, false, stream_context_create($opts));
        } else {
			//return cache data
            return json_decode($redis->get($key));
        }

    }

    public static function get(string $url, array $parameters = null, array $data = null, string $key)
    {
        return json_decode(self::makeRequest('GET', $url, $parameters, $data, $key));
    }

    public static function post(string $url, array $parameters = null, array $data, string $key)
    {
        return json_decode(self::makeRequest('POST', $url, $parameters, $data, $key));
    }

    public static function put(string $url, array $parameters = null, array $data, string $key)
    {
        return json_decode(self::makeRequest('PUT', $url, $parameters, $data, $key));
    }

    public static function patch(string $url, array $parameters = null, array $data, string $key)
    {
        return json_decode(self::makeRequest('PATCH', $url, $parameters, $data, $key));
    }

    public static function delete(string $url, array $parameters = null, array $data = null, string $key)
    {
        return json_decode(self::makeRequest('DELETE', $url, $parameters, $data, $key));
    }
}
