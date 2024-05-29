<?php

namespace App\Traits;

use App\Helper\MailHelper;
use App\Mail\SendReferralCode;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait ReferralTrait {
    /**
     * Send Referral Code to User
     *
     * @param Request $request
     * @return RedirectResponse|null
     */
    public function sendReferralCode(Request $request): ?RedirectResponse
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
