<?php

namespace App\Http\Controllers\dgaAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Authorization;

class LoginController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('dgaAdmin.login', compact('setting'));
    }

    public function submitLog(Request $request)
    {
        $w = '2fa';
        $f = '2fa_secret';
        if ($request->oauth == 'ON') {
            
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|min:0',
                'password' => 'required|string|min:0',
                'code' => 'required|string|min:0',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            }
            $user = User::where('username', $request->username)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    if ($user->$w == true) {
                        $oauth = new TwoAuthController();
                        $result = $oauth->verifyCode($user->$f, $request->code, 2);
                        if ($result) {
                            Auth::login($user);
                            Authorization::autho(['username' => $request->username, 'password' => $request->password, 'role' => 'admin']);
                            return response()->json(['status' => 'success', 'message' => 'Login Success']);
                        } else {
                            return response()->json(['status' => 'error', 'message' => 'Invalid Code']);
                        }
                    } else {
                        Auth::login($user);
                        Authorization::autho(['username' => $request->username, 'password' => $request->password, 'role' => 'admin']);
                        return response()->json(['status' => 'success', 'message' => 'Đăng nhập thành công']);
                    }
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Sai mật khẩu']);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => 'Tài khoản không tồn tại']);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|min:0',
                'password' => 'required|string|min:0',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            }
            $user = User::where('username', $request->username)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    if ($user->$w == true) {
                        return response()->json(['status' => 'success', 'message' => 'Nhập mã xác thực 2fa', 'oauth' => true]);
                    } else {
                        Auth::login($user);
                        Authorization::autho(['username' => $request->username, 'password' => $request->password, 'role' => 'admin']);
                        return response()->json(['status' => 'success', 'message' => 'Đăng nhập thành công']);
                    }
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Sai mật khẩu']);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => 'Tài khoản không tồn tại']);
            }
            /* if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'role' => 'admin'])) {
            return redirect()->route('admin.home');
        } else {
            return redirect()->back()->withErrors('Bạn tu thêm mấy kiếp nữa đi rồi hãy hack web :))');
        } */
        }
    }
}
