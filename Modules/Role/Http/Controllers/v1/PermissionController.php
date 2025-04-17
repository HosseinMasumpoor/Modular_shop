<?php

namespace Modules\Role\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Role\Repositories\PermissionRepository;

class PermissionController extends Controller
{
    public function __construct(private PermissionRepository $repository){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data =  $this->repository->index()->paginate(config('app.default_paginate_number', 10));
        successResponse($data);
    }

}
