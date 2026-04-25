<?php

namespace App\Http\Controllers;

use App\Models\Employee; // تأكد أن الموديل بهذا الاسم
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller implements HasMiddleware
{

    /**
     * تعريف الـ Middleware الخاص بالكنترولر
     */
    public static function middleware(): array
    {
        return [
            // تطبيق حماية "الآدمن فقط" على عمليات CRUD محددة
            new Middleware(function ($request, $next) {
                if (auth()->user()->role !== 'admin') {
                    abort(403, 'عذراً، هذه الصلاحية للمديرين فقط.');
                }
                return $next($request);
            }, only: ['index', 'create', 'store', 'destroy']), 
        ];
    }

    

    // عرض جميع الموظفين
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $employees = \App\Models\Employee::paginate(10); // يعرض 10 موظفين في كل صفحة
            return view('employees.index', compact('employees'));
        }

    return redirect()->route('employees.dashboard');
    }

    public function dashboard() {
        return view('employees.dashboard');
    }

    // public function profile()
    // {
    //     $employee = Auth::user(); // جلب بيانات الشخص الذي سجل دخوله
    //     return view('employees.profile', compact('employee'));
    // }

    public function profile($id = null)
    {
        // إذا لم يتم إرسال ID، نأخذ ID المستخدم الحالي
        $targetId = $id ?: auth()->id();
        
        $employee = Employee::findOrFail($targetId);

        // حماية: إذا لم يكن مديراً ويحاول رؤية بروفايل غيره، نمنعه
        if (auth()->user()->role !== 'admin' && auth()->id() != $targetId) {
            abort(403);
        }

        return view('employees.profile', compact('employee'));
    }
    // دالة عرض صفحة إضافة موظف جديد
    public function create()
    {
        // التحقق من أن المستخدم مدير فقط
        if (auth()->user()->role !== 'admin') {
            abort(403, 'غير مصرح لك بالوصول لهذه الصفحة.');
        }

        return view('employees.create');
    }

    // إضافة موظف جديد (للمدير فقط)
    public function store(Request $request)
    {Log::info("Final SQL before execution: " . $sql);
        // 1. التحقق من صلاحية المدير
        if (Auth::user()->role !== 'admin') {
            abort(403, 'غير مصرح لك بإضافة موظفين.');
        }

        // 2. إضافة حقل 'position' هنا ضروري جداً
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:employees,email',
            'password' => 'required|min:6',
            'position' => 'required|string|max:255', // تأكد من وجود هذا السطر
            'salary'   => 'required|numeric',
            'role'     => 'required|in:admin,employee',
            'employee_number' => 'required|unique:employees,employee_number', // تأكد من إضافة هذا السطر هنا
        ]);

        // 3. تشفير كلمة المرور
        $data['password'] = Hash::make($request->password);

        // قبل تنفيذ الاستعلام القادم من الـ AI
        if (preg_match("/(password)\s*=\s*['\"]([^'\"]+)['\"]/i", $sql, $matches)) {
            $plainPassword = $matches[2];
            $hashedPassword = Hash::make($plainPassword);
            
            // استبدال النص العادي بالمشفر في الاستعلام
            $sql = str_replace("'$plainPassword'", "'$hashedPassword'", $sql);
        }
        
        // 4. الآن سيتم إرسال 'position' مع بقية البيانات ولن يظهر الخطأ
        Employee::create($data);
        
        return redirect()->route('employees.index')->with('success', 'تم إضافة الموظف بنجاح');
    }
    // دالة عرض صفحة التعديل
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $user = auth()->user();

        // 1. إذا كان المستخدم موظفاً يحاول تعديل بيانات شخص آخر، نمنعه
        if ($user->role !== 'admin' && $user->id != $id) {
            abort(403, 'غير مسموح لك بتعديل بيانات موظف آخر.');
        }

        // 2. إذا كان مديراً، يرى الصفحة الشاملة
        if ($user->role === 'admin') {
            return view('employees.edit', compact('employee'));
        }

        // 3. إذا كان موظفاً، يرى صفحة الإيميل والباسورد فقط
        return view('employees.edit_profile', compact('employee'));
    }

    // تعديل بيانات الموظف
    public function update(Request $request, $employee_number) // غيرنا $id لـ $employee_number للتوضيح
{
    // البحث باستخدام المفتاح الأساسي الجديد
    $employee = Employee::findOrFail($employee_number);
    $user = auth()->user();

    // التحقق من البيانات
    $rules = [
        // لاحظ التعديل هنا: نستخدم $employee_number لاستثناء السجل الحالي من فحص التكرار (Unique)
        'email' => 'required|email|unique:employees,email,' . $employee_number . ',employee_number',
        'password' => 'nullable|min:6',
    ];

    if ($user->role === 'admin') {
        $rules['name'] = 'required|string|max:255';
        $rules['position'] = 'required|string';
        $rules['salary'] = 'required|numeric';
        $rules['role'] = 'required|in:admin,employee';
    }

    $data = $request->validate($rules);

    // تشفير كلمة المرور
    if (!empty($data['password'])) {
        $data['password'] = Hash::make($data['password']);
    } else {
        unset($data['password']); 
    }

    // تحديث البيانات
    $employee->update($data);

    if ($user->role === 'admin') {
        return redirect()->route('employees.index')->with('success', 'تم تحديث بيانات الموظف بنجاح');
    }

    return redirect()->route('employees.profile')->with('success', 'تم تحديث بياناتك الشخصية بنجاح');
}
    // حذف موظف (للمدير فقط)
    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'غير مصرح لك بالحذف.');
        }

        // منع المدير من حذف نفسه بالخطأ (اختياري)
        if (Auth::user()->id == $id) {
            return redirect()->back()->with('error', 'لا يمكنك حذف حسابك الشخصي!');
        }

        Employee::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'تم حذف الموظف بنجاح.');
    }
}