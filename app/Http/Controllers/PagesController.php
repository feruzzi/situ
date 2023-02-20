<?php

namespace App\Http\Controllers;

use App\Models\MasterLetter;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        return view('dashboard/index', [
            'set_active' => 'Dashboard',
            'type' => "",
            'letter' => "",
            'in_letters' => MasterLetter::where('letter_type', 'Surat Masuk')->get(),
            'out_letters' => MasterLetter::where('letter_type', 'Surat Keluar')->get(),
        ]);
    }
    public function master_letters()
    {
        return view('dashboard/master_letters', [
            'set_active' => 'master_letters',
            'type' => "",
            'letter' => "",
            'in_letters' => MasterLetter::where('letter_type', 'Surat Masuk')->get(),
            'out_letters' => MasterLetter::where('letter_type', 'Surat Keluar')->get(),
        ]);
    }
    public function letters($type, $id)
    {
        return view('dashboard/letters', [
            'set_active' => 'letters',
            'type' => $type,
            'letter' => $id,
            'letter_name' => MasterLetter::where('letter_id', $id)->value('letter_name'),
            'in_letters' => MasterLetter::where('letter_type', 'Surat Masuk')->get(),
            'out_letters' => MasterLetter::where('letter_type', 'Surat Keluar')->get(),
        ]);
    }
    public function master_items()
    {
        return view('dashboard/master_items', [
            'set_active' => 'master_items',
            'type' => "",
            'letter' => "",
            'in_letters' => MasterLetter::where('letter_type', 'Surat Masuk')->get(),
            'out_letters' => MasterLetter::where('letter_type', 'Surat Keluar')->get(),
        ]);
    }
}
