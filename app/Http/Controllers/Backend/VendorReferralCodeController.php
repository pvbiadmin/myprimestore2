<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Helper\MailHelper;
use App\Mail\SendReferralCode;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Vinkla\Hashids\Facades\Hashids;

class VendorReferralCodeController extends Controller
{
    /**
     * View Referral Code Generation Page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        return view('vendor.referral-code.index');
    }

    /**
     * Generate Referral Code
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
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
     * Send Referral Code to User
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'referral_code' => 'required|alpha_num',
            'from_address' => 'required|email',
            'to_address' => 'required|email',
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->with(['message' => $error, 'alert-type' => 'error']);
        }

        $to_address = $request->input('to_address');
        $from_address = $request->input('from_address');
        $referral_code = $request->input('referral_code');

        try {
            MailHelper::setMailConfig();

            // Send email using Mail facade
            Mail::to($to_address)->send(new SendReferralCode($referral_code, $from_address));

            // If email sent successfully, redirect with success message
            return redirect()->back()
                ->with(['message' => 'Referral code sent successfully!', 'alert-type' => 'success']);
        } catch (Exception) {
            // If an error occurs during email sending, redirect with error message
            return redirect()->back()
                ->with('error', 'Failed to send referral code. Please try again later.');
        }
    }
}
