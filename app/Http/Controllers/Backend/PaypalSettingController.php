<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PaypalSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PaypalSettingController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'status' => ['required'],
            'mode' => ['required'],
            'country' => ['required'],
            'name_currency' => ['required'],
            'icon_currency' => ['required'],
            'rate_currency' => ['required', 'numeric'],
            'client_id' => ['required'],
            'secret_key' => ['required']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->with([
                'anchor' => 'list-paypal-list',
                'message' => $error,
                'alert-type' => 'error'
            ]);
        }

        $update = PaypalSetting::query()->updateOrCreate(
            ['id' => $id],
            [
                'status' => $request->input('status'),
                'mode' => $request->input('mode'),
                'country' => $request->input('country'),
                'currency_name' => $request->input('name_currency'),
                'currency_icon' => $request->input('icon_currency'),
                'currency_rate' => $request->input('rate_currency'),
                'client_id' => $request->input('client_id'),
                'secret_key' => $request->input('secret_key')
            ]
        );

        if ($update) {
            $notification = [
                'anchor' => 'list-paypal-list',
                'message' => 'Paypal Settings Updated Successfully'
            ];
        } else {
            $notification = [
                'anchor' => 'list-paypal-list',
                'message' => 'Something went wrong',
                'alert-type' => 'error'
            ];
        }

        return redirect()->back()->with($notification);
    }
}
