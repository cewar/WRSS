<?PHP
  # define script parameters
	$sql_c=mysql_query('select rss from zy_accounts_config ACC left join zy_rss RSS  on RSS.id=ACC.origenRss where user=1 and `type`=4 limit 1');
	$row=mysql_fetch_row($sql_c) ;
  $BLOGURL    = $row[0];
  $NUMITEMS   = 5;
  $TIMEFORMAT = "j F Y, g:ia";
  $CACHEFILE  = "/tmp/" . md5($BLOGURL);
  $CACHETIME  = 4; # hours

  # download the feed iff a cached version is missing or too old
  if(!file_exists($CACHEFILE) || ((time() - filemtime($CACHEFILE)) > 3600 * $CACHETIME)) {
    if($feed_contents = @file_get_contents($BLOGURL)) {
      # write feed contents to cache file
      $fp = fopen($CACHEFILE, 'w');
      fwrite($fp, $feed_contents);
      fclose($fp);
    }
  }

  include "library/rss.php";
  $rss_parser = new myRSSParser($CACHEFILE);

  $feeddata = $rss_parser->getRawOutput();
  extract($feeddata['RSS']['CHANNEL'][0], EXTR_PREFIX_ALL, 'rss');
  $count = 0;
  $informacion='';
  foreach($rss_ITEM as $itemdata) {
	  $datos='<div class="span6" style="margin-left:0px;height: 210px;padding:5px;">
							<dl class="dl-icon">
								<dt><a href=\''.$itemdata["LINK"].'\' target=\'_blank\'><b>';
    $datos.= strip_tags($itemdata['TITLE']);
    $datos.= "</b></a>-".date($TIMEFORMAT, strtotime($itemdata['PUBDATE']))."</dt>";
	$datos.= '<dd>
									<span class="icon-wrapper">
										<i class="micon-newspaper"></i>
									</span>
									<p>'.strip_tags($itemdata['DESCRIPTION']).'</p>
									<a class="btn btn-flat btn-warning btn-mini" href="publicar.php?url_link='.$itemdata["LINK"].'">Compartir</a>
								</dd>
							</dl>
						</div>';

	echo $datos;
    if(++$count >= $NUMITEMS) break;
  }




?>
