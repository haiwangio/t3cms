<?php

namespace SalvatoreEckel\T3cms\Utility;

/**
 * This file is part of the "T3cms" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Utility to provide some tasks belonging to extensions
 */
class QueryUtility
{

    /**
     * Get the count of all pages
     *
     * @return int
     */
    public static function countAllPages()
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $pagesCountAll = $queryBuilder
           ->count('uid')
           ->from('pages')
           // ->where()
           ->execute()
           ->fetchColumn(0);

        return $pagesCountAll;
    }

    /**
     * Get the count of all pages
     *
     * @param int $uid
     * @return array
     */
    public static function getPageByUid($uid)
    {

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $queryBuilder->getRestrictions()->removeAll();
        $currentPage = $queryBuilder
            ->select('*')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->eq('uid',$queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT))
            )
            ->execute()
            ->fetch();

        return $currentPage;
    }

    /**
     * Get the count of all pages
     *
     * @param int $uid
     * @return array
     */
    public static function getBeUserByUid($uid)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('be_users');
        $queryBuilder->getRestrictions()->removeAll();
        $beUser = $queryBuilder
            ->select('*')
            ->from('be_users')
            ->where(
                $queryBuilder->expr()->eq('uid',$queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT))
            )
            ->execute()
            ->fetch();

        return $beUser;
    }
}
