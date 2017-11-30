<?php
namespace SalvatoreEckel\T3cms\Controller;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017 Salvatore Eckel <salvaracer@gmx.de>, ie
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * AbstractController
 */
class AbstractController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
	 * @inject
	 */
	protected $userRepository = NULL;

    /**
     * backendUserRepository
     *
     * @var \TYPO3\CMS\Extbase\Domain\Repository\BackendUserRepository
     * @inject
     */
    protected $backendUserRepository = NULL;

    /**
     * get web page with curl
     *
     * @param string $url
     * @return void
     */
    protected function get_web_page( $url )
    {
        $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

        $options = array(

            CURLOPT_CUSTOMREQUEST   =>"GET",        //set request type post or get
            CURLOPT_POST            => false,       //set to GET
            CURLOPT_USERAGENT       => $user_agent, //set user agent
            // CURLOPT_COOKIEFILE   =>"cookie.txt", //set cookie file
            // CURLOPT_COOKIEJAR    =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER  => true,    // return web page
            CURLOPT_HEADER          => false,   // don't return headers
            CURLOPT_FOLLOWLOCATION  => true,    // follow redirects
            CURLOPT_ENCODING        => "",      // handle all encodings
            CURLOPT_AUTOREFERER     => true,    // set referer on redirect
            CURLOPT_CONNECTTIMEOUT  => 120,     // timeout on connect
            CURLOPT_TIMEOUT         => 120,     // timeout on response
            CURLOPT_MAXREDIRS       => 10,      // stop after 10 redirects
        );

        $ch         = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content    = curl_exec( $ch );
        $err        = curl_errno( $ch );
        $errmsg     = curl_error( $ch );
        $header     = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header;
    }
}
