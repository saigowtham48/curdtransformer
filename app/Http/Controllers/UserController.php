<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Laravel\Passport\HasApiTokens;
use Maatwebsite\Excel\Facades\Excel;

use Validator;
use App\User;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {

    }

    /**
     * Show the form to show all.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::paginate(10);

        return UserResource::collection($users);
    }

    /**
     * Show the form to create a new .
     *
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a new request.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validateEntry($request, 'create');

        $user = new User;
        $result = $user->saveUser($request);
        $result = new UserResource($result);
        $data['user'] = $result;
        if ($result) {
            $token = $user->createToken('accces_token')->accessToken;
            $data['accessToken'] = $token;
            $this->output($request, true, $data , 200, 'success');
        } else {
            $this->output($request, false, [], 200, 'fail');
        }
    }
    /**
     * Update the given user.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (empty($user)) {
            $this->output($request, false, [], 200, 'user not found');
        }

        $this->validateEntry($request, 'update', $id);
        $user = new User;
        $result = $user->saveUser($request, $id);
        $result = new UserResource($result);

        if ($result) {
            $this->output($request, true, $result , 200, 'success');
        } else {
            $this->output($request, false, [], 200, 'fail');
        }
    }
    /**
     * delete the given user.
     *
     * @param  string  $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return response('Record not found', 200)->header('Content-Type', 'text/plain');
        }

        $result = $user->deleteUser($id);

        if ($result) {
             return response('Successfully deleted user!', 200)->header('Content-Type', 'text/plain');
        } else {
             return response('Failed to delete user!', 200)->header('Content-Type', 'text/plain');
        }

    }
    /**
     * upload excel the given user.
     *
     * @param  request
     * @return Response
     */
    public function uploadfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
                        'file' => 'required|max:5000|mimes:xlsx,xls'
                    ]);
        $validationFailed = $validator->fails();
        $validationErrors = $validator->errors()->all();

        if ($validationFailed) {
            $this->output($request, false, $validationErrors, 200, 'Failed to upload');
            exit;
        }
        $result = User::importExcel($request);

    }

}
