<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private $model = new User()
    )
    {

    }    

    final public function showSettings(Request $request)
    {
        $save = $request->input('submit');

        // dd($request->all());

        $user_id = $request->user()->id;
        if($save) {
            $params['id'] = $user_id;
            $params['x'] = $request->input('x');
            $params['y'] = $request->input('y');

            $this->model->updateUser($params);
            return redirect('/settings')->with(['success' => __('Lokalizacja zmieniona pomyślnie')]);
        }
        
        $user = $this->model->getUser($user_id);       
        $params['x'] = $user->X;
        $params['y'] = $user->Y;

        return view("location", ['p' => $params]);
    }
}
