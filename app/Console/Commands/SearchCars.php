<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
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
        $client = new Client();
        $crawler = $client->request('GET', $this->searchstring2);
        $crawler->filter('body')->each(function ($node) {
          $text = print_r($node, TRUE);
          $this->info("$text \n");
        });
    }

}
