<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
// use Maatwebsite\Excel\Concerns\withHeadingrow;
use Illuminate\Support\Facades\Hash;

class UserImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   
        if ($row[0] == 'delete') {
            $user = User::where('email',$row[2])->where('name',$row[1])->first();
            if ($user && Hash::check($row[3], $user->password)) {
                $user->delete();
            }
        }
        if ($row[0] == 'insert') {
            $user = User::where('email',$row[2])->first();

            if (!$user ) {
                $newuser = new User;
                $newuser->name = $row[1];
                $newuser->email = $row[2];
                $newuser->password = Hash::make($row[3]);
                $newuser->save();
            }
        }
        if ($row[0] == 'update') {

            $user = User::where('email',$row[2])->first();

            if ($user) {
                $user->name = $row[1];
                $user->email = $row[2];
                $user->password = Hash::make($row[3]);
                $user->save();
            }
        }

        
    }
}
