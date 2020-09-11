<?php
namespace App\Http\Repositories;

use App\User;
use Exception;
use App\Location;
use App\Imports\UserImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Contracts\IUserRepository;
use App\Exceptions\ReportValidationException;
use Illuminate\Validation\ValidationException;


class UserRepository implements IUserRepository
{
    public function index()
    {
        try {
            return Location::whereLike(['code', 'title' ], $search)->orderBy('order_by')->paginate();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function upload($array)
    {
        try {
            $import = new UserImport;
            $array = Excel::toArray($import, $array['upload']);
            return $array[0];
        } catch (ReportValidationException $e) {
            $error = ValidationException::withMessages([
                'upload' => [$e->getMessage()],
             ]);
             throw $error;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function store($array)
    {
        try {
            DB::beginTransaction();
            foreach($array['users'] as $user){
                $user['password'] = bcrypt('password');
                User::create($user);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw new Exception($e->getMessage());
        }
    }
}

