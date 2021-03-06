<?php

namespace SalvatoreEckel\T3cms\Controller;

/**
 * This file is part of the "T3cms" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use TYPO3\CMS\Backend\Backend\Avatar\Avatar;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use SalvatoreEckel\T3cms\Utility\ExtensionUtility;
use SalvatoreEckel\T3cms\Utility\QueryUtility;

/**
 * WorkerController
 */
class WorkerController extends AbstractController {
    # id of selected page
    protected $id;
 
    protected function initializeAction() {
        $this->id = (int)GeneralUtility::_GP('id');
        # $configurationManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\BackendConfigurationManager');
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

		$pageRepository = $this->objectManager->get('TYPO3\\CMS\\Frontend\\Page\\PageRepository');
		# Change this
		$pageUid = intval($GLOBALS['_GET']['id']);

		if ($pageUid) {
			$rootLine = $pageRepository->getRootline($pageUid);
			if (count($rootLine)) {
				$currentPage = $rootLine[(count($rootLine)-1)];
			}
		}

	# Pages Count
		$pagesCountAll = QueryUtility::countAllPages();
	# Get loaded t3themes_* extensions keys
		$loadedThemes = ExtensionUtility::getLoadedExtensions( ['t3themes_'] , TRUE );
		$loadedSeoExtensions = ExtensionUtility::getLoadedExtensions( ['mindshape_seo','yoast_seo','ce_seo','metaseo'] );
		$fluxLoaded = ExtensionUtility::getLoadedExtensions( ['flux'] );
		$loadedContents = ExtensionUtility::getLoadedExtensions( ['t3content_'] , TRUE );

    	$this->view->assignMultiple([
    		'pagesCountAll' => $pagesCountAll,
    		'loadedThemes' => $loadedThemes,
    		'loadedContents' => $loadedContents,
    		'fluxLoaded' => $fluxLoaded,
    		'loadedSeoExtensions' => $loadedSeoExtensions,
    		'beUser' => $beUser,
    		'beUserCountAll' => $beUserCountAll,
    		'currentPage' => $currentPage,
    	]);
	}

	/**
	 * configAction
	 *
	 * @return void
	 */
	public function configAction()
	{
        $beUser = $this->backendUserRepository->findByUid(intval($GLOBALS['BE_USER']->user['uid']));
		#$moduleUrl = GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL');

		$pageUid = $this->id;

        $currentPage = QueryUtility::getPageByUid($pageUid);

    	$this->view->assignMultiple([
    		'showSearch' => TRUE,
    		'beUser' => $beUser,
    		'currentPage' => $currentPage
    	]);
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

}