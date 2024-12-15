<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\StockLedger;

class StockLedgerController extends Controller
{
    public function index()
    {
        return StockLedger::select('stock_ledgers.*', 'items.name')
            ->join('items', 'stock_ledgers.item_code', '=', 'items.item_code')
            ->get();
    }
}
