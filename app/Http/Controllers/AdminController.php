<?php

        namespace App\Http\Controllers;

        use Illuminate\Http\Request;
        use Illuminate\Support\Facades\Auth;

        class AdminController extends Controller
        {
            public function showLoginForm()
            {
                return view('admin.login');
            }

            public function login(Request $request)
            {
                $credentials = $request->validate([
                    'email' => ['required', 'email'],
                    'password' => ['required'],
                ]);

                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();
                    return redirect()->intended('/admin/dashboard');
                }

                return back()->withErrors([
                    'email' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
                ])->onlyInput('email');
            }

            public function logout(Request $request)
            {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/');
            }

            public function dashboard()
            {
                return view('admin.dashboard');
            }
        }
        