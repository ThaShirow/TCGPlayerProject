<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

//use TrollAndToad\TCGPlayer\Catalog\ListAllCategories;
//use TrollAndToad\TCGPlayer\Catalog\ListAllCategoriesRequest;
//use TrollAndToad\TCGPlayer\Catalog\ListAllCategoriesResponse;
//use TrollAndToad\TCGPlayer\Core\ApiCallOptions;
//use App\Http\Controllers\BearerController;
//use Illuminate\Support\Facades\Config;

//$bear = new BearerController();

//$test = $bear->refreshBearer();

dd($app);

//print "<pre>"; print_r($test); print "</pre>";


/*
$bearerToken = "7qmQERvNuSTMTElr54eCutZlBBn-CvlUoMyhPhPqlk7V3bCT83d-z7WDMe0-OeJzSSuQYpcORsEdWbJ7JjN4jttDd4xOM-joKoicVUVSLagUBvCIThYObWTSaWPZUjgFqUjCoZSOFlMdmlsqtL8rYBnTUawXJfQrhDLYkQ3XfkruVP7lHPIf0UTaoCaVy3Lrrdj2iDSjcSzDIDzlspfpu3i6NFuuCF_a1fTlo64MPgqyRlzHCM0KpLNNyB-Q4k0XyH3ZdjSuV2oHqg25pWDYi1CRY8MK7Zi16BUITQvYhMtcbjXw8M9wEz2um45Y35S6TRNvHA";

$header = array("X-Tcg-Access-Token" => "d4c1defe-f985-4955-a0d0-c4f89c1509b7");
$body = array("grant_type" => "client_credentials", "client_id" => "CC6A40AD-E775-4338-827A-B9180E192953", "client_secret" => "F3F5A4D4-E85A-4FF4-8199-A09D7B5AD6E1");

$options = new ApiCallOptions();

$listTest = new ListAllCategories($options);

$request = new ListAllCategoriesRequest(["offset" => 10, "limit" => 3], $bearerToken);

$response = $listTest->sendRequest($request);

$result = $response->getContent();

$testArr = $response->toArray();

print "<pre>"; print_r($testArr); print "</pre>";

*/










