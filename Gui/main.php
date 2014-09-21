<?php
/* This script receives input from the initial input form,
   and acts as the main controller for the entire GUI flow.  */

require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'SEOStats'.DIRECTORY_SEPARATOR.'bootstrap.php';
use \SEOstats\Services as SEO;


echo "EasyDar, v0.1"; 
line(2);

$business_name = $_GET['business_name'];
$business_url = $_GET['business_url'];
$business_url = 'http://www.cnn.com';
$business_city_state = $_GET['business_city_state'];
$keywords = $_GET['keywords'];

echo "Business name: " . $business_name;
line();
echo "URL: " . $business_url;
line();
echo "City, State: " . $business_city_state;
line();
echo "Search Engine keywords: " . $keywords;
line();

echo "----------------";
line(2);


try
{
   $seo = new \SEOstats\SEOstats($business_url);
}

catch (\SEOstats\Common\SEOstatsException $e)
{
   echo "The following problem was detected in your form input:";
   line();
   die($e->getMessage());
}


echo "Google PageRank: " . SEO\Google::getPageRank();



function line($n = 1)
{
   while ($n > 0)
   {
      echo "<br>";
      $n--;
   }
}

?>


