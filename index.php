<html>
<form id="form" action="">

<input name="site" id="site" type="text" placeholder="ENTER SITE"></input>
<button type="submit">SUBMIT</button>
</form>
<?php
date_default_timezone_set("UTC");
if (isset($_GET['site'])){$domain_name=$_GET['site'];}else{$domain_name="webwealth.me";}

$i = date('Y');
//check all domain dates in wayback

		global $domain_name;
		global $content;
		$response = file_get_contents('https://archive.org/wayback/available?url=' . $domain_name . '&timestamp=' . $i);
		// here we get the link back from wayback
		$response = explode(",", $response);	
	//	echo "<pre>";
		//var_dump($response);
$response = substr($response[4], 9, -1);
echo $response;
	//	echo "</pre>";
		echo "<br><br>";
				
		// now we got the link, we need to get the file contents
	$sitecontent = file_get_contents("$response");
				//getting only text from page
				
	//here we try to get the content only between body tags			
//preg_match("/<body[^>]*>(.*?)<\/body>/is", $sitecontent, $matches);
preg_match("/END WAYBACK TOOLBAR INSERT[^>]*>(.*?)<\/body>/is", $sitecontent, $matches);


//temporary quick solution to keep content inside textarea
$matches[1] = str_replace("textarea","text.area",$matches[1]);

//show original html
echo "<textarea style='height:300px;width:40%'>";
echo $matches[1];
echo "</textarea>";


//here we replace the anchors so everything in an anchor gets removed
//$matches[1] = preg_replace('<a', "<meta", $matches[1]);

$sitecontent = $matches[1];
// here we get only the text		
require('Html2Text.php');
$html = new \Html2Text\Html2Text($sitecontent);

//show only content, no html
echo "<textarea style='height:300px;width:40%'>";
echo $html->getText();  // Hello, "WORLD"
echo "</textarea>";

	






?>
</html>