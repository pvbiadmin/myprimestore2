<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CodSetting;
use App\Models\Coupon;
use App\Models\GcashSetting;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\PaymayaSetting;
use App\Models\PaypalSetting;
use App\Models\PointTransaction;
use App\Models\Product;
use App\Models\Referral;
use App\Models\ReferralSetting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WalletTransaction;
use Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use JetBrains\PhpStorm\ArrayShape;
use JsonException;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Exception;
use Str;
use Throwable;

class PaymentController extends Controller
{
    /**
     * View Payment Page
     *
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        if (!Session::has('shipping_rule')
            || !Session::has('shipping_address')) {
            return redirect()->route('user.checkout');
        }

        return view('frontend.pages.payment');
    }

    /**
     * View Payment Success Page
     *
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function paymentSuccess(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('frontend.pages.payment-success');
    }

    /**
     * View Payment COD Page
     *
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function paymentCod(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('frontend.pages.payment-cod');
    }

    /**
     * View Payment GCash Page
     *
     * @param $order_id
     * @param $payable
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function paymentGCash($order_id, $payable): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $gcashSettings = GcashSetting::first();

        return view('frontend.pages.payment-gcash',
            compact('gcashSettings', 'order_id', 'payable'));
    }

    /**
     * View Payment Paymaya Page
     *
     * @param $order_id
     * @param $payable
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function paymentPaymaya($order_id, $payable): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $paymayaSettings = PaymayaSetting::first();

        return view('frontend.pages.payment-paymaya',
            compact('paymayaSettings', 'order_id', 'payable'));
    }

    /**
     * Store All Orders
     *
     * @param $payment_method
     * @param $payment_status
     * @param $transaction_id
     * @param $paid_amount
     * @param $paid_currency_name
     * @return Order
     * @throws Exception
     */
    public function storeOrder(
        $payment_method, $payment_status, $transaction_id, $paid_amount, $paid_currency_name): Order
    {
        $general_settings = GeneralSetting::query()->firstOrFail();

        $order = new Order();

        $order->invoice_id = random_int(1, 999999);
        $order->user_id = Auth::user()->id;
        $order->subtotal = cartSubtotal();
        $order->amount = payableTotal();
        $order->currency_name = $general_settings->currency_name;
        $order->currency_icon = $general_settings->currency_icon;
        $order->product_quantity = Cart::content()->count();
        $order->payment_method = $payment_method;
        $order->payment_status = $payment_status;
        $order->order_address = json_encode(Session::get('shipping_address'), JSON_THROW_ON_ERROR);
        $order->shipping_method = json_encode(Session::get('shipping_rule'), JSON_THROW_ON_ERROR);
        $order->coupon = json_encode(Session::get('coupon'), JSON_THROW_ON_ERROR);
        $order->order_status = 'pending';

        $order->save();

        $this->storeOrderProduct($order->id);
        $this->updateCoupon();
        $this->storeOrderTransaction(
            $order->id, $transaction_id, $payment_method, $paid_amount, $paid_currency_name);

        return $order;
    }

    /**
     * Enter user into referral table with activation
     * Add to sponsor wallet
     * Add to sponsor points
     *
     * @param array $details
     * @param string $type
     * @param bool $activated
     * @return void
     * @throws JsonException
     */
    public function referralEntry($details = [], $type = 'credit', $activated = true): void
    {
        $referral_session = Session::get('referral');

        if ($referral_session && isset($referral_session['id'])) {
            $referral_id = $referral_session['id'];
            $package = $referral_session['package'];

            $product = Product::whereProductTypeId($package)->first();
            $product_price = $product->price ?? 0;
            $product_points = $product->points ?? 0;

//            dd($product);

            $referralSettings = ReferralSetting::wherePackage($package)->first();
            $referral_bonus = $referralSettings->bonus / 100;
            $referral_points = $referralSettings->points / 100;

            $bonus = $product_price * $referral_bonus;
            $points = $product_points * $referral_points;

//            dd(
//                [
//                    'product' => ['price' => $product_price, 'points' => $product_points],
//                    'referrral_settings' => [
//                        'bonus' => $referralSettings->bonus / 100,
//                        'points' => $referralSettings->points / 100
//                    ]
//                ]
//            );

            // encode into referral table and activate
            Referral::create([
                'referrer_id' => $referral_id,
                'referred_id' => auth()->user()->id,
                'status' => $activated ? 1 : 0,
            ]);

            $this->addToWallet($referral_id, $bonus, $details, $type);
            $this->addToPoints($referral_id, $points, $details, $type);
        }
    }

    /**
     * Add point rewards
     *
     * @throws JsonException
     */
    public function pointRewards($details = [], $type = 'credit'): void
    {
        $user_id = Auth::user()->id;

        $point_reward_session = Session::get('point_reward');

//        dd($point_reward_session);

        if ($point_reward_session && isset($point_reward_session['id'])) {
            $product = Product::findOrFail($point_reward_session['product_id']);
            $referralSettings = ReferralSetting::first();

//            dd($referralSettings);

            $points = $product->points * $point_reward_session['quantity'] * $referralSettings->points / 100;

//            dd($points);

            $this->addToPoints($user_id, $points, $details, $type);
        }
    }

    /**
     * Add to user wallet
     *
     * @param $user_id
     * @param $value
     * @param array $details
     * @param string $type
     * @throws JsonException
     */
    public function addToWallet($user_id, $value, $details = [], $type = 'credit'): void
    {
        $user = User::findOrFail($user_id);

        // add bonus and points to referrer
        $wallet = $user->wallet;

        if (!$wallet) {
            // Create a wallet record for the user with a zero balance
            $wallet = $user->wallet()->create(['balance' => 0]);
        }

        $wallet->balance += ($type === 'credit' ? $value : 0);
        $wallet->save();

        $data = [
            'wallet_id' => $wallet->id,
            'type' => $type,
            'amount' => $value,
            'details' => json_encode($details, JSON_THROW_ON_ERROR)
        ];

//        if ($details !== []) {
//            $data['details'] = json_encode($details, JSON_THROW_ON_ERROR);
//        }

        WalletTransaction::create($data);
    }

    /**
     * Add to user Points
     *
     * @param $user_id
     * @param $value
     * @param array $details
     * @param string $type
     * @throws JsonException
     */
    public function addToPoints($user_id, $value, $details = [], $type = 'credit'): void
    {
        $user = User::findOrFail($user_id);

//        dd($user);

        // add to user points
        $points = $user->point;

        if (!$points) {
            // Create a wallet record for the user with a zero balance
            $points = $user->point()->create(['balance' => 0]);
        }

        $points->balance += ($type === 'credit' ? $value : 0);
        $points->save();

        $data = [
            'point_id' => $points->id,
            'type' => $type,
            'points' => $value,
            'details' => json_encode($details, JSON_THROW_ON_ERROR)
        ];

//        dd($data);

//        if (!empty($details)) {
//            $data['details'] = json_encode($details, JSON_THROW_ON_ERROR);
//        }

        PointTransaction::create($data);
    }

    /**
     * Update coupon
     */
    public function updateCoupon(): void
    {
        $coupon_session = Session::get('coupon');

        // Check if the coupon session exists
        if ($coupon_session && isset($coupon_session['id'])) {
            $coupon_tbl = Coupon::find($coupon_session['id']);

            // Check if the coupon was found
            if ($coupon_tbl) {
                // Increment total_use
                ++$coupon_tbl->total_use;

                // If total_use reaches max_use, update quantity
                if ($coupon_tbl->total_use === $coupon_tbl->max_use) {
                    --$coupon_tbl->quantity;
                }

                $coupon_tbl->save();
            }
        }
    }

    /**
     * Store All Ordered Products
     *
     * @param $order_id
     * @throws JsonException
     */
    public function storeOrderProduct($order_id): void
    {
        $cart_items = Cart::content();

        if ($cart_items->count() > 0) {
            foreach ($cart_items as $item) {
                $order_product = new OrderProduct();

                $product = Product::query()->find($item->id);

                $order_product->order_id = $order_id;
                $order_product->product_id = $product->id;
                $order_product->vendor_id = $product->vendor_id;
                $order_product->product_name = $product->name;
                $order_product->product_variant = json_encode($item->options->variants, JSON_THROW_ON_ERROR);
                $order_product->product_variant_price_total = $item->options->variant_price_total;
                $order_product->unit_price = $item->price;
                $order_product->quantity = $item->qty;

                $order_product->save();

                // update product quantity
                $updatedQty = ($product->quantity - $item->qty);
                $product->quantity = $updatedQty;
                $product->save();
            }
        }
    }

    /**
     * Store Order Transactions
     *
     * @param $order_id
     * @param $transaction_id
     * @param $payment_method
     * @param $paid_amount
     * @param $paid_currency_name
     */
    public function storeOrderTransaction(
        $order_id, $transaction_id, $payment_method, $paid_amount, $paid_currency_name): void
    {
        $transaction = new Transaction();

        $transaction->order_id = $order_id;
        $transaction->transaction_id = $transaction_id;
        $transaction->payment_method = $payment_method;
        $transaction->amount_base_currency = payableTotal();
        $transaction->amount_used_currency = $paid_amount;
        $transaction->name_used_currency = $paid_currency_name;

        $transaction->save();
    }

    /**
     * Clear Session
     */
    public function clearSession(): void
    {
        Cart::destroy();

        Session::forget('shipping_address');
        Session::forget('shipping_rule');
        Session::forget('coupon');
        Session::forget('point_reward');
        Session::forget('referral');
    }

    /**
     * Paypal Configuration Settings
     *
     * @return array
     */
    #[ArrayShape([
        'mode' => "string",
        'sandbox' => "array",
        'live' => "array",
        'payment_action' => "string",
        'currency' => "\Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed",
        'notify_url' => "string",
        'locale' => "string",
        'validate_ssl' => "bool"
    ])]
    public function paypalConfig(): array
    {
        $setting = PaypalSetting::query()->first();

        if ($setting) {
            return [
                'mode' => $setting->mode === 1 ? 'live' : 'sandbox',
                'sandbox' => [
                    'client_id' => $setting->client_id,
                    'client_secret' => $setting->secret_key,
                    'app_id' => '',
                ],
                'live' => [
                    'client_id' => $setting->client_id,
                    'client_secret' => $setting->secret_key,
                    'app_id' => '',
                ],

                'payment_action' => 'Sale',
                'currency' => $setting->currency_name,
                'notify_url' => '',
                'locale' => 'en_US',
                'validate_ssl' => true,
            ];
        }

// Default configuration if setting is not found
        return [
            'mode' => 'sandbox', // or 'live' based on your default preference
            'sandbox' => [
                'client_id' => '',
                'client_secret' => '',
                'app_id' => '',
            ],
            'live' => [
                'client_id' => '',
                'client_secret' => '',
                'app_id' => '',
            ],

            'payment_action' => 'Sale',
            'currency' => 'USD', // or any default currency
            'notify_url' => '',
            'locale' => 'en_US',
            'validate_ssl' => true,
        ];
    }

    /**
     * Handle payment with PayPal.
     *
     * @return RedirectResponse
     * @throws Exception|Throwable
     */
    public function payWithPaypal(): RedirectResponse
    {
        try {
            $setting = PaypalSetting::query()->firstOrFail();
            $config = $this->paypalConfig();

            $provider = new PayPalClient($config);
            $provider->getAccessToken();

            $total = payableTotal();
            $value = round($total * $setting->currency_rate, 2);

            $response = $this->createPaypalOrder($provider, $config, $value);

            if ($response && isset($response['id'])) {
                $approvalLink = $this->findApprovalLink($response);
                if ($approvalLink) {
                    return redirect()->away($approvalLink);
                }
            }

            return redirect()->route('user.paypal.cancel');
        } catch (Exception $e) {
            return redirect()->back()
                ->with([
                    'message' => $e->getMessage(),
                    'alert-type' => 'error'
                ]);
//            throw $e;
        }
    }

    /**
     * Create PayPal order.
     *
     * @param PayPalClient $provider
     * @param array $config
     * @param float $value
     * @return array|null
     * @throws Exception|Throwable
     */
    private function createPaypalOrder(PayPalClient $provider, array $config, float $value): ?array
    {
        try {
            return $provider->createOrder([
                'intent' => 'CAPTURE',
                'application_context' => [
                    'return_url' => route('user.paypal.success'),
                    'cancel_url' => route('user.paypal.cancel')
                ],
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => $config['currency'],
                            'value' => $value
                        ]
                    ]
                ]
            ]);
        } catch (Exception $e) {
            // Handle exceptions gracefully
            throw $e;
        }
    }

    /**
     * Find approval link in PayPal response.
     *
     * @param array $response
     * @return string|null
     */
    private function findApprovalLink(array $response): ?string
    {
        if (isset($response['links']) && is_array($response['links'])) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return $link['href'];
                }
            }
        }

        return null;
    }

    /**
     * Handle successful PayPal payment.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws Throwable
     */
    public function paypalSuccess(Request $request): RedirectResponse
    {
        try {
            $config = $this->paypalConfig();

            $provider = new PayPalClient($config);
            $provider->getAccessToken();

            $response = $provider->capturePaymentOrder($request->input('token'));

            // Check if $response is not null and has 'status' and 'id' keys
            if ($response && isset($response['status'], $response['id']) && $response['status'] === 'COMPLETED') {
                $paypal_setting = PaypalSetting::query()->firstOrFail();

                $payableAmount = payableTotal() * $paypal_setting->currency_rate;

                if ($payableAmount) {
                    $order = $this->storeOrder(
                        'paypal',
                        1,
                        $response['id'],
                        payableTotal() * $paypal_setting->currency_rate,
                        $paypal_setting->currency_name
                    );

                    $flag = false;

                    if (!$flag) {
                        $this->referralEntry(['order_id' => $order->id]);
                        $this->pointRewards(['order_id' => $order->id]);

                        $flag = true;
                    }

                    if ($flag) {
                        $this->clearSession();
                    }

                    return redirect()->route('user.payment.success');
                }

                return redirect()->route('user.paypal.cancel');
            }
        } catch (Throwable $exception) {
            // Log the exception or handle it appropriately
            if ($exception) {
                logger()?->error('Error processing PayPal success action: ' . $exception->getMessage());
            }
        }

        return redirect()->route('user.paypal.cancel');
    }

    /**
     * Handle Payment Error
     *
     * @return RedirectResponse
     */
    public function paypalCancel(): RedirectResponse
    {
        return redirect()->route('user.payment')
            ->with([
                'message' => 'Transaction Cancelled',
                'alert-type' => 'warning'
            ]);
    }

    /**
     * Cash-on-Delivery Payment
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function payWithCod(): RedirectResponse
    {
        $codPaySetting = CodSetting::query()->first();
        $setting = GeneralSetting::first();

        if ($codPaySetting && $codPaySetting->status === 0) {
            return redirect()->back();
        }

        // amount calculation
        $payableAmount = round(payableTotal(), 2);

        if ($payableAmount) {
            $order = $this->storeOrder(
                'COD',
                0,
                Str::random(10),
                $payableAmount,
                $setting->currency_name
            );

            $flag = false;

            if (!$flag) {
                $this->referralEntry(['order_id' => $order->id], 'pending_credit', false);
                $this->pointRewards(['order_id' => $order->id], 'pending_credit');

                $flag = true;
            }

            if ($flag) {
                $this->clearSession();
            }

            return redirect()->route('user.payment.cod');
        }

        return redirect()->route('user.payment')->with([
            'message' => 'Something went wrong, please try again.', 'alert-type' => 'error']);
    }

    /**
     * GCash Payment
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function payWithGCash(): RedirectResponse
    {
        $gcashSettings = GcashSetting::first();
        $setting = GeneralSetting::first();

        if ($gcashSettings && $gcashSettings->status === 0) {
            return redirect()->back();
        }

        // amount calculation
        $payableAmount = round(payableTotal(), 2);

        if ($payableAmount > 0) {
            $order = $this->storeOrder(
                'GCASH',
                0,
                Str::random(10),
                $payableAmount,
                $setting->currency_name
            );

            $flag = false;

            if (!$flag) {
                $details = ['order_id' => $order->id];

                $this->referralEntry($details, 'pending_credit', false);
                $this->pointRewards($details, 'pending_credit');

                $flag = true;
            }

            if ($flag) {
                $this->clearSession();
            }

            return redirect()->route('user.payment.gcash', [
                'order_id' => $order->id,
                'payable' => $payableAmount
            ]);
        }

        return redirect()->route('user.payment')->with([
            'message' => 'Something went wrong, please try again.', 'alert-type' => 'error']);
    }

    /**
     * Paymaya Payment
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function payWithPaymaya(): RedirectResponse
    {
        $paymayaSettings = PaymayaSetting::first();
        $setting = GeneralSetting::first();

        if ($paymayaSettings && $paymayaSettings->status === 0) {
            return redirect()->back();
        }

        // amount calculation
        $payableAmount = round(payableTotal(), 2);

        if ($payableAmount) {
            $order = $this->storeOrder(
                'PAYMAYA',
                0,
                Str::random(10),
                $payableAmount,
                $setting->currency_name
            );

            $flag = false;

            if (!$flag) {
                $this->referralEntry(['order_id' => $order->id], 'pending_credit', false);
                $this->pointRewards(['order_id' => $order->id], 'pending_credit');

                $flag = true;
            }

            if ($flag) {
                $this->clearSession();
            }

            return redirect()->route('user.payment.paymaya', [
                'order_id' => $order->id,
                'payable' => $payableAmount
            ]);
        }

        return redirect()->route('user.payment')->with([
            'message' => 'Something went wrong, please try again.', 'alert-type' => 'error']);
    }
}
