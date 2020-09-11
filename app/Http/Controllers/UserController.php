<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserValidator;
use App\Http\Contracts\IUserRepository;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public $userRepo;
    private $userValidator;

    public function __construct(IUserRepository $userRepo, UserValidator $userValidator)
    {
        $this->userRepo = $userRepo;
        $this->userValidator = $userValidator;
    }

    public function index()
    {
        try {
            return view('upload');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $this->userValidator->upload($request->all());
            $import = $this->userRepo->upload($data);
        } catch (ValidationException $e) {
            return redirect(route('home'))->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        try {
            $array = [
                'users' => $import,
            ];
            $data = $this->userValidator->store($array);
            $data = $this->userRepo->store($data);
            return redirect(route('home'))->with('alert-success', 'User uploaded successfully');
        } catch (ValidationException $e) {
            return redirect(route('home'))->withErrors($e->errors())->withInput($array);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}
