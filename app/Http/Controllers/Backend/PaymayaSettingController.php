<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PaymayaSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PaymayaSettingController extends Controller
{
    /**
     * Update COD Settings
     *
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'status' => ['required'],
            'name' => ['required'],
            'number' => ['required'],
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->with([
                'anchor' => 'list-paymaya-list',
                'message' => $error,
                'alert-type' => 'error'
            ]);
        }

        PaymayaSetting::updateOrCreate(
            ['id' => $id],
            [
                'status' => $request->input('status'),
                'name' => $request->input('name'),
                'number' => $request->input('number'),
            ]
        );

        return redirect()->back()->with([
            'anchor' => 'list-paymaya-list',
            'message' => 'Updated Successfully!'
        ]);
    }
}
