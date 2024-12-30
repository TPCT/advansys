<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Responses;
use App\Http\Controllers\Controller;
use App\Models\Admin;

class UsersController extends Controller
{
    public function index(){
        $users = Admin::where('id', '!=', auth()->id())->paginate(10);
        return Responses::success([
            'current_page' => $users->currentPage(),
            'per_page' => $users->perPage(),
            'total' => $users->total(),
            'users' => $users->getCollection()
        ]);
    }

    public function show($locale, Admin $admin){
        return Responses::success($admin);
    }

    public function create(){
        $data = request()->only(['name', 'email', 'password', 'password_confirmation', 'super_admin']);
        $validator = \Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'super_admin' => ['required', 'boolean']
        ]);

        if ($validator->fails())
            return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));

        $data['password'] = \Hash::make($data['password']);
        unset($data['password_confirmation']);
        $admin = Admin::create($data);
        return Responses::success($admin);
    }

    public function update($locale, Admin $admin){
        $data = request()->only(['name', 'email', 'password', 'password_confirmation', 'super_admin']);
        $validator = \Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email,' . $admin->id],
            'password' => ['sometimes', 'string', 'min:8', 'confirmed'],
            'super_admin' => ['required', 'boolean']
        ]);

        if ($validator->fails())
            return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));

        if (isset($data['password'])) {
            $data['password'] = \Hash::make($data['password']);
            unset($data['password_confirmation']);
        }
        $admin->update($data);
        return Responses::success($admin);
    }

    public function delete($locale, Admin $admin){
        $admin->delete();
        return Responses::success([], 200, __('site.Admin Deleted Successfully'));
    }
}
