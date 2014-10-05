<?php
/* This script receives input from the initial input form,
   and acts as the main controller for the entire GUI flow.  */

require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'SEOStats'.DIRECTORY_SEPARATOR.'bootstrap.php';
use \SEOstats\Services as SEO;


echo_line("EasyDar, v0.1", 2);

$business_name = $_GET['business_name'];
$business_url = $_GET['business_url'];
$business_url = 'http://www.cnn.com';
$business_city_state = $_GET['business_city_state'];
$keywords = $_GET['keywords'];

echo_line("Business name: " . $business_name);
echo_line("URL: " . $business_url);
echo_line("City, State: " . $business_city_state);
echo_line("Search Engine keywords: " . $keywords);

echo_line("----------------", 2);


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


echo_line("Google PageRank: " . SEO\Google::getPageRank());
echo_line("Google SiteIndex: " . SEO\Google::getSiteIndexTotal());
echo_line("Google number of results for a search on given keywords: " . SEO\Google::getSearchResultsTotal($keywords));

# these require an API key from Google
//print_r("Google PageSpeed Analysis: " . SEO\Google::getPageSpeedAnalysis());
//echo "Google PageSpeed final score: " . SED\Google::getPageSpeedScore();

echo_line("----------------", 2);

# these require an API key from Mozscape
//echo_line("MozRank score, out of 10 points: " . SEO\Mozscape::getMozRank());
//echo_line("Mozscape Search Engine rank score, out of 100 points: " . SEO\Mozscape::getPageAuthority());
//echo_line("Mozscape Search Engine domain rank score, out of 100 points: " . SEO\Mozscape::getDomainAuthority());

echo_line("----------------", 2);




function line($n = 1)
{
   while ($n > 0)
   {
      echo "<br>";
      $n--;
   }
}

function echo_line($str, $n = 1)
{
   echo $str;
   line($n);
}


?>


