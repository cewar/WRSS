<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WRSS</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
<meta name="google-translate-customization" content="bab13424cdd638a7-413e070c855ead07-g0df09b912ff37657-13"></meta>

</head>

<body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">WRSS</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">Login</a></li>
            <li><a href="#contact">Cargar WRSS</a></li>
			<li>
			<div id="google_translate_element" style="margin-top:10px" ></div>
			</li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container" style="margin-top:100px">

<script type="text/javascript">

function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'es', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, multilanguagePage: true}, 'google_translate_element');
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<?PHP

include("conexion.php");
include("rss.php");  

setlocale(LC_ALL,"es_ES");
  $NUMITEMS   = 5;
  $TIMEFORMAT = "j F Y, g:ia";  
  $CACHETIME  = 1; # hours  
  
$sql_c=mysql_query('select * from zy_accounts_config ACC left join zy_rss RSS  on RSS.id=ACC.origenRss where user=1 and `type`=4 ');
$posicion=0;
while($row=mysql_fetch_array($sql_c))
{
	$posicion++;
  # define script parameters
  $BLOGURL    = $row['rss'];

  $CACHEFILE  = "tmp/" . md5($BLOGURL);


  # download the feed iff a cached version is missing or too old
  if(!file_exists($CACHEFILE) || ((time() - filemtime($CACHEFILE)) > 3600 * $CACHETIME)) {
    if($feed_contents = @file_get_contents($BLOGURL)) {
      # write feed contents to cache file
      $fp = fopen($CACHEFILE, 'w');
      fwrite($fp, $feed_contents);
      fclose($fp);
    }
  }


  $rss_parser = new myRSSParser($CACHEFILE);

  $feeddata = $rss_parser->getRawOutput();
  extract($feeddata['RSS']['CHANNEL'][0], EXTR_PREFIX_ALL, 'rss');
  $count = 0;
  $informacion='';
  foreach($rss_ITEM as $itemdata) {
	$datoF=date('Ymdhis',strtotime($itemdata['PUBDATE']));
	  
    $titulos[$datoF]= "<a title=\"".htmlspecialchars($rss_DESCRIPTION)."\" href=\"{$rss_LINK}\" target=\"_blank\">".htmlspecialchars($rss_TITLE)."</a> ".date($TIMEFORMAT, strtotime($itemdata['PUBDATE']));
    $datos= "<p><b><a href=\"{$itemdata['LINK']}\" target=\"_blank\">".htmlspecialchars(stripslashes($itemdata['TITLE']));
    $datos.= "</a></b><br>\n";
    $datos.= htmlspecialchars(stripslashes(strip_tags($itemdata['DESCRIPTION'])))."<br><br>\n";
	$datos.= '<a class="btn btn-medium btn-primary" href="publicar.php?url_link='.$itemdata["LINK"].'"><span><i class="icon-large icon-github"></i></span> Compartilo</a>';
	
	$datos.= "</p>\n\n";	  	
	
	 	  
	$datoF=date('Ymdhis',strtotime($itemdata['PUBDATE']));
	$informacion[$datoF]=$datos;
	if(++$count >= $NUMITEMS) break;
  }
foreach ($informacion as $key => $val) {

	echo '<div class="col-lg-4" style="height:300px">
						<div class="well widget box-shadow-right" s>
							<div class="widget-header">
								<h3 class="title">'.$titulos[$key].'</h3>
							</div>
							'.$informacion[$key].'
						</div>
					</div>';

}  
}


?>  </div>
</body>
</html>
