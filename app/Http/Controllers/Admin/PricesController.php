<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Repair;


class PricesController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','admin','active']);
    }

    public function index()
    {
        $price = Repair::where('id',1)->firstOrFail();
        return view('admin.Prices', compact('price'));
    }

    public function modify(Request $request)
    {
        $request->validate([
            'basic_fee' => 'required|numeric',
            'expert_fee' => 'required|numeric',
            'upgrade_fee' => 'required|numeric',
            'caloocan_fee' => 'required|numeric',
            'malabon_fee' => 'required|numeric',
            'navotas_fee' => 'required|numeric',
            'valenzuela_fee' => 'required|numeric',
            'quezon_fee' => 'required|numeric',
            'marikina_fee' => 'required|numeric',
            'pasig_fee' => 'required|numeric',
            'taguig_fee' => 'required|numeric',
            'makati_fee' => 'required|numeric',
            'manila_fee' => 'required|numeric',
            'mandaluyong_fee' => 'required|numeric',
            'sanjuan_fee' => 'required|numeric',
            'pasay_fee' => 'required|numeric',
            'paranaque_fee' => 'required|numeric',
            'laspinas_fee' => 'required|numeric',
            'muntinlupa_fee' => 'required|numeric',
        ]);

        $prices = Repair::findOrFail(1);
        $prices->basic_fee = request('basic_fee');
        $prices->expert_fee = request('expert_fee');
        $prices->upgrade_fee = request('upgrade_fee');
        $prices->caloocan_fee = request('caloocan_fee');
        $prices->malabon_fee = request('malabon_fee');
        $prices->navotas_fee = request('navotas_fee');
        $prices->valenzuela_fee = request('valenzuela_fee');
        $prices->quezon_fee = request('quezon_fee');
        $prices->marikina_fee = request('marikina_fee');
        $prices->pasig_fee = request('pasig_fee');
        $prices->taguig_fee = request('taguig_fee');
        $prices->makati_fee = request('makati_fee');
        $prices->manila_fee = request('manila_fee');
        $prices->mandaluyong_fee = request('mandaluyong_fee');
        $prices->sanjuan_fee = request('sanjuan_fee');
        $prices->pasay_fee = request('pasay_fee');
        $prices->paranaque_fee = request('paranaque_fee');
        $prices->laspinas_fee = request('laspinas_fee');
        $prices->muntinlupa_fee = request('muntinlupa_fee');
        $prices->save();

        return redirect("admin/prices")->with('message', 'Prices updated.');
    }


}

