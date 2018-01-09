<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Event extends Model implements Transformable
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
		return $this->belongsToMany(User::class)->withTimestamps();
	}
}
