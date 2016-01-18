<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * For the full copyright and license information, please view the LICENSE
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
 * @licence MIT
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */


class ShowTechtreePage extends AbstractGamePage
{
    public static $requireModule = MODULE_TECHTREE;

    function __construct()
    {
        parent::__construct();
    }

    function show()
    {
        global $resource, $requeriments, $reslist, $USER, $PLANET;

        $elementIDs		= array_merge(
            array(0),
            $reslist['build'],
            array(100),
            $reslist['tech'],
            array(200),
            $reslist['fleet'],
            array(400),
            $reslist['defense'],
            array(500),
            $reslist['missile'],
            array(600),
            $reslist['officier']
        );

        $techTreeList = array();

        foreach($elementIDs as $elementId)
        {
            if(!isset($resource[$elementId]))
            {
                $techTreeList[$elementId]	= $elementId;
            }
            else
            {
                $requirementsList	= array();
                if(isset($requeriments[$elementId]))
                {
                    foreach($requeriments[$elementId] as $requireID => $RedCount)
                    {
                        $requirementsList[$requireID]	= array(
                            'count' => $RedCount,
                            'own'   => isset($PLANET[$resource[$requireID]]) ? $PLANET[$resource[$requireID]] : $USER[$resource[$requireID]]
                        );
                    }
                }

                $techTreeList[$elementId]	= $requirementsList;
            }
        }

        $this->assign(array(
            'TechTreeList'		=> $techTreeList,
        ));

        $this->display('page.techTree.default.tpl');
    }
}
