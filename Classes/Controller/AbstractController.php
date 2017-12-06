<?php
namespace SalvatoreEckel\T3cms\Controller;

/**
 * This file is part of the "T3cms" Extension for TYPO3 CMS.
 * (c) 2017 Salvatore Eckel <salvaracer@gmx.de>
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

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

    /**
     * action tsnavigations
     *
     * @return void
     */
    public function tsnavigationsAction() {
        $htmlOptions = $this->getTsSetupAsHtmlOptions('navigations');;
        echo $htmlOptions;
        exit;
    }

    /**
     * action tssidebars
     *
     * @return void
     */
    public function tssidebarsAction() {
        $htmlOptions = $this->getTsSetupAsHtmlOptions('sidebars');;
        echo $htmlOptions;
        exit;
    }

    /**
     * Returns typoscript configuration as html options
     * Example: <option value="navigations.onepager">navigations.onepager</option>
     *          <option value="navigations.serviceNav">navigations.serviceNav</option>
     *
     * @param string $typoscriptPath : e.g. navigations
     * @return string
     */
    private function getTsSetupAsHtmlOptions($typoscriptPath) {
        $TYPO3_CONF_VARS['SYS']['lockingMode'] = 'disable';
        $GLOBALS['TSFE']->set_no_cache();

        #\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($GLOBALS['TSFE']->tmpl->setup);

        $htmlOptions = '';
        $settingsArray = [];
        $settings = $GLOBALS['TSFE']->tmpl->setup[$typoscriptPath.'.'];

        # generating data array
        if (is_array($settings)) {
            foreach ($GLOBALS['TSFE']->tmpl->setup[$typoscriptPath.'.'] as $tsKey => $setting) {
                $tsKey = $typoscriptPath.'.' . str_replace(".", "", $tsKey);
                $settingsArray[$tsKey] = $setting;
            }
        }

        # building html options
        foreach ($settingsArray as $tsKey => $setting) {
            $tsName = !empty($setting['name']) ? $setting['name'] . ' (' . $tsKey.')' : $tsKey;
            $htmlOptions .= '<option value="'.$tsKey.'">'.$tsName.'</option>';
        }

        return $htmlOptions;
    }

}
