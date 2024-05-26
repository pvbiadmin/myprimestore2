<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CodSetting;
use App\Models\GcashSetting;
use App\Models\PaymayaSetting;
use App\Models\PaypalSetting;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class PaymentSettingController extends Controller
{
    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $paypal = PaypalSetting::first();
        $codSetting = CodSetting::first();
        $gcashSetting = GCashSetting::first();
        $paymayaSetting = PaymayaSetting::first();

        return view('admin.payment-settings.index',
            compact('paypal', 'codSetting', 'gcashSetting', 'paymayaSetting'));
    }
}
