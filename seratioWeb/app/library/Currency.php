<?php

	class Currency
	{

		public static function convert($country) {

			$client = new GuzzleHttp\Client();

			//$res = $client->get('https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20csv%20where%20url%3D%22http%3A%2F%2Ffinance.yahoo.com%2Fd%2Fquotes.csv%3Fe%3D.csv%26f%3Dc4l1%26s%3D'.$country.'GBP%3DX%22%3B&format=json&diagnostics=true&callback='
			$res = $client->get('http://apilayer.net/api/live?access_key=1677e583a0225849c9cf9ea1e823af3f&currencies=GBP&source='.$country.'&format=1'
			);

			$body = $res->getBody();

			$body = json_decode($body, true);

			if($body['success']) {
				$exchange = $country.'GBP';
				$data = $body['quotes'];
				$data = array_values($data);
				$rate = $data[0];
				if($rate && $rate > 0) {
					return $rate;
				} else {
					return 0;
				}
			}
		}
	}
