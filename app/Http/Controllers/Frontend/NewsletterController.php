<?php

namespace App\Http\Controllers\Frontend;

use App\Helper\MailHelper;
use App\Http\Controllers\Controller;
use App\Mail\SubscriptionVerification;
use App\Models\NewsletterSubscriber;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function newsLetterRequest(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return response([
                'status' => 'error',
                'message' => $error
            ]);
        }

        $subscriber = NewsletterSubscriber::query()->where('email', $request->email)->first();

        if ($subscriber) {
            if ($subscriber->is_verified == 0) {
                $subscriber->update(['verified_token' => Str::random(25)]);

                $this->sendVerificationEmail($subscriber);

                return response([
                    'status' => 'success',
                    'message' => 'A new verification link has been sent to your email.'
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'message' => 'You already subscribed with this email!'
                ]);
            }
        } else {
            $subscriber = NewsletterSubscriber::query()->create([
                'email' => $request->email,
                'verified_token' => Str::random(25),
                'is_verified' => 0
            ]);

            $this->sendVerificationEmail($subscriber);

            return response([
                'status' => 'success',
                'message' => 'A verification link has been sent to your email.'
            ]);
        }
    }

    /**
     * @param $subscriber
     */
    private function sendVerificationEmail($subscriber)
    {
        // set mail config
        MailHelper::setMailConfig();
        // send mail
        Mail::to($subscriber->email)->send(new SubscriptionVerification($subscriber));
    }

    /**
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function newsLetterEmailVerify($token): RedirectResponse
    {
        $subscriber = NewsletterSubscriber::query()->where('verified_token', $token)->first();

        if ($subscriber) {
            $subscriber->update(['verified_token' => 'verified', 'is_verified' => 1]);

            return redirect()->route('home')
                ->with(['message' => 'Email verified successfully']);
        } else {
            return redirect()->route('home')
                ->with([
                    'message' => 'Invalid token',
                    'alert-type' => 'error'
                ]);
        }
    }
}

