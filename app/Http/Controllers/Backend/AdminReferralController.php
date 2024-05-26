<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Helper\MailHelper;
use App\Mail\SendReferralCode;
use App\Models\ReferralSetting;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Vinkla\Hashids\Facades\Hashids;

class AdminReferralController extends Controller
{
    /**
     * View Referral Code Generation Page
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $referralSettings = ReferralSetting::first();

        return view('admin.commissions.referral.index', compact('referralSettings'));
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
     * Send Referral Code to User
     *
     * @param Request $request
     * @return RedirectResponse|null
     */
    public function sendCode(Request $request): ?RedirectResponse
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

    /**
     * Update Referral Settings
     *
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function updateReferralSettings(Request $request, string $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'bonus' => ['required'],
            'points' => ['required'],
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->with([
                'anchor' => 'list-settings-list',
                'message' => $error,
                'alert-type' => 'error'
            ]);
        }

        ReferralSetting::updateOrCreate(
            ['id' => $id],
            [
                'bonus' => $request->input('bonus'),
                'points' => $request->input('points'),
            ]
        );

        return redirect()->back()->with([
            'anchor' => 'list-settings-list',
            'message' => 'Updated Successfully!'
        ]);
    }
}
