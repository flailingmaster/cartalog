<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\WebDriverCapabilityType;
use Facebook\WebDriver\WebDriverBy;

class SearchCars extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'search:cars';

    /**
     * The console command description.
     *
     * @var string
     */
     protected $searchstring1 = "https://www.cars.com/for-sale/searchresults.action?zc=85202&rd=99999&prMn=0&prMx=50000&yrId=27381&yrId=20201&yrId=20145&yrId=20200&yrId=20144&yrId=20199&mdId=20567&transTypeId=28112&mkId=20081&stkTypId=28881&sf1Nm=price&sf1Dir=DESC&sf2Nm=miles&sf2Dir=ASC&page=1&perPage=50&sortFeatures=buryUsedLowPrice&sortFeatures=buryNewLowPrice&sortFeatures=buryLowPriceOlderThanSix&sortFeatures=buryNoPrice&sortFeatures=buryUsedLowMileage&searchSource=GN_REFINEMENT";
     protected $searchstring2 = "https://www.cars.com/for-sale/searchresults.action?zc=85202&rd=99999&prMn=0&prMx=50000&yrId=27381&yrId=20201&yrId=20145&yrId=20200&yrId=20144&yrId=20199&mdId=20567&transTypeId=28112&mkId=20081&stkTypId=28881&sf1Nm=price&sf1Dir=DESC&sf2Nm=miles&sf2Dir=ASC&page=1&perPage=100&sortFeatures=buryUsedLowPrice&sortFeatures=buryNewLowPrice&sortFeatures=buryLowPriceOlderThanSix&sortFeatures=buryNoPrice&sortFeatures=buryUsedLowMileage&searchSource=UTILITY";
    protected $description = 'Search and Store Interesting Cars for Sale';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('it works!');
        $driver = RemoteWebDriver::create("http://localhost:9515", DesiredCapabilities::chrome(), 90 * 1000, 90 * 1000);
        $driver->get($this->searchstring1);
        $from = $driver->findElements(WebDriverBy::cssSelector(
          'div.listing-row__details'));
        foreach ($from as $row) {
          $title = $row->findElement(WebDriverBy::cssSelector(
          	'h2.cui-delta.listing-row__title'));
          $price = $row->findElement(WebDriverBy::cssSelector(
            'span.listing-row__price'));
          $mileage = $row->findElement(WebDriverBy::cssSelector(
            'span.listing-row__mileage'));
          //mileage: listing-row__mileage


          $this->info("title:".$title->getText());
          $this->info("price:".$price->getText());
          $this->info("mileage:".$mileage->getText());
        }

        //$element = $this->webdriver_test($this->searchstring1);
        //$this->info($element->getText());
        /*$client = new Client();
        $crawler = $client->request('GET', $this->searchstring2);
        $crawler->filter('body')->each(function ($node) {
          $text = print_r($node, TRUE);
          $this->info("$text \n");
        });*/
    }

    public function webdriver_test($url)
    {
      // https://github.com/yatnosudar/PHP-WebDriver-Phantomjs-Selenium/blob/master/example.php
      // start Firefox
      $host = 'http://127.0.0.1:4444/wd/hub'; // this is the default
      /*
      $capabilities = array(
      	WebDriverCapabilityType::BROWSER_NAME => 'phantomjs',
      	WebDriverCapabilityType::ACCEPT_SSL_CERTS=> true,
      	WebDriverCapabilityType::JAVASCRIPT_ENABLED=>true);
      $desired_capabilities = DesiredCapabilities::firefox();
      $desired_capabilities->setCapability('acceptSslCerts', false);
      $desired_capabilities->setCapability('javascriptEnabled', true);
      $driver = RemoteWebDriver::create($host, $desired_capabilities, 90 * 1000, 90 * 1000 );
      $driver = new RemoteWebDriver($host, $capabilities);
      // navigate to 'http://docs.seleniumhq.org/'
      $session = $driver->get($url);
      // Search 'php' in the search box
      $from = $driver->findElement(WebDriverBy::cssSelector(
      	'h2.cui-delta.listing-row__title'));
      $from->click();
*/


//      $driver = RemoteWebDriver::create($host, DesiredCapabilities::firefox(), 90 * 1000, 90 * 1000);
/*
      $driver->get($url);
      $from = $driver->findElement(WebDriverBy::cssSelector(
        'h2.cui-delta.listing-row__title'));
      return $from;
*/
      $driver = RemoteWebDriver::create("http://localhost:9515", DesiredCapabilities::chrome(), 90 * 1000, 90 * 1000);
      $driver->get($url);
      $from = $driver->findElements(WebDriverBy::cssSelector(
        'listing-row__details'));
      return $from;
      //$element = $driver->findElement(WebDriverBy::name('q'));
      //$element->sendKeys('Cheese');
      //$element->submit();
//*/
    }

}
