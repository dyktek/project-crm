<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EventRepository;
use App\Entities\Event;

/**
 * Class EventRepositoryEloquent
 * @package namespace App\Repositories;
 */
class EventRepositoryEloquent extends BaseRepository implements EventRepository
{
	public function getEvents($startDate, $endDate)
	{
		return $this
			->findWhere([
				['start_date', '>=', $startDate],
				['end_date', '<=', $endDate]
			]);
	}

	public function check($startDate, $endDate, $id = null)
	{
		return $this
			->findWhere([
				['start_date', '<=', $endDate],
				['end_date', '>=', $startDate],
				['id', '!=', $id]
			])->count();
	}

	public function createEvent($params, $userId)
	{
		$event = $this
			->create($params)
			->user()
			->attach($userId);

		return $event;
	}

	public function editEvent($params, $id)
	{
		$event = $this->update($params, $id);
		return $event;
	}

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Event::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
