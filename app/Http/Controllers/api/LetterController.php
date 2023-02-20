<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Letter;
use App\Models\MasterLetter;
use Illuminate\Http\Request;

class LetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $username = User::where('username', 'test')->first();
        $company_id = $username->companies->company_id;
        $data = Letter::where([
            ['letter_id', $id],
            ['company_id', $company_id]
        ])->get();
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
            'letter_code' => 'required|unique:letters',
            'date_created' => 'required',
            'title' => 'required|min:8',
        ], [
            'letter_code.required' => 'Nomor Surat Harus Diisi',
            'letter_code.unique' => 'Nomor Surat Sudah digunakan',
            'date_created.required' => 'Tanggal Harus Diisi',
            'title.required' => 'Judul Harus Diisi',
            'title.min' => 'Judul Minimal 8 Karakter'
        ]);
        // $letter_code = $username->companies->company_name . "-" . hash('crc32', date('H:i:s'));
        $data = [
            'letter_code' => $request->letter_code,
            'letter_id' => $request->letter_id,
            'title' => $request->title,
            'date_created' => $request->date_created,
            'description' => $request->description,
            'from' => $request->from,
            'to' => $request->to,
            'file_path' => $request->file_path,
            'username' => $username->username,
            'company_id' => $company_id
        ];
        Letter::create($data);
        return response()->json([
            'status' => 201,
            'message' => "Data Berhasil di Tambahkan",
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Letter  $letter
     * @return \Illuminate\Http\Response
     */
    public function show(Letter $letter, $id)
    {
        Letter::findOrFail($id);
        $data = Letter::find($id);
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
     * @param  \App\Models\Letter  $letter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Letter $letter, $id)
    {
        $username = User::where('username', 'test')->first();
        $company_id = $username->companies->company_id;
        Letter::findOrFail($id);
        $this->validate($request, [
            'letter_code' => 'required|unique:letters',
            'date_created' => 'required',
            'title' => 'required|min:8',
        ], [
            'letter_code.required' => 'Nomor Surat Harus Diisi',
            'letter_code.unique' => 'Nomor Surat Sudah digunakan',
            'date_created.required' => 'Tanggal Harus Diisi',
            'title.required' => 'Judul Harus Diisi',
            'title.min' => 'Judul Minimal 8 Karakter'
        ]);
        $data = [
            'letter_code' => $request->letter_code,
            'title' => $request->title,
            'date_created' => $request->date_created,
            'description' => $request->description,
            'from' => $request->from,
            'to' => $request->to,
            'file_path' => $request->file_path,
            'username' => $username->username,
            'company_id' => $company_id
        ];
        Letter::where('id', $id)->update($data);
        return response()->json([
            'status' => 200,
            'message' => 'Data Bershasil diupdate',
            'data' => $data
        ]);
    }
    public function upload(Request $request, $id)
    {
        // dd($request);
        $username = User::where('username', 'test')->first();
        $company_id = $username->companies->company_id;
        $company_name = $username->companies->company_name;
        $file = $request->file('file_path');
        $filename = $company_name . "-" . $company_id . "/" . time() . "-" . $file->getClientOriginalName();
        $file->move(public_path('uploads/' . $company_name . "-" . $company_id), $filename);
        Letter::where('id', $id)->update([
            'file_path' => $filename
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Berhasil Menambahkan File',
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Letter  $letter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Letter $letter, $id)
    {
        try {
            Letter::findOrFail($id);
            $letter->where('id', $id)->delete();
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
