<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'address' => 'required',
            'birthday' => 'required|date',
            'role' => 'required',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ]);
        }

        $data = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'address' => $request->get('address'),
            'birthday' => $request->get('birthday'),
            'role' => $request->get('role'),
            'password' => Hash::make($request->get('password')),
        ];

        try {
            User::create($data);

            return response()->json([
                "status" => true,
                "message" => "Data berhasil ditambahkan",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                'message' => $e,
            ]);
        }
    }

    public function getUser()
    {
        try {
            $user = User::get();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil load data user',
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal load data user: ' . $e,
            ]);
        }
    }

    public function getDetailUser($id)
    {
        try {
            $user = User::where('id', $id)->first();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data user tidak ditemukan.',
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Berhasil load data detail user',
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal load data detail user: ' . $e,
            ]);
        }
    }

    public function updateUser($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
            'address' => 'required',
            'birthday' => 'required|date',
            'role' => 'required',
            'password' => 'nullable|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ]);
        }

        $data = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'role' => $request->get('role'),
            'address' => $request->get('address'),
            'birthday' => $request->get('birthday'),
        ];

        try {
            $update = User::where('id', $id)->update($data);
            if ($update) {
                return response()->json([
                    "status" => true,
                    'message' => 'Data berhasil diupdate',
                ]);
            }

            return response()->json([
                "status" => false,
                'message' => 'Data gagal diupdate.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                'message' => $e,
            ]);
        }
    }
    public function hapus_user($id) {
        try{
            User::where('id',$id)->delete();
            return Response()->json([
                "status"=>true,
                'message'=>'Data berhasil dihapus'
            ]);
        } catch(\Exception $e){
            return Response()->json([
                "status"=>false,
                'message'=>'gagal hapus user. '.$e,
            ]);
        }
    }
    }
