<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AttachmentRepository;
use App\Entities\Attachment;
use App\Validators\AttachmentValidator;

/**
 * Class AttachmentRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AttachmentRepositoryEloquent extends BaseRepository implements AttachmentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Attachment::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return AttachmentValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
