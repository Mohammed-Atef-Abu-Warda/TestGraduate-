<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * عرض قائمة الموظفين (مع تقسيم الصفحات)
     */
    public function index()
    {
        // جلب أحدث الموظفين وعرض 5 في كل صفحة
        $employees = Employee::latest()->paginate(5);
        return view('employees.index', compact('employees'));
    }

    /**
     * عرض فورم إضافة موظف جديد
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * حفظ بيانات الموظف الجديد في قاعدة البيانات
     */
    public function store(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'position' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
        ]);

        // إنشاء الموظف
        Employee::create($request->all());

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('employees.index')
                         ->with('success', 'تمت إضافة الموظف بنجاح!');
    }

    /**
     * عرض فورم تعديل بيانات موظف موجود
     */
    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    /**
     * تحديث بيانات الموظف في قاعدة البيانات
     */
    public function update(Request $request, Employee $employee)
    {
        // التحقق من صحة البيانات (مع استثناء الإيميل الحالي للموظف من شرط الـ unique)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'position' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
        ]);

        // تحديث البيانات
        $employee->update($request->all());

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('employees.index')
                         ->with('success', 'تم تحديث بيانات الموظف بنجاح!');
    }

    /**
     * حذف الموظف من قاعدة البيانات
     */
    public function destroy(Employee $employee)
    {
        // تنفيذ الحذف
        $employee->delete();

        // إعادة التوجيه مع رسالة تفيد بالحذف
        return redirect()->route('employees.index')
                         ->with('error', 'تم حذف بيانات الموظف بنجاح!');
    }
}
