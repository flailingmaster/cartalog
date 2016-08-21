// Read the Phantom webpage '#intro' element text using jQuery and "includeJs"

"use strict";
var page = require('webpage').create();

page.onConsoleMessage = function(msg) {
    console.log(msg);
};
var url = "https://www.cars.com/for-sale/searchresults.action?zc=85202&rd=99999&prMn=0&prMx=50000&yrId=27381&yrId=20201&yrId=20145&yrId=20200&yrId=20144&yrId=20199&mdId=20567&transTypeId=28112&mkId=20081&stkTypId=28881&sf1Nm=price&sf1Dir=DESC&sf2Nm=miles&sf2Dir=ASC&page=1&perPage=100&sortFeatures=buryUsedLowPrice&sortFeatures=buryNewLowPrice&sortFeatures=buryLowPriceOlderThanSix&sortFeatures=buryNoPrice&sortFeatures=buryUsedLowMileage&searchSource=UTILITY";
page.open(url, function(status) {
    if (status === "success") {
        page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js", function() {
            page.evaluate(function() {
                console.log("$(\".explanation\").text() -> " + $(".cui-delta listing-row__title").html());
            });
            phantom.exit(0);
        });
    } else {
      phantom.exit(1);
    }
});
