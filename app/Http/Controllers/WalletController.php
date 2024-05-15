<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class WalletController extends Controller
{
    /**
     * Add Funds to Wallet
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addFunds(Request $request)
    {
        ['amount' => $amount] = $request->all();

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0',
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->with(['message' => $error, 'alert-type' => 'error']);
        }

        // Add funds to the user's wallet
        $user = auth()->user();

        $wallet = $user->wallet;

        if (!$wallet) {
            // Create a wallet record for the user with a zero balance
            $wallet = $user->wallet()->create(['balance' => 0]);
        }

        $wallet->balance += $amount;
        $wallet->save();

        // Record transaction
        WalletTransaction::create([
            'wallet_id' => $user->wallet->id,
            'type' => 'credit',
            'amount' => $amount,
        ]);

        return redirect()->back()->with(['message' => 'Funds added successfully.']);
    }

    /**
     * Transfer Funds from Wallet
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function transferFunds(Request $request)
    {
        ['recipient_id' => $recipient_id, 'amount' => $amount] = $request->all();

        $validator = Validator::make($request->all(), [
            'recipient_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->with(['message' => $error, 'alert-type' => 'error']);
        }

        // Transfer funds between wallets
        $user = auth()->user();
        $recipient = User::findOrFail($recipient_id);

        // Check if user has sufficient balance
        if ($user->wallet->balance < $amount) {
            return redirect()->back()->with([
                'message' => 'Insufficient balance.', 'alert-type' => 'error']);
        }

        $user->wallet->balance -= $amount;
        $user->wallet->save();

        // Record transactions
        WalletTransaction::create([
            'wallet_id' => $user->wallet->id,
            'type' => 'debit',
            'amount' => $amount,
        ]);

        $recipient->wallet->balance += $amount;
        $recipient->wallet->save();

        WalletTransaction::create([
            'wallet_id' => $recipient->wallet->id,
            'type' => 'credit',
            'amount' => $amount,
        ]);

        return redirect()->back()->with(['message' => 'Funds transferred successfully.']);
    }
}
