<?php
	//	Curl Domain
	//	Get Data from Url using Curl
	//	@param url, String
	//	@param params, Array
	//	@return curl response
	if (! function_exists('curl_domain')) {
		function curl_domain($url, $params = []){
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url);
		    /*curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);*/
		    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		    curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT_MS, 20200);

		    if ( ! empty($params))
		    	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

			//set_time_limit(30);

			$result = curl_exec($ch);
			curl_close($ch);

			return $result;
		}
	}
?>