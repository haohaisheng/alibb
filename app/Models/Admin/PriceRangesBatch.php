<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class PriceRangesBatch extends Model
{
    //
    protected $table = 'hdb_price_ranges_batch';

    protected $primaryKey = 'id';

    public $timestamps = false;

    public function getProductPriceRanges($productId)
    {
        $prices = DB::table('hdb_price_ranges_batch')
            ->where('productID', $productId)
            ->get();
        return $prices;
    }
}
