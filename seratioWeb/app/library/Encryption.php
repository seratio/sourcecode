<?php
class Encryption
{
	public static function encrypt($id)
	{
		$data  =	base64_encode(base64_encode($id));
		return $data;
	}

	public static function decrypt($id)
	{
		$data  =	base64_decode(base64_decode($id));
		return $data;
	}

	public static function generateShortUrl($id){
		$host 	= "http://seratio.com";
		//$host = "http://localhost:8000";
		$longUrl 		=	$host."//feedbacks?token=".$id;

		$apiKey = 'AIzaSyBPaT0zSW-VSJeFIiovMlJbMn7bo4VB4Aw';
		$postData = array('longUrl' => $longUrl, 'key' => $apiKey);
		$jsonData = json_encode($postData);
		$curlObj = curl_init();
		curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url?key='.$apiKey);
		curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curlObj, CURLOPT_HEADER, 0);
		curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
		curl_setopt($curlObj, CURLOPT_POST, 1);
		curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);
		$response = curl_exec($curlObj);
		$json = json_decode($response);
		curl_close($curlObj);

	 return $json->id;

	}
}
