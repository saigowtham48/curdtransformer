<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Validator;
use App\User;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function output(Request $request, $success, $data, $statusCode, $message) {
        header('Content-type:application/json;charset=utf-8');

        $output = json_encode([
            'success' => $success,
            'data' => $data,
            'message' => $message
        ]);

        http_response_code($statusCode);
        echo $output;
        exit(0);
    }

    public function validateEntry(Request $request, $type, $id=''){
        $user = User::find($id);

        if ($type == 'create') {
            $validator = Validator::make($request->all(), [
                        'name' => 'required|string|max:255',
                        'email' => 'required|email|unique:users,email',
                        'password' => 'required|min:8'
                    ]);
        } else {

             $validator = Validator::make($request->all(), [
                        'name' => 'required|string|max:255',
                        'email' => 'required|email|unique:users,email,'.$user->id ,
                        'password' => 'required|min:8'
                    ]);

        }

        $validationFailed = $validator->fails();
        $validationErrors = $validator->errors()->all();
            // dd($validationErrors);

        if ($validationFailed) {
            $this->output($request, false, $validationErrors, 200, 'Validation error occured');
            exit;
        }

    }
}
