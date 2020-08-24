<?php

namespace App\Http\Controllers;

use App\UserInfo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class userinfoscontroller extends Controller
{
    public function index()
    {
        $user_infos = UserInfo::all();
        return view('userinfos', ['user_infos' => $user_infos]);
        // uhh main page
    }
    public function get_data()
    {
        return DataTables::eloquent(UserInfo::query())->make(true);
        // json page of pgsql
    }
    public function personalinput(Request $request)
    {
        // validate fields
        $validator = Validator::make($request->all(), [
            'name' => 'alpha|max:255',
            'surname' => 'alpha|max:255',
            'address' => 'required|max:255',
            'age' => 'required|numeric|min:1|max:100',
            'salary' => 'required|numeric|min:1|max:1000000',
        ]);
        // validation failed
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }
        // passed creates new userinfo
        $createUserInfo = new UserInfo();
        $createUserInfo->name = $request->name;
        $createUserInfo->surname = $request->surname;
        $createUserInfo->address = $request->address;
        $createUserInfo->age = $request->age;
        $createUserInfo->salary = $request->salary;
        $createUserInfo->save();
        return response()->json($createUserInfo, 200);
    }
    public function edit(Request $request, $link_id)
    {
        // validation fields
        $validator = Validator::make($request->all(), [
            'name' => 'alpha|max:255',
            'surname' => 'alpha|max:255',
            'address' => 'required|max:255',
            'age' => 'required|numeric|min:1|max:100',
            'salary' => 'required|numeric|min:1|max:1000000',
        ]);
        // failed validation
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }
        // locates using pkey and replace info
        $user_infos = UserInfo::find($link_id);
        $user_infos->name = $request->name;
        $user_infos->surname = $request->surname;
        $user_infos->address = $request->address;
        $user_infos->age = $request->age;
        $user_infos->salary = $request->salary;
        $user_infos->save();
        return response()->json($user_infos, 200);
    }
    public function delete($link_id)
    {
        $deluserinfos = UserInfo::destroy($link_id);
        return response()->json($deluserinfos, 200);
    }
}
