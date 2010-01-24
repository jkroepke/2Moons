 <?php
/*
ShowPlanetMenu.php
Created by zhoed
para los usuarios de XGProyect

Por favor, respeten los créditos y no modifiquen el template
*/
if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowPlanetMenu($CurrentUser)
{
    global $dpath, $db;

	$planets = "SELECT `id`,`name`,`galaxy`,`system`,`planet`,`planet_type`, `image`, `field_current`, `field_max`, `terraformer`, `b_building` FROM ".PLANETS." WHERE `id_owner` = '" . $CurrentUser['id'] . "' AND `destruyed` = 0 ORDER BY ";

    $Order = ( $CurrentUser['planet_sort_order'] == 1 ) ? "DESC" : "ASC" ;
    $Sort  = $CurrentUser['planet_sort'];

    if($Sort == 0)
        $planets .= "`id` ". $Order;
    elseif($Sort == 1)
        $planets .= "`galaxy`, `system`, `planet`, `planet_type` ". $Order;
    elseif ($Sort == 2)
        $planets .= "`name` ". $Order;

	$planets2 = $db->query($planets);

	while ($p = $db->fetch_array($planets2))
	{
    if ($p["destruyed"] == 0)
        {

          $ct     = $p["field_max"] + ($p["terraformer"] * FIELDS_BY_TERRAFORMER);
          if ($p['planet_type'] == 3)
          {
          $ct     = $p["field_max"];
          }

            $parse['planetmenulist'] .= "<center><table cellspacing=3>";
            if ($p['planet_type'] == 1 && $p["id"] != $CurrentUser["current_planet"])
            {
                $parse['planetmenulist'] .= "<td><div align=center><a href=game.php?page=$_GET[page]&gid=$_GET[gid]&cp=".$p['id']."&mode=".$_GET['mode']."&re=0 title=Campos&nbsp;ocupados:&nbsp;".$p['field_current']."/".$ct."><img src=".$dpath."planeten/small/s_".$p['image'].".jpg border=0 height=35 width=35><br><font color=#2E9AFE>".$p['name']."&nbsp;</font><font color=#58FA58><br>[".$p['galaxy'].":".$p['system'].":".$p['planet']."]</font></a><br>".(($p['b_building'] != 0 && $p['b_building'] - time() > 0) ? "<div id=\"".$p['id']."\">".pretty_time($p['b_building'] - time())."</div><script type=\"text/javascript\">var si_".$p['id']." = window.setInterval('pretty_time_update(".$p['id'].");', 1000);</script>":"")."";
            }
            elseif ($p['planet_type'] == 3 && $p["id"] != $CurrentUser["current_planet"])
            {
                $parse['planetmenulist'] .= "<td><div align=center><a href=game.php?page=$_GET[page]&gid=$_GET[gid]&cp=".$p['id']."&mode=".$_GET['mode']."&re=0 title=Campos&nbsp;ocupados:&nbsp;".$p['field_current']."/".$ct."><img src=".$dpath."planeten/small/s_".$p['image'].".jpg border=0 height=35 width=35><br>".$p['name']." (Luna)&nbsp;<font color=#58FA58><br>[".$p['galaxy'].":".$p['system'].":".$p['planet']."]</font></a><br>".(($p['b_building'] != 0 && $p['b_building'] - time() > 0) ? "<div id=\"".$p['id']."\">".pretty_time($p['b_building'] - time())."</div><script type=\"text/javascript\">var si_".$p['id']." = window.setInterval('pretty_time_update(".$p['id'].");', 1000);</script>":"")."";
            }
            else
            {
                $parse['planetmenulist'] .= "<th><div align=center><a href=# title=Campos&nbsp;ocupados:&nbsp;".$p['field_current']."/".$ct."><img src=".$dpath."planeten/small/s_".$p['image'].".jpg border=0 height=35 width=35><br><font color=#FFFF00>".$p['name']."&nbsp;</font><font color=#FE9A2E><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[".$p['galaxy'].":".$p['system'].":".$p['planet']."]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></a><br>".(($p['b_building'] != 0 && $p['b_building'] - time() > 0) ? "<div id=\"".$p['id']."\">".pretty_time($p['b_building'] - time())."</div><script type=\"text/javascript\">var si_".$p['id']." = window.setInterval('pretty_time_update(".$p['id'].");', 1000);</script>":"")."</div></th>";
            }
            $parse['planetmenulist'] .= "</center></table>";
        }
}
    return parsetemplate(gettemplate('global/planet_menu'), $parse);
}
?>