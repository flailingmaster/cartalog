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
     protected $searchstring1 = "https://www.cars.com/for-sale/searchresults.action?zc=85202&rd=99999&prMn=0&prMx=50000&yrId=27381&yrId=20201&yrId=20145&yrId=20200&yrId=20144&yrId=20199&mdId=20567&transTypeId=28112&mkId=20081&stkTypId=28881&sf1Nm=price&sf1Dir=DESC&sf2Nm=miles&sf2Dir=ASC&page=1&perPage=100&sortFeatures=buryUsedLowPrice&sortFeatures=buryNewLowPrice&sortFeatures=buryLowPriceOlderThanSix&sortFeatures=buryNoPrice&sortFeatures=buryUsedLowMileage&searchSource=GN_REFINEMENT";
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
        $cars = $this->webdriver_test($this->searchstring1);
        $this->table(["title", "price", "mileage"], $cars);
    }

    public function webdriver_test($url)
    {
      // https://github.com/yatnosudar/PHP-WebDriver-Phantomjs-Selenium/blob/master/example.php

      $host = 'http://127.0.0.1:4444/wd/hub'; // this is the default

      $driver = RemoteWebDriver::create("http://localhost:9515", DesiredCapabilities::chrome(), 90 * 1000, 90 * 1000);
      $driver->get($url);
      $nextpages = $driver->findElements(WebDriverBy::cssSelector(
        'ul.page-list'));
      $this->info("next page for loop");
      foreach ($nextpages as $next) {
        $this->info("in next page for loop");
        $test = $next->findElements(WebDriverBy::cssSelector('a'));
        foreach ($test as $links) {
         $this->info($links->getText());  
        }

      }
      $cars = $this->parse_page($driver);
      return $cars;


    }

    public function parse_page($driver)
    {
      $from = $driver->findElements(WebDriverBy::cssSelector(
        'div.listing-row__details'));
      $cars = array();
      foreach ($from as $row) {
        $title = $row->findElement(WebDriverBy::cssSelector(
          'h2.cui-delta.listing-row__title'));
        $price = $row->findElement(WebDriverBy::cssSelector(
          'span.listing-row__price'));
        $mileage = $row->findElement(WebDriverBy::cssSelector(
          'span.listing-row__mileage'));

        $cars[] = [$title->getText(), $price->getText(), $mileage->getText()];
      }
      return $cars;
    }

}
