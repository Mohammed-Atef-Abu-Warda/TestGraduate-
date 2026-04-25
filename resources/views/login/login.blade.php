<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - نظام الموظفين</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            /* تدرج من الأزرق السماوي إلى النيلي */
            background: linear-gradient(135deg, #0ea5e9 0%, #1e1b4b 100%);
        }
    </style>
</head>
<body class="h-screen flex items-center justify-center font-sans p-4">

    <div class="bg-white rounded-2xl shadow-2xl flex flex-col md:flex-row w-full max-w-4xl overflow-hidden">
        
        <div class="hidden md:flex md:w-1/2 bg-slate-50 items-center justify-center p-12 border-l border-gray-100">
            <div class="bg-white rounded-full p-8 shadow-inner border border-gray-50">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="User Icon" class="w-48 h-48 opacity-90">
            </div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-16 flex flex-col justify-center">
            
            <div class="text-center mb-6">
                <h1 class="text-3xl font-black text-indigo-900 mb-2">
                    نظام الموظفين
                </h1>
                <p class="text-gray-400 text-sm font-medium tracking-widest uppercase">Employee Management System</p>
                <div class="h-1.5 w-12 bg-sky-500 mx-auto mt-3 rounded-full"></div>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                <div class="relative">
                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="email" name="email" placeholder="البريد الإلكتروني" 
                        class="w-full pr-10 pl-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-sky-500 focus:border-transparent outline-none transition duration-200 text-right" required>
                </div>

                <div class="relative">
                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" name="password" placeholder="كلمة المرور" 
                        class="w-full pr-10 pl-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-sky-500 focus:border-transparent outline-none transition duration-200 text-right" required>
                </div>

                <button type="submit" 
                    class="w-full bg-[#5cb85c] hover:bg-[#4cae4c] text-white font-bold py-3.5 rounded-xl shadow-lg transition duration-300 transform hover:-translate-y-0.5 active:scale-95 text-lg">
                    دخول للنظام
                </button>

                
            </form>
        </div>
    </div>

</body>
</html>