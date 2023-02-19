<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MasterLetter;
use Illuminate\Http\Request;

class MasterLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterLetter::all();
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
        $this->validate($request, [
            'letter_id' => 'required|unique:master_letters',
            'letter_name' => 'required|min:5',
        ], [
            'letter_id.required' => 'ID Surat Harus diisi',
            'letter_id.required' => 'ID Surat Sudah digunakan',
            'letter_name.required' => 'Nama Surat Harus diisi',
            'letter_name.min' => 'Nama Surat Minimal 5 karakter',
        ]);
        $data = [
            'letter_id' => $request->letter_id,
            'letter_name' => $request->letter_name,
            'letter_type' => $request->letter_type
        ];
        MasterLetter::create($data);
        return response()->json([
            'status' => 201,
            'message' => "Data Berhasil di Tambahkan",
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterLetter  $masterLetter
     * @return \Illuminate\Http\Response
     */
    public function show(MasterLetter $masterLetter, $id)
    {
        MasterLetter::findOrFail($id);
        $data = MasterLetter::find($id);
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil ditemukan',
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterLetter  $masterLetter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterLetter $masterLetter, $id)
    {
        MasterLetter::findOrFail($id);
        $this->validate($request, [
            'letter_id' => 'required|exists:master_letters',
            'letter_name' => 'required|min:5',
        ], [
            'letter_id.exists' => 'ID Tidak ditemukan',
            'letter_name.required' => 'Nama Surat Harus diisi',
            'letter_name.min' => 'Nama Surat Minimal 5 karakter',
        ]);
        $data = [
            'letter_name' => $request->letter_name,
            'letter_type' => $request->letter_type
        ];
        MasterLetter::where('id', $id)->update($data);
        return response()->json([
            'status' => 200,
            'message' => 'Data Bershasil diupdate',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterLetter  $masterLetter
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterLetter $masterLetter, $id)
    {
        try {
            MasterLetter::findOrFail($id);
            $masterLetter->where('id', $id)->delete();
            return response()->json([
                "status" => 200,
                "message" => "Data Berhasil dihapus",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => "Data Tidak Ditemukan",
            ]);
        }
    }
}
