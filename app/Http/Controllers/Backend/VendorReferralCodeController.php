<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ReferralTrait;
use Vinkla\Hashids\Facades\Hashids;

class VendorReferralCodeController extends Controller
{
    use ReferralTrait;

    /**
     * View Referral Code Generation Page
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        return view('vendor.referral-code.index');
    }

    /**
     * Generate Referral Code
     *
     * @return Application|ResponseFactory|\Illuminate\Foundation\Application|Response
     */
    public function generateCode()
    {
        if (!auth()->check()) {
            return response([
                'status' => 'error',
                'message' => 'Login required.'
            ], 402);
        }

        $code = Hashids::encode(auth()->user()->id);

        return response([
            'status' => 'success',
            'message' => $code
        ]);
    }

    /**
     * Send Referral Code to Vendor
     *
     * @param Request $request
     * @return RedirectResponse|null
     */
    public function sendCode(Request $request): ?RedirectResponse
    {
        return $this->sendReferralCode($request);
    }
}
