<?php

namespace App\Traits;

use App\Models\PointTransaction;
use App\Models\User;
use JsonException;

trait PointTrait {
    /**
     * Add to user Points
     *
     * @param $user_id
     * @param $value
     * @param array $details
     * @param string $type
     * @throws JsonException
     */
    public static function addToPoints($user_id, $value, $details = [], $type = 'credit'): void
    {
        $user = User::findOrFail($user_id);

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

        PointTransaction::create($data);
    }
}
