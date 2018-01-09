<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Event extends Model
{
	use SoftDeletes;
	use TransformableTrait;

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at'];

	protected $fillable = ['title', 'description', 'start_date', 'end_date'];

	public function user() {
		return $this->belongsToMany(User::class, 'user_event')->withTimestamps();
	}

	public function check($startDate, $endDate) {
		return $this->where(function($q) use ($startDate, $endDate) {
					$q->where(function ($q) use ($startDate, $endDate){
						$q->whereBetween('start_date', [$startDate, $endDate]);
					})
					->orWhere(function($q) use ($startDate, $endDate){
					    $q->whereBetween('end_date', [$startDate, $endDate]);
					})
					->orWhere(function ($q) use ($startDate, $endDate){
						$q->where( 'start_date', '<=', $startDate )
							->where( 'end_date', '>=', $endDate );
					});
				})
				->where('id', '!=', $this->id)
				->count();
	}
}
