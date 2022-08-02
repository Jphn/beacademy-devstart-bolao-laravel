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

	protected $casts = [
		'dozens' => 'array',
		'active' => 'boolean'
	];

	protected $hidden = [
		'password',
		'updated_at',
		'created_at'
	];

	protected $appends = [
		'string_dozens'
	];

	public function getParticipants(string $search = null)
	{
		$participants = $this->orderBy('id')->where(function ($query) use ($search) {
			if ($search) {
				$query->where('name', 'LIKE', "%{$search}%");
				$query->orWhere('phone', 'LIKE', "%{$search}%");
			}
		})->get();

		return $participants;
	}


	public function updateParticipantsPoints(int $number, array $dozens)
	{
		$activeParticipants = $this->getAllParticipantsToUpdate($number);

		foreach ($activeParticipants as $participant) {
			$diff = array_intersect($participant->dozens, $dozens);

			$points = $participant->points + count($diff);

			$participant->update([
				'points' => $points > 10 ? 10 : $points,
				'update_number' => $number
			]);
		}
	}

	private function getAllParticipantsToUpdate(int $number)
	{
		return $this->where('active', true)
			->where('update_number', '<', $number)
			->get();
	}

	public function getStringDozensAttribute()
	{
		return implode(', ', $this->dozens);
	}
}
