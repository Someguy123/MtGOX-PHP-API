<?php
/**
 * @package MTGox API
 * @author Chris S AKA Someguy123
 * @version 0.2
 * @access public
 * @license http://www.opensource.org/licenses/LGPL-3.0
 */
 
class GoxPrivate extends GoxPublic {
    private $key;
	private $secret;
    
	/**
	 * Gox::__construct()
	 * Sets required key and secret to allow the script to function
	 * @param MtGOX API Key $key
	 * @param MtGOX Secret $secret
	 * @return
	 */
	public function __construct($key, $secret)
	{
		if (isset($secret) && isset($key))
		{
			$this->key = $key;
			$this->secret = $secret;
		} else
			die("NO KEY/SECRET");
	}
	/**
	 * Gox::mtgox_query()
	 *
	 * @param API Path $path
	 * @param POST Data $req
	 * @return Array containing data returned from the API path
	 */
	public function mtgox_query($path, array $req = array())
	{
		// API settings
		$key = $this->key;
		$secret = $this->secret;

		// generate a nonce as microtime, with as-string handling to avoid problems with 32bits systems
		$mt = explode(' ', microtime());
		$req['nonce'] = $mt[1] . substr($mt[0], 2, 6);

		// generate the POST data string
		$post_data = http_build_query($req, '', '&');

		// generate the extra headers
		$headers = array(
			'Rest-Key: ' . $key,
			'Rest-Sign: ' . base64_encode(hash_hmac('sha512', $post_data, base64_decode($secret), true)),
			);

		// our curl handle (initialize if required)
		static $ch = null;
		if (is_null($ch))
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT,
				'Mozilla/4.0 (compatible; MtGox PHP client; ' . php_uname('s') . '; PHP/' .
				phpversion() . ')');
		}
		curl_setopt($ch, CURLOPT_URL, 'https://mtgox.com/api/' . $path);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		// run the query
		$res = curl_exec($ch);
		if ($res === false)
			throw new Exception('Could not get reply: ' . curl_error($ch));
		$dec = json_decode($res, true);
		if (!$dec)
			throw new Exception('Invalid data received, please make sure connection is working and requested API exists');
		return $dec;
	}

    /**
     * Gox::getInfo()
     * Returns information about your account, including funds, fees, and API priviledges
     * @return array $info['return']
     */
    function getInfo() {
        $info = $this->mtgox_query('1/generic/private/info');
        /**
         * In order to maintain compatibility with the previous API
         * wrapper, we're only returning the 'return' section of
         * the request.
         */
        return $info['return'];
    }
}
