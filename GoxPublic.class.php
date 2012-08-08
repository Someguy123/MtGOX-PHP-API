<?php
/**
 * @package MTGox API
 * @author Chris S AKA Someguy123
 * @version 0.2
 * @access public
 * @license http://www.opensource.org/licenses/LGPL-3.0
 */
 
class GoxPublic {
    /**
     * GoxPublic::mtgox_public_query()
     * 
     * This function is similar to the private mtgox_query
     * although, it does not require an API key to function.
     * 
     * The public API does not take any arguments so there is
     * no request parameter.
     * 
     * @param API Path $path
     * @return
     */
    function mtgox_public_query($path) {
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

		// run the query
		$res = curl_exec($ch);
        if ($res === false)
			throw new Exception('Could not get reply: ' . curl_error($ch));
		$dec = json_decode($res, true);
		if (!$dec)
			throw new Exception('Invalid data received, please make sure connection is working and requested API exists');
		return $dec;
    }
    
}