<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.8.0 (2013-03-18)
 * @info $Id: PlayerUtil.class.php 2773 2013-08-02 12:33:47Z slaver7 $
 * @link http://2moons.cc/
 */

class QueueManager
{
    private $userId;
    private $planetId;

    public function __construct($userId, $planetId)
    {
        $this->userId   = $userId;
        $this->planetId = $planetId;
    }

    public function add(Element $elementObj, $amount, $buildTime, $endBuildTime)
    {
        $sql = 'INSERT INTO %%QUEUE%% SET
        queueId         = :queueId,
        userId          = :userId,
        planetId        = :planetId,
        elementId       = :elementId,
        buildtime       = :buildtime,
        endBuildtime    = :endBuildtime,
        amount          = :amount;';

        return Database::get()->insert($sql, array(
            ':queueId'      => $elementObj->queueId,
            ':userId'       => $this->userId,
            ':planetId'     => $this->planetId,
            ':elementId'    => $elementObj->elementID,
            ':buildtime'    => $buildTime,
            ':endBuildtime' => $endBuildTime,
            ':amount'       => $amount,
        ));
    }

    public function remove($taskId)
    {

    }

    public function queryElementIds($elementIds)
    {
        $elementIds = (array) $elementIds;
        $elementIds = array_filter($elementIds, 'is_numeric');

        if(empty($elementIds))
        {
            throw new Exception('#1 argument of QueueManager::queryElementIds can not be empty!');
        }

        $sql    = 'SELECT * FROM %%QUEUE%% WHERE userId = :userId AND planetID = :planetId AND elementId IN ('.implode(',', $elementIds).') ORDER BY taskId ASC;';

        return Database::get()->select($sql, array(
            ':userId'       => $this->userId,
            ':planetId'     => $this->planetId,
        ));
    }

    public function queryQueueIds($queueId)
    {
        $queueId = (array) $queueId;
        $queueId = array_filter($queueId, 'is_numeric');

        $sql    = 'SELECT * FROM %%QUEUE%% WHERE userId = :userId AND planetID = :planetId AND queueId IN ('.implode(',', $queueId).') ORDER BY taskId DESC;';

        return Database::get()->select($sql, array(
            ':userId'       => $this->userId,
            ':planetId'     => $this->planetId,
        ));
    }

    public function getReadyTaskInQueues($toTime = NULL)
    {
        if(is_null($toTime))
        {
            $toTime = TIMESTAMP;
        }

        $sql = 'SELECT queueId
        FROM  `uni1_queue`
        WHERE userId = :userId AND endBuildtime <= :timestamp
        GROUP BY queueId
        ORDER BY taskId ASC;';

        return Database::get()->select($sql, array(
            ':userId'       => $this->userId,
            ':timestamp'    => $toTime,
        ));
    }
}