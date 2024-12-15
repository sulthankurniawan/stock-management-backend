<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\StockEntry;
use App\Models\StockEntryDetail;
use App\Models\StockLedger;

class StockEntryController extends Controller
{
    public function index()
    {
        $entries = DB::table('stock_entries')
            ->join('stock_entry_details', 'stock_entries.entry_id', '=', 'stock_entry_details.entry_id')
            ->select(
                'stock_entries.entry_id',
                'stock_entries.tanggal',
                'stock_entries.type',
                'stock_entry_details.item_code',
                'stock_entry_details.batch_id',
                'stock_entry_details.expiry_date',
                'stock_entry_details.qty'
            )
            ->get();

        return response()->json($entries);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'type' => 'required|in:IN,OUT',
            'details' => 'required|array',
            'details.*.item_code' => 'required',
            'details.*.batch_id' => 'required',
            'details.*.expiry_date' => 'required|date',
            'details.*.qty' => 'required|integer',
        ]);

        $entry = StockEntry::create([
            'tanggal' => $validated['tanggal'],
            'type' => $validated['type'],
        ]);

        foreach ($validated['details'] as $detail) {
            StockEntryDetail::create([
                'entry_id' => $entry->entry_id,
                'item_code' => $detail['item_code'],
                'batch_id' => $detail['batch_id'],
                'expiry_date' => $detail['expiry_date'],
                'qty' => $detail['qty'],
            ]);

            $lastStock = StockLedger::where('item_code', $detail['item_code'])
                ->where('batch_id', $detail['batch_id'])
                ->latest('tanggal')
                ->first();

            $currentStock = ($lastStock->current_stock ?? 0) + ($entry->type === 'IN' ? $detail['qty'] : -$detail['qty']);

            StockLedger::create([
                'item_code' => $detail['item_code'],
                'batch_id' => $detail['batch_id'],
                'tanggal' => $validated['tanggal'],
                'last_stock' => $lastStock->current_stock ?? 0,
                'qty_in' => $entry->type === 'IN' ? $detail['qty'] : 0,
                'qty_out' => $entry->type === 'OUT' ? $detail['qty'] : 0,
                'current_stock' => $currentStock,
            ]);
        }

        return response()->json(['message' => 'Stock entry added successfully']);
    }
}
