<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;

use App\Repositories\ProductRepository;

use Illuminate\Support\Carbon;

class ProductController extends Controller
{
    public function __construct(ProductRepository $prodRepo){
        $this->prodRepo = $prodRepo;
    }

	//	first page
	//	searching page
    public function index() {
    	return view('home');
    }

    //	second page
    //	product list page
    public function productList(SearchRequest $request) {
        //	Retrieve product data from database
        $data['products'] = $this->prodRepo->getProducts();

        return view('product_list')->with($data);
    }

    //	third page
    //	product price monitor page
    public function productPriceMonitor(SearchRequest $request) {
		// Retrieve product data from fabelio.com
        $webContent = curl_domain($request->product_link);
        $webContent = str_replace(' & ', ' &amp; ', $webContent);

        //  Convert to dom document
        $dom = new \DOMDocument;
        libxml_use_internal_errors(false);
        @$dom->loadHTML($webContent); 

        $fabelioId = $dom->getElementById('product-ratings')->getAttribute('data-product-id');

        $finder = new \DomXPath($dom);
        $nodes  = $finder->query("//*[contains(@data-ui-id, 'page-title-wrapper')]");

        $productData = [
            'fabelio_id'   => $fabelioId,
            'name'         => $nodes->item(0)->nodeValue,
            'url'          => $request->product_link,
            'latest_price' => 0,
        ];

        //  Find or create the product
        $data['product'] = $product = $this->prodRepo->findOrCreateProduct($fabelioId, $productData);

        //  Get product latest price
        $latestPriceUpdated = $this->prodRepo->getLatestPriceUpdated($product->id);

        $end = Carbon::parse($latestPriceUpdated);
        $now = Carbon::now();
        $diffUpdated = $end->diffInHours($now);

        //  Insert new product price if price not exist or latest updated time have passed 1 hour
        $data['productPrice'] = $productPrice = $dom->getElementById('product-price-' . $fabelioId)->getAttribute('data-price-amount');

        if ( ! $latestPriceUpdated || $diffUpdated >= 1) {
            $productPriceData = [
                'product_id' => $product->id,
                'price'      => $productPrice
            ];

            $this->prodRepo->insertProductPrice($productPriceData);
            $this->prodRepo->updateLatestPrice($product->id, $productPrice);
        }

        //  Get latest price list
        // $data['priceList'] = $this->prodRepo->getProductPriceList($product->id);

        return view('price_monitor')->with($data);
    }

    public function cronCode() {
        //  Retrieve product data from database
        $data['products'] = $this->prodRepo->getProducts();

        foreach($data['products'] as $product) {
            $request = new SearchRequest();

            $request->replace(['product_link' => $product->url]);

            $this->productPriceMonitor($request);
        }
    }
}
