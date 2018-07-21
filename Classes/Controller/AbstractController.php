<?php
namespace SalvatoreEckel\T3cms\Controller;

/**
 * This file is part of the "T3cms" Extension for TYPO3 CMS.
 * (c) 2017-2018 Salvatore Eckel <salvaracer@gmx.de>
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

}
