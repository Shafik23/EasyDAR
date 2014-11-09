<?php
/* This script receives input from the initial input form,
   and acts as the main controller for the entire GUI flow.  */

require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'SEOStats'.DIRECTORY_SEPARATOR.'bootstrap.php';
use \SEOstats\Services as SEO;
use \SEOstats\Config as SEO_Config;


echo_line("EasyDar, v0.1", 2);

$business_name = $_GET['business_name'];
$business_url = $_GET['business_url'];
$business_url = 'http://www.cnn.com';
$business_city_state = $_GET['business_city_state'];
$keywords = $_GET['keywords'];
$google_key = $_GET['google_key'];
define('NUMBER_OF_SERPS', 100);

echo_line("Business name: " . $business_name);
echo_line("URL: " . $business_url);
echo_line("City, State: " . $business_city_state);
if (!empty($google_key))
   echo_line("Google API Key: " . $google_key);
echo_line("Search Engine keywords: " . $keywords);

echo_line("----------------", 2);


# attempt to construct an SEOStats object
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


echo_line("Google PageRank: " . $seo->Google()->getPageRank());
echo_line("Google SiteIndex: " . $seo->Google()->getSiteIndexTotal());
echo_line("Google number of results for a search on given keywords: " . $seo->Google()->getSearchResultsTotal($keywords));

# these require an API key from Google
if (!empty($google_key))
{
   SEO_Config\ApiKeys::$GOOGLE_SIMPLE_API_ACCESS_KEY = $google_key;
   echo_line("Google PageSpeed Analysis: ");
   echo_line("<pre>");
   //print_r(SEO\Google::getPageSpeedAnalysis());
   echo_line("Disabled for now.");
   echo_line("</pre>");
   line();
   echo_line("Google PageSpeed final score: " . $seo->Google()->getPageSpeedScore());
}

echo_line("----------------", 2);


# SERP analysis
echo_line("Google SERPs: ");
echo_line("<pre>");
print_r($seo->Google()->getSerps($keywords, NUMBER_OF_SERPS, $business_url));
echo_line("</pre>");

echo_line("----------------", 2);


# Social media scores
$sm_array = [
               "getGooglePlusShares" => "Google Plus Shares",
               "getTwitterShares" => "Twitter Shares",
               "getLinkedInShares" => "LinkedIn Shares",
               "getPinterestShares" => "Pinterest Shares",
               "getStumbleUponShares" => "StumbleUpon Shares"
            ];

foreach (array_keys($sm_array) as $m)
{
   echo_line($sm_array[$m] . " : " . $seo->Social()->$m());
}


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


