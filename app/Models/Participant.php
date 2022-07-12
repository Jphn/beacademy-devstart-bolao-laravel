<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'dozens',
        'points',
        'update_number',
        'active',
        'password'
    ];

    private function getAllParticipantsToUpdate(int $number)
    {
        return $this->where('active', true)
            ->where('update_number', '<', $number)
            ->get();
    }

    public function updateParticipantsPoints(int $number, array $dozens)
    {
        $activeParticipants = $this->getAllParticipantsToUpdate($number);

        foreach ($activeParticipants as $participant) {
            $diff = array_intersect(json_decode($participant->dozens), $dozens);

            $points = $participant->points + count($diff);

            $participant->update([
                'points' => $points > 10 ? 10 : $points,
                'update_number' => $number
            ]);
        }
    }
}
