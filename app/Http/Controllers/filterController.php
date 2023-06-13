<?php

namespace App\Http\Controllers;

use App\Models\Azienda;
use App\Models\emissione_coupon;
use App\Models\Promozione;
use DateTime;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\Promise\all;
use Illuminate\Support\Facades\DB;

class filterController extends Controller
{
    //da aggiungere il button salva coupon
    public function filter(Request $request)
    {
        $filteredCoupons = [];
        $output = "";
        if ($request->ricercaAzienda != '' && $request->ricercaParola == '') {
            $filteredCoupons = DB::table('promozione')->join('aziendas', 'promozione.idAzienda', '=', 'aziendas.idAzienda')->where('nomeAzienda', 'Like', '%' . $request->ricercaAzienda . '%')->get();
        }
        if ($request->ricercaParola != '' && $request->ricercaAzienda == '') {
            $filteredCoupons = DB::table('promozione')->join('aziendas', 'promozione.idAzienda', '=', 'aziendas.idAzienda')->where('oggetto', 'Like', '%' . $request->ricercaParola . '%')->get();
        }
        if ($request->ricercaParola && $request->ricercaAzienda) {
            $filteredCouponsbyName = DB::table('promozione')->join('aziendas', 'promozione.idAzienda', '=', 'aziendas.idAzienda')->where('nomeAzienda', 'Like', '%' . $request->ricercaAzienda . '%')->get();
            $filteredCouponsbyWords = DB::table('promozione')->join('aziendas', 'promozione.idAzienda', '=', 'aziendas.idAzienda')->where('oggetto', 'Like', '%' . $request->ricercaParola . '%')->get();

            foreach ($filteredCouponsbyWords as $filteredCouponbyWords) {
                foreach ($filteredCouponsbyName as $filteredCouponbyName) {
                    if ($filteredCouponbyName->idPromozione == $filteredCouponbyWords->idPromozione) {
                        array_push($filteredCoupons, $filteredCouponbyName);
                    }
                }
            }
        }
        if (Auth::check()) {
            $promozioniSalvate = DB::table('emissione_coupon')->where('idUtente', Auth::user()->id)->get();
                foreach ($promozioniSalvate as $promo) {
                    for ($i=0;$i<=sizeof($filteredCoupons)-1; $i++) {
                        if ($filteredCoupons[$i]->idPromozione == $promo->idPromozione) {
                                unset($filteredCoupons[$i]);
                        }
                    }
                }
                foreach ($filteredCoupons as $coupon) {
                    $output .=
                        '<div class="promozione">
                   <p>Nome Offerta: ' . $coupon->nomePromozione . '</p>
                   <p>Oggetto Offerta:' . $coupon->oggetto . '</p>
                   <p id="scontistica"> Scontistica:' . $coupon->scontistica . ' </p>
                    <p id="nomeAzienda"> Nome Azienda: ' . $coupon->nomeAzienda . ' </p>
                    <button class="bottoni2" onclick="redirectToRoute(\'' . route('visualPromozione', ['info' => $coupon->idPromozione]) . '\')">Visualizza</button>
                    <button class="salvaCoupon" onclick="redirectToRoute(\'' . route('salvaCoupon', ['idPromozione' => $coupon->idPromozione]) . '\')">Salva Coupon</button>
                    </div>';
                }
                return response($output);
        }
        foreach ($filteredCoupons as $coupon) {
            $output .=
                '<div class="promozione">
                   <p>Nome Offerta: ' . $coupon->nomePromozione . '</p>
                   <p>Oggetto Offerta:' . $coupon->oggetto . '</p>
                   <p id="scontistica"> Scontistica:' . $coupon->scontistica . ' </p>
                    <p id="nomeAzienda"> Nome Azienda: ' . $coupon->nomeAzienda . ' </p>
                    <button class="bottoni2" onclick="redirectToRoute(\'' . route('visualPromozione', ['info'=>$coupon->idPromozione]) . '\')">Visualizza</button>
                    </div>';
        }
        return response($output);
    }
}
