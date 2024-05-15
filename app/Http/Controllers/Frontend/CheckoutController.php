<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ShippingRule;
use App\Models\UserAddress;
use Auth;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    /**
     * View Checkout Page
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $addresses = UserAddress::query()->where('user_id', '=', Auth::user()->id)->get();
        $shipping_methods = ShippingRule::query()->where('status', '=', 1)->get();

        if (cartSubtotal() === 0) {
            return redirect()->route('home');
        }

        return view('frontend.pages.checkout', compact('addresses', 'shipping_methods'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createAddress(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:200'],
            'email' => ['required', 'max:200', 'email'],
            'phone' => ['required', 'max:200'],
            'country' => ['required'],
            'state' => ['required', 'max:200'],
            'city' => ['required', 'max:200'],
            'zip' => ['required', 'max:200'],
            'address' => ['required']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->withInput()
                ->with([
                    'message' => $error,
                    'alert-type' => 'error',
                    'show_modal' => true
                ]);
        }

        $address = new UserAddress();

        $address->user_id = Auth::user()->id;
        $address->name = $request->name;
        $address->email = $request->email;
        $address->phone = $request->phone;
        $address->country = $request->country;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->zip = $request->zip;
        $address->address = $request->address;

        $address->save();

        return redirect()->back()->with(['message' => 'Address Added Successfully']);
    }

    /**
     * Setting Sessions for Shipping Rules and Address
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function checkoutFormSubmit(Request $request): Application|Response|RedirectResponse|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $validator = Validator::make($request->all(), [
            'shipping_method_id' => ['required', 'integer'],
            'shipping_address_id' => ['required', 'integer']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->with(['message' => $error, 'alert-type' => 'error']);
        }

        $shipping_rule = ShippingRule::query()->findOrFail($request->shipping_method_id);

        if ($shipping_rule) {
            Session::put('shipping_rule', [
                'id' => $shipping_rule->id,
                'name' => $shipping_rule->name,
                'type' => $shipping_rule->type,
                'cost' => $shipping_rule->cost
            ]);
        } else {
            return response(['status' => 'error']);
        }

        $address = UserAddress::query()->findOrFail($request->shipping_address_id)->toArray();

        if ($address) {
            Session::put('shipping_address', $address);
        } else {
            return response(['status' => 'error']);
        }

        return response([
            'status' => 'success',
            'redirect_url' => route('user.payment')
        ]);
    }
}
