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

    const BUILD     = 1;
    const DESTROY   = 2;
    const USER      = 3;
    const SHIPYARD  = 4;

    public function __construct($userId, $planetId)
    {
        $this->userId   = $userId;
        $this->planetId = $planetId;
    }

    public function add(Element $elementObj, $amount, $buildTime, $endBuildTime, $taskType)
    {
        $sql = 'INSERT INTO %%QUEUE%% SET
        queueId         = :queueId,
        userId          = :userId,
        planetId        = :planetId,
        elementId       = :elementId,
        buildTime       = :buildTime,
        endBuildTime    = :endBuildTime,
        amount          = :amount,
        taskType        = :taskType;';

        return Database::get()->insert($sql, array(
            ':queueId'      => $elementObj->queueId,
            ':userId'       => $this->userId,
            ':planetId'     => $this->planetId,
            ':elementId'    => $elementObj->elementID,
            ':buildTime'    => $buildTime,
            ':endBuildTime' => $endBuildTime,
            ':amount'       => $amount,
            ':taskType'     => $taskType,
        ));
    }

    public function remove($taskId)
    {
        $sql = 'DELETE FROM %%QUEUE%% WHERE taskId = :taskId;';

        return Database::get()->delete($sql, array(
            ':taskId'   => $taskId
        ));
    }

    public function removeAllTaskByElementId(Element $elementObj)
    {
        $taskTimes  = array();
        $queueData  = $this->queryQueueIds($elementObj->queueId);
        foreach($queueData as $task)
        {
            if($task['elementId'] == $elementObj->elementID)
            {
                $taskTimes[$task['taskId']] = $task['buildTime'];
            }
        }

        $db     = Database::get();

        $sql    = 'DELETE FROM %%QUEUE%%
        WHERE userId = :userId
        AND queueId = :queueId
        AND (planetId = :planetId OR taskType = :taskType)
        AND elementId = :elementId;';

        $db->delete($sql, array(
            ':userId'       => $this->userId,
            ':planetId'     => $this->planetId,
            ':queueId'      => $elementObj->queueId,
            ':elementId'    => $elementObj->elementID,
            ':taskType'     => self::USER,
        ));

        $sql    = 'UPDATE %%QUEUE%% SET endBuildTime = endBuildTime - :timeDifference
        WHERE userId = :userId
        AND queueId = :queueId
        AND (planetId = :planetId OR taskType = :taskType)
        AND taskId > :taskId;';

        foreach($taskTimes as $taskId => $time)
        {
            $db->update($sql, array(
                ':userId'           => $this->userId,
                ':planetId'         => $this->planetId,
                ':queueId'          => $elementObj->queueId,
                ':taskType'         => self::USER,
                ':timeDifference'   => $time,
                ':taskId'           => $taskId,
            ));
        }
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
        FROM %%QUEUE%%
        WHERE userId = :userId
        AND (planetId = :planetId OR taskType = :taskType)
        AND endBuildTime <= :timestamp
        GROUP BY queueId
        ORDER BY taskId ASC;';

        return Database::get()->select($sql, array(
            ':userId'       => $this->userId,
            ':planetId'     => $this->planetId,
            ':timestamp'    => $toTime,
            ':taskType'     => self::USER,
        ));
    }

    public function updateTaskAmount($taskId, $amount)
    {
        $sql = 'UPDATE %%QUEUE%% SET amount = :amount WHERE taskId = :taskId;';

        return Database::get()->update($sql, array(
            ':amount'   => $amount,
            ':taskId'   => $taskId,
        ));
    }

    public function updateQueueEndTimes($queueId, $timeDifference)
    {
        $sql = 'UPDATE %%QUEUE%% SET buildTime = buildTime + :timeDifference
        WHERE userId = :userId
        AND queueId = :queueId
        AND (planetId = :planetId OR taskType = :taskType)
        ORDER BY taskId ASC LIMIT 1;';

        Database::get()->update($sql, array(
            ':timeDifference'   => $timeDifference,
            ':queueId'          => $queueId,
            ':userId'           => $this->userId,
            ':planetId'         => $this->planetId,
            ':taskType'         => self::USER,
        ));

        $sql = 'UPDATE %%QUEUE%% SET endBuildTime = endBuildTime + :timeDifference
        WHERE userId = :userId
        AND queueId = :queueId
        AND (planetId = :planetId OR taskType = :taskType)
        ORDER BY taskId ASC;';

        Database::get()->update($sql, array(
            ':timeDifference'   => $timeDifference,
            ':queueId'          => $queueId,
            ':userId'           => $this->userId,
            ':planetId'         => $this->planetId,
            ':taskType'         => self::USER,
        ));
    }
}