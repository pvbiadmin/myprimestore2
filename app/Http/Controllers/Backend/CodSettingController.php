<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CodSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CodSettingController extends Controller
{
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => ['required', 'integer'],
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->with([
                'anchor' => 'list-cod-list',
                'message' => $error,
                'alert-type' => 'error'
            ]);
        }

        CodSetting::query()->updateOrCreate(
            ['id' => $id],
            ['status' => $request->status,]
        );

        return redirect()->back()->with([
            'anchor' => 'list-cod-list',
            'message' => 'Updated Successfully!'
        ]);
    }
}
