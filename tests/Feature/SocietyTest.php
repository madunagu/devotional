<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Society;
use Kirkbater\Testing\SoftDeletes;

class SocietyTest extends CrudTest
{
    use SoftDeletes;

    /**
     * The model to use when creating dummy data
     *
     * @var class
     */
    protected $model = Society::class;
    /**
     * The endpoint to query in the API
     * e.g = /api/v1/<endpoint>
     *
     * @var string
     */
    protected $endpoint = 'societies';
    /**
     * Any additional "states" to add to factory
     *
     * @var string
     */
    protected $states = 'strains';
    /**
     * Extra data to pass to POST endpoint
     * aka the (store() method)
     *
     * Must be array (ends up merged with another)
     *
     * @var array
     */
    protected $store = [

    ];
}
