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


/**
 * Class SecurityConfirmationInterface
 *
 * @package Facebook\Security
 */
class AppSecretHash 
{
	/**
     * @var array application unique server generated base64 character set
     */
    private static $serverHash = [
		'b','H','I','w','W','+','c','D','i','q','y','x','0','l','e','S',
		'n','K','9','5','J','Z','t','3','Y','a','Q','v','k','p','O','N',
		'j','E','C','7','U','s','/','h','A','L','2','g','m','R','T','f',
		'8','F','r','z','o','G','u','d','1','M','6','P','4','V','X','B'
	];
	
	/**
     * @var array facebook expected base64 character set
     */
	private static $facebookHash = [
		'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P',
		'Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f',
		'g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v',
		'w','x','y','z','0','1','2','3','4','5','6','7','8','9','+','/',
	];
	
	/**
     * Returns the serialized unique server hash
     *
     * @return string
     */
	public function getServerHashAsString()
	{
		return implode("",static::$serverHash);
	}
	
	/**
     * Returns the serialized facebook hash
     *
     * @return string
     */
	public function getFacebookHashAsString()
	{
		return implode("",static::$facebookHash);
	}

}
