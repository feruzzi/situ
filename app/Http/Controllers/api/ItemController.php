<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Item;
use Exception;
use Illuminate\Http\Request;

class ItemController extends Controller
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
        $data = Item::where('company_id', $company_id)->get();
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
    public function store(Request $request)
    {
        $username = User::where('username', 'test')->first();
        $company_id = $username->companies->company_id;
        $this->validate($request, [
            'item_id' => 'required|unique:items',
            'name' => 'required|min:3',
            'unit' => 'required',
            'qty' => 'required',

        ], [
            'item_id.required' => 'ID Barang Harus diisi',
            'item_id.unique' => 'ID Barang Sudah digunakan',
            'name.required' => 'Nama Barang Harus diisi',
            'name.min' => 'Nama Barang Minimal 3 karakter',
            'unit.required' => 'Unit Barang Harus diisi',
            'qty.required' => 'Jumlah Barang Harus diisi'
        ]);
        $data = [
            'item_id' => $request->item_id,
            'name' => $request->name,
            'unit' => $request->unit,
            'qty' => $request->qty,
            'price' => $request->price,
            'type' => $request->type,
            'description' => $request->description,
            'username' => $username->username,
            'company_id' => $company_id,
        ];
        Item::create($data);
        return response()->json([
            'status' => 201,
            'message' => "Data Berhasil di Tambahkan",
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item, $id)
    {
        try {
            Item::findOrFail($id);
            $data = Item::find($id);
            return response()->json([
                'status' => 200,
                'message' => 'Data Berhasil ditemukan',
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Data Tidak ditemukan',
                'data' => ""
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item, $id)
    {
        $username = User::where('username', 'test')->first();
        $company_id = $username->companies->company_id;
        Item::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|min:3',
            'unit' => 'required',
            'qty' => 'required',

        ], [
            'name.required' => 'Nama Barang Harus diisi',
            'name.min' => 'Nama Barang Minimal 3 karakter',
            'unit.required' => 'Unit Barang Harus diisi',
            'qty.required' => 'Jumlah Barang Harus diisi'
        ]);
        $data = [
            'name' => $request->name,
            'unit' => $request->unit,
            'qty' => $request->qty,
            'price' => $request->price,
            'type' => $request->type,
            'description' => $request->description,
            'username' => $username->username,
            'company_id' => $company_id,
        ];
        Item::where('id', $id)->update($data);
        return response()->json([
            'status' => 200,
            'message' => 'Data Bershasil diupdate',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item, $id)
    {
        try {
            Item::findOrFail($id);
            $item->where('id', $id)->delete();
            return response()->json([
                "status" => 200,
                "message" => "Data Berhasil dihapus",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 400,
                "message" => "Data Tidak Ditemukan",
            ]);
        }
    }
}
