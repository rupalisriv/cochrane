<?php

namespace App\Console\Commands;

use DOMDocument;
use DOMXPath;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CollectMetadata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'collect:metadata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Collects all the meta data from reviews';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->getReviews();

    }

    public function getTopicList()
    {
        $url ="https://www.cochranelibrary.com/cdsr/reviews/topics";
        return $this->parseTopicHTML($this->returnXpathObj($this->getHtmlFromUrl($url)));
    }

    public function getHtmlFromUrl($url)
    {
        $client = new Client(['verify' => false]);
        try {
            $res = $client->request('GET', $url, [
                'headers' => [
                    'user-agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                ]
            ]);
            if ($res->getStatusCode() == 200) {
                return $res->getBody();

            }
        } catch (GuzzleException $ge) {
            Log::log('Caught guzzle exception: ', $ge->getMessage());
        } catch (Exception $e) {
            Log::log('Caught exception: ', $e->getMessage());
        }
        return false;
    }

    public function returnXpathObj($html)
    {
        /* Use internal libxml errors -- turn on in production, off for debugging */
        libxml_use_internal_errors(true);
        $dom = new DomDocument;
        $dom->loadHTML($html);
        return new DomXPath($dom);

    }

    public function getReviews()
    {
        $topicsWithUrl = $this->getTopicList();
        foreach ($topicsWithUrl as $key=>$val){
            $this->parseReviewHTML($val);
            break;
        }
    }


    public function parseTopicHTML($xpath)
    {
        $topicList = $xpath->query("//ul[@class='browse-by-term-list']");
        $topics = [];
        $i = 0;
        foreach ($topicList as $topic) {
            $topics[$i]['title'] = $xpath->query("li[@class='browse-by-list-item']",$topic)->item(0)->nodeValue;
            $topics[$i]['url'] = $xpath->query("li[@class='browse-by-list-item']/a/@href",$topic)->item(0)->nodeValue."&resultPerPage=100";
            $i++;
        }
        return $topics;
    }


    public function parseReviewHTML($topic)
    {
        $url = str_replace('/en/', '/', $topic['url']);
        $xpath = $this->returnXpathObj($this->getHtmlFromUrl($url));

        $nodes = $xpath->query("//div[@class='search-results-item']");
        $reviewCount = $xpath->query("//span[@class='results-number']")->item(0)->nodeValue;

        $review = '';
        foreach ($nodes as $key=>$node) {
            $title = $xpath->query("//h3[@class='result-title']/a",$node)->item($key)->nodeValue;
            $author = $xpath->query("//div[@class='search-result-authors']/div",$node)->item($key)->nodeValue;
            $date = $xpath->query("//div[@class='search-result-date']/div",$node)->item($key)->nodeValue;
            $review .= $topic['url'] . "|". $topic['title']. "|". $title . "|" . $author . "|" .$date . PHP_EOL;
        }
        $this->copyContentsToFile($review, $topic['title']);
        //sleep(mt_rand(3,5));
        //echo $review;
    }

    public function copyContentsToFile($txt, $title)
    {
        $filename = str_replace(array(' ', '&', ','), '_', $title);
        $file = fopen("/var/www/html/croclib/public/cochrane/".$filename, "w") or die("Unable to open file");
        fwrite($file, $txt);
        echo "success";
    }
}
