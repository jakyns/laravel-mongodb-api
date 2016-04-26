<?php

namespace Api\Repositories\Eloquent;

abstract class Repository
{
    /**
     * Retrieve a data collection list
     * @return array
     */
    public function all()
    {
        return $this->eloquent->all();
    }
}
