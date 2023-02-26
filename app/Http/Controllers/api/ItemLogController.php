<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ItemLog;
use App\Models\ListLog;
use Illuminate\Http\Request;

class ItemLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $username = User::where('username', 'test')->first();
        $company_id = $username->companies->company_id;
        $data = ItemLog::with('list_items.items')->where('company_id', $company_id)->get();
        return response()->json([
            'status' => 200,
            'message' => "Data ditemukan",
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_item_out(Request $request)
    {
        $username = User::where('username', 'test')->first();
        $company_id = $username->companies->company_id;
        $items = $request->items;
        $log_id = $company_id . "-" . time();
        foreach ($items as $item) {
            $data[] = [
                'log_id' => $log_id,
                'item_id' => $item['id'],
                'qty' => $item['qty'],
            ];
        }
        // dd($data);
        $data_log = [
            'log_id' => $log_id,
            'description' => $request->description,
            'date_start' => $request->date_start,
            'officer' => 'test',
            'company_id' => $company_id
        ];
        ItemLog::create($data_log);
        ListLog::insert($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemLog  $itemLog
     * @return \Illuminate\Http\Response
     */
    public function show(ItemLog $itemLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemLog  $itemLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemLog $itemLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemLog  $itemLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemLog $itemLog)
    {
        //
    }
}