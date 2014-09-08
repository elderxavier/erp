<?php

/**
 * Class Pagination
 * Helper for pagination
 */
class Pagination
{
    /**
     * Calculates count of pages by total record count and count on one page
     * @param int $totalRecords
     * @param int $onOnePage
     * @return int
     */
    public static function calcPagesCount($totalRecords,$onOnePage)
    {
        return (int)ceil($totalRecords/$onOnePage);
    }

    /**
     * Calculates offset for DB
     * @param int $onOnePage
     * @param int $currentPage
     * @return int
     */
    public static function calcOffset($onOnePage,$currentPage)
    {
        return (int)($onOnePage * ($currentPage - 1));
    }

    /**
     * Returns criteria with pagination options
     * @param int $onOnePage
     * @param int $currentPage
     * @param CDbCriteria|null $c
     * @return CDbCriteria
     */
    public static function getFilterCriteria($onOnePage,$currentPage, $c = null)
    {
        /* @var $criteria CDbCriteria */

        //if criteria not set - create new empty criteria
        !empty($c) ? $criteria = $c : $criteria = new CDbCriteria();

        //update criteria with params
        $criteria -> limit = $onOnePage;
        $criteria -> offset = self::calcOffset($onOnePage,$currentPage);

        //return updated
        return $criteria;
    }
}