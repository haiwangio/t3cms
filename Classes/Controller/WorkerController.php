<?php

namespace SalvatoreEckel\T3cms\Controller;

use \TYPO3\CMS\Backend\Backend\Avatar\Avatar;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use \TYPO3\CMS\Core\Database\ConnectionPool;
#use \TYPO3\CMS\Core\Messaging\AbstractMessage;
use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * WorkerController
 */
class WorkerController extends AbstractController {
    // id of selected page
    protected $id;
 
    protected function initializeAction() {
        $this->id = (int)GeneralUtility::_GP('id');
        // $configurationManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\BackendConfigurationManager');
    }

	/**
	 * dashboardAction
	 *
	 * @return void
	 */
	public function dashboardAction()
	{
        $beUser = $this->backendUserRepository->findByUid(intval($GLOBALS['BE_USER']->user['uid']));
        $beUserCountAll = $this->backendUserRepository->countAll();

		#$moduleUrl = GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL');
		$baseUrl = 'http://'.$_SERVER['SERVER_NAME'].'/';

		$pageRepository = $this->objectManager->get('TYPO3\\CMS\\Frontend\\Page\\PageRepository');
		# Change this
		$pageUid = intval($GLOBALS['_GET']['id']);

		if ($pageUid) {
			$rootLine = $pageRepository->getRootline($pageUid);
			if (count($rootLine)) {
				$currentPage = $rootLine[(count($rootLine)-1)];
			}
		}

		/* Pages Count */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
		$pagesCountAll = $queryBuilder
		   ->count('uid')
		   ->from('pages')
		   // ->where()
		   ->execute()
		   ->fetchColumn(0);

	# Get loaded t3themes_* extensions keys
		$loadedThemes = [];
		foreach (scandir(PATH_typo3conf . 'ext/') as $key => $localExtKey) {
		    if ((preg_match('/t3themes_/i', $localExtKey)) || $localExtKey == 't3themes') {
		    	if (ExtensionManagementUtility::isLoaded($localExtKey)) {
					$loadedThemes[$localExtKey] = $localExtKey;
		    	}
		    }
		}
		unset($loadedThemes['t3themes']);

    	$this->view->assign('pagesCountAll', $pagesCountAll);
    	$this->view->assign('loadedThemes', $loadedThemes);
    	$this->view->assign('beUser', $beUser);
    	$this->view->assign('beUserCountAll', $beUserCountAll);
    	$this->view->assign('baseUrl', $baseUrl);
    	$this->view->assign('currentPage', $currentPage);
	}

	/**
	 * configAction
	 *
	 * @return void
	 */
	public function configAction()
	{
		$result = $this->get_web_page( 'http://' . $GLOBALS['_SERVER']['HTTP_HOST'] . '/?type=123456' );
		$navigationHtmlOptions = $result['content'];
		$result2 = $this->get_web_page( 'http://' . $GLOBALS['_SERVER']['HTTP_HOST'] . '/?type=123457' );
		$sidebarHtmlOptions = $result2['content'];

		$color = (isset($PA['parameters']['color'])) ? $PA['parameters']['color'] : 'red';

		$dbValue = json_decode($PA["itemFormElValue"],1);
		$settings = $dbValue;



        $beUser = $this->backendUserRepository->findByUid(intval($GLOBALS['BE_USER']->user['uid']));

		#$moduleUrl = GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL');

		# Change this
		$pageUid = intval($GLOBALS['_GET']['id']);

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $queryBuilder->getRestrictions()->removeAll();
        $currentPage = $queryBuilder
            ->select('*')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->eq(
                    'uid',
                    $queryBuilder->createNamedParameter($pageUid, \PDO::PARAM_INT)
                )
            )
            ->execute()
            ->fetch();

    	$this->view->assign('navigationHtmlOptions', $navigationHtmlOptions);
    	$this->view->assign('sidebarHtmlOptions', $sidebarHtmlOptions);
    	$this->view->assign('showSearch', TRUE);
    	$this->view->assign('beUser', $beUser);
    	$this->view->assign('currentPage', $currentPage);
	}

	/**
	 * action updateConfig
	 *
	 * @param int $uid
	 * @param string $t3themesConf
	 * @return void
	 */
	public function updateConfigAction($uid = 0, $t3themesConf = '')
	{
		header('Content-Type: application/json');

		$response = [];
		$response['status'] = 'warning';

		if (!empty($t3themesConf) && intval($uid) > 0) {
	        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
			// UPDATE `tt_content` SET `bodytext` = 'peter' WHERE `bodytext` = 'klaus'
			$queryBuilder
			   ->update('pages')
			   ->where(
			      $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid))
			   )
			   ->set('t3themes_conf', $t3themesConf)
			   ->execute();

			$response['status'] = 'success';
			$response['message'] = 'Successful saved!';
		} else {
			$response['status'] = 'error';
			$response['message'] = 'Something went wrong.';
		}

		echo json_encode($response);
		exit;
	}

	/**
	 * beUserProfileAction
	 *
	 * @return void
	 */
	public function beUserProfileAction()
	{
		$beUserUid = intval($GLOBALS['BE_USER']->user['uid']);

		#$moduleUrl = GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL');

        if ($beUserUid > 0) {
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('be_users');
            $queryBuilder->getRestrictions()->removeAll();
            $beUser = $queryBuilder
                ->select('*')
                ->from('be_users')
                ->where(
                    $queryBuilder->expr()->eq(
                        'uid',
                        $queryBuilder->createNamedParameter($beUserUid, \PDO::PARAM_INT)
                    )
                )
                ->execute()
                ->fetch();
        } else {
        	$beUser = $GLOBALS['BE_USER']->user;
    	}

    	$this->view->assign('t3version', TYPO3_version);
    	$this->view->assign('beUser', $beUser);
    	$this->view->assign('beUserCountAll', $beUserCountAll);
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

			CURLOPT_CUSTOMREQUEST 	=>"GET",		//set request type post or get
			CURLOPT_POST 			=> false,		//set to GET
			CURLOPT_USERAGENT 		=> $user_agent, //set user agent
			// CURLOPT_COOKIEFILE 	=>"cookie.txt", //set cookie file
			// CURLOPT_COOKIEJAR 	=>"cookie.txt", //set cookie jar
			CURLOPT_RETURNTRANSFER 	=> true, 	// return web page
			CURLOPT_HEADER 			=> false,	// don't return headers
			CURLOPT_FOLLOWLOCATION 	=> true, 	// follow redirects
			CURLOPT_ENCODING 		=> "", 		// handle all encodings
			CURLOPT_AUTOREFERER 	=> true, 	// set referer on redirect
			CURLOPT_CONNECTTIMEOUT 	=> 120,  	// timeout on connect
			CURLOPT_TIMEOUT 		=> 120,  	// timeout on response
			CURLOPT_MAXREDIRS 		=> 10,   	// stop after 10 redirects
		);

		$ch  		= curl_init( $url );
		curl_setopt_array( $ch, $options );
		$content 	= curl_exec( $ch );
		$err 		= curl_errno( $ch );
		$errmsg 	= curl_error( $ch );
		$header 	= curl_getinfo( $ch );
		curl_close( $ch );

		$header['errno']   = $err;
		$header['errmsg']  = $errmsg;
		$header['content'] = $content;
		return $header;
	}

}