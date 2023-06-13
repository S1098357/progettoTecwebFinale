<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class testController extends Controller
{
    public function index()
    {
        return view('test/image');
    }

    public function storeImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ]);
        $nomeAzienda=$request->nomeAzienda;
        $ragioneSociale =$request->ragioneSociale;
        $localizzazione = $request->localizzazione;
        $tipologia = $request->tipologia;
        $descrizioneAzienda = $request->descrizioneAzienda;
        $imageName = time().'.'.$request->image->extension();


        $request->image->move(public_path('images'), $imageName);

        DB::insert('insert into photo (imageName) values (?)', [$imageName]);
        DB::table('azienda2')->insert([
            'nomeAzienda' => $nomeAzienda,
            'logo' => $imageName,
            'ragioneSociale' =>$ragioneSociale,
            'localizzazione'=>$localizzazione,
            'tipologia' => $tipologia,
            'descrizioneAzienda' => $descrizioneAzienda
        ]);


        return back()->with('success', 'Image uploaded Successfully!')
            ->with('image', $imageName);
    }

}
