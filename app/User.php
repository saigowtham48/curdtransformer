<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\imports\UserImport;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function saveUser($request, $id='') {
        if (!empty($id)) {
            $user = User::find($id);
        } else {
            $user = new User;
        }
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('password')) {
            $user->password =  Hash::make($request->password);
        }

        if ($user->save()) {
            return $user;
        } else {
            return false;
        }
    }

    public function deleteUser($id) {
        $user = new User;
        $user = User::find($id);

        if ($user->delete()) {
            return true;
        } else {
            return false;
        }

    }

    public static function importExcel($request) {
        $headers = ['Action', 'Name', 'Email', 'Password'];

       $file = $request->file('file');
       $result = Excel::import(new UserImport, $file);

   }
}
