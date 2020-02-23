<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	public $timestamps = false;

	protected $fillable = ['fabelio_id', 'name', 'url', 'latest_price'];

  	public function product_prices() {
  		return $this->hasMany('App\Models\ProductPrice', 'product_id');
  	}
}
