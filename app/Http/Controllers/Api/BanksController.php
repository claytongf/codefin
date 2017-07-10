<?php

namespace CodeFin\Http\Controllers;

use CodeFin\Repositories\BankRepository;

class BanksController extends Controller
{
    /**
     * @var BankRepository
     */
    private $repository;

    /**
     * BanksController constructor.
     * @param BankRepository $repository
     */
    public function __construct(BankRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(){
        return $this->repository->all();
    }
}
