<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // عرض صفحة تسجيل الدخول
    public function showLoginForm()
    {
        return view('login/login');
    }

    // معالجة بيانات تسجيل الدخول
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                // استخدم الرابط المباشر لضمان عدم حدوث تداخل
                return redirect()->intended('/employees'); 
            }

            return redirect()->route('employees.dashboard');
        }

        return back()->with('error', 'بيانات الدخول غير صحيحة');
    }

    // تسجيل الخروج
    public function logout(Request $request)
    {
        // تسجيل الخروج من النظام
        Auth::logout();

        // إبطال الجلسة الحالية وتجديد التوكن للأمان
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // التوجيه إلى الصفحة العامة (المسار الرئيسي)
        return redirect('/')->with('success', 'تم تسجيل الخروج بنجاح. نراك قريباً!');
    }
}