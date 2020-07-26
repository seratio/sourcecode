<?php
class Personalvalue
{
	public static function calculate($name, $comment)
	{
		$data = 
		'<?xml version="1.0"?>
		<root>
		<apikey>srjf7506SRsrjfSR</apikey>
		<QueryItems>
		<query>
		<id></id>
		<brandname><![CDATA['.$name.']]></brandname>
		<paragraph><![CDATA['.$comment.']]></paragraph>
		</query>
		</QueryItems>
		</root>';

		$client = new SoapClient('http://api.sentimentanalysisonline.com/sentimentscore.asmx?WSDL');
		$r = $client->getScore((object)array('searchXML' => $data));
		return $r;
	}	
}