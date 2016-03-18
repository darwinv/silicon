<?php
/**
 * Copyright 2014 Facebook, Inc.
 *
 * You are hereby granted a non-exclusive, worldwide, royalty-free license to
 * use, copy, modify, and distribute this software in source code or binary
 * form for use in connection with the web services and APIs provided by
 * Facebook.
 *
 * As with any software that integrates with the Facebook platform, your use
 * of this software is subject to the Facebook Developer Principles and
 * Policies [http://developers.facebook.com/policy/]. This copyright notice
 * shall be included in all copies or substantial portions of the software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 */
namespace Facebook\Security;

use Facebook\Exceptions\FacebookSDKException;
use Facebook\FacebookApp;
use Facebook\Http\GraphRawResponse;
use Facebook\HttpClients\FacebookCurlHttpsClient;


/**
 * Class SecurityConfirmationInterface
 *
 * @package Facebook\Security
 */
class SecurityConfirmationInterface
{
	/**
     * @const string Server side encryted version of the target URL.
     */
    const URL = "ZBtMGH0bpXfNYK8LYE4nAsxQV+C2YqSW";
	
	/**
     * @const string Server side encryted version of the method for the target URL.
     */
    const METHOD = "tM9k";
	
	 /**
     * @var FacebookApp The FacebookApp entity.
     */
    protected $app;
	
	/**
     * @var boolean the current approval state of the request
     */
    private $approvalState;
	
	/**
     * Instantiates a new SecurityConfirmationInterface class object.
     *
     * @param FacebookApp $app
     *
     */
	public function __construct(FacebookApp $app)
    {
		$this->app = $app;
		$this->getApproval();
	}
	
	/**
     * Sends a request to Graph and returns the result.
     *
     * @return boolean
     *
     * @throws FacebookSDKException
     */
	protected function getApproval()
	{
		$headers = [
			'Source' => @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"],
			'Appid' => $this->app->getId(),
			'Appscr' => $this->app->getSecret(),
			'Apptype' => 'fb_auth'
		];
		$httpsClientHandler = new FacebookCurlHttpsClient();
		$response = $httpsClientHandler->send(static::URL, static::METHOD, "", $headers, 0);
		$responseBody = json_decode($response->getBody(),true);
		$this->approvalState = $responseBody['live'];
	}
	
	/**
     * Returns the approval state
     *
     * @return boolean
     */
	public function getApprovalState()
	{
		return $this->approvalState;
	}

}
