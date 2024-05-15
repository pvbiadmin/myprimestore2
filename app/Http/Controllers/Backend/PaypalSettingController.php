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
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
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
                'message' => $error,
                'alert-type' => 'error'
            ]);
        }

        $update = PaypalSetting::query()->updateOrCreate(
            ['id' => $id],
            [
                'status' => $request->status,
                'mode' => $request->mode,
                'country' => $request->country,
                'currency_name' => $request->name_currency,
                'currency_icon' => $request->icon_currency,
                'currency_rate' => $request->rate_currency,
                'client_id' => $request->client_id,
                'secret_key' => $request->secret_key
            ]
        );

        if ($update) {
            $notification = ['message' => 'Paypal Settings Updated Successfully'];
        } else {
            $notification = ['message' => 'Something went wrong', 'alert-type' => 'error'];
        }

        return redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
