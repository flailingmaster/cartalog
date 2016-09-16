<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\WebDriverCapabilityType;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;

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

     protected $caymans = "https://www.cars.com/for-sale/searchresults.action/?zc=85202&rd=99999&prMx=35000&mdId=20819&trId=24752&transTypeId=28112&mkId=20081&stkTypId=28881&sf1Nm=miles&sf1Dir=ASC&sf2Nm=price&sf2Dir=DESC&page=1&perPage=100&sortFeatures=buryUsedLowMileage&searchSource=GN_REFINEMENT&moveTo=listing-674982196";
    protected $description = 'Search and Store Interesting Cars for Sale';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('it works!');
        //$cars = $this->webdriver_test($this->searchstring1);
        $cars = $this->webdriver_test($this->caymans);
        $this->table(["title", "price", "mileage", "meta"], $cars);
    }

    public function webdriver_test($url)
    {
      // https://github.com/yatnosudar/PHP-WebDriver-Phantomjs-Selenium/blob/master/example.php

      $host = 'http://127.0.0.1:4444/wd/hub'; // this is the default

      $driver = RemoteWebDriver::create("http://localhost:9515", DesiredCapabilities::chrome(), 90 * 1000, 90 * 1000);
      $driver->get($url);
      $cars = $this->parse_page($driver);
      //$nextpage = $driver->findElement(WebDriverBy::cssSelector(
      //    'cui-page-button a.next-page'))->click();
      //$nextcars = $this->parse_page($nextpage);
      //$this->table(["title", "price", "mileage"], $nextcars);
      //$cars = array_merge($cars, $this->parse_page($nextpage));

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
        $meta = $row->findElement(WebDriverBy::cssSelector(
          'div.listing-row__meta'));
        $cars[] = [$title->getText(), $price->getText(), $mileage->getText(), $meta->getText()];
      }
      return $cars;
    }

}
