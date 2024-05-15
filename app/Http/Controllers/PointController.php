<?php

namespace App\Http\Controllers;

use App\Models\PointTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PointController extends Controller
{
    public function addPoints(Request $request)
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

        $point = $user->point;

        if (!$point) {
            // Create a wallet record for the user with a zero balance
            $point = $user->point()->create(['balance' => 0]);
        }

        $point->balance += $amount;
        $point->save();

        // Record transaction
        PointTransaction::create([
            'user_id' => $user->id,
            'type' => 'credit',
            'amount' => $amount,
        ]);

        return redirect()->back()->with(['message' => 'Points added successfully.']);
    }

    public function transferPoints(Request $request)
    {
        // Validate input
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'points' => 'required|numeric|min:0',
        ]);

        ['recipient_id' => $recipient_id, 'amount' => $amount] = $request->all();

        $validator = Validator::make($request->all(), [
            'recipient_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->with([
                'message' => $error, 'alert-type' => 'error']);
        }

        // Transfer funds between wallets
        $user = auth()->user();
        $recipient = User::findOrFail($recipient_id);

        // Check if user has sufficient balance
        if ($user->point->balance < $amount) {
            return redirect()->back()->with([
                'message' => 'Insufficient points.', 'alert-type' => 'error']);
        }

        $user->point->balance -= $amount;
        $user->point->save();

        // Record transactions
        PointTransaction::create([
            'user_id' => $user->id,
            'type' => 'debit',
            'amount' => $amount,
        ]);

        $recipient->point->balance += $amount;
        $recipient->point->save();

        PointTransaction::create([
            'user_id' => $recipient->id,
            'type' => 'credit',
            'amount' => $amount,
        ]);

        return redirect()->back()->with(['message' => 'Points transferred successfully.']);
    }
}
