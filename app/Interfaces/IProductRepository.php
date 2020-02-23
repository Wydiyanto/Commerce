<?php

namespace App\Interfaces;

interface IProductRepository
{
	public function getProductPriceList($product_id);
}