<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\AccountCreatedMail;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ManageUserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.manage-user.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        /*dd($request->all());*/
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:200'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['user', 'vendor', 'admin'])],
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->withInput()
                ->with(['message' => $error, 'alert-type' => 'error']);
        }

        $user = new User();

        $user->fill([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
            'status' => 'active'
        ]);

        $user->save();

        if ($request->input('role') === 'vendor' || $request->input('role') === 'admin') {
            $vendor = new Vendor();

            $vendor->fill([
                'banner' => 'uploads/1343.jpg',
                'shop_name' => $request->input('name') . ' Shop',
                'phone' => '12321312',
                'email' => 'test@gmail.com',
                'address' => 'USA',
                'description' => 'shop description',
                'user_id' => $user->id,
                'status' => 1,
            ]);

            $vendor->save();
        }

        Mail::to($request->input('email'))
            ->send(new AccountCreatedMail(
                $request->input('name'),
                $request->input('email'),
                $request->input('password')
            ));

        return redirect()->back()->with(['message' => 'Created Successfully!', 'alert-type' => 'success']);
    }
}
