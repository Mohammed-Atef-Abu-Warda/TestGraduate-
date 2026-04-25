<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>Employees System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            margin: 0;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }

        .card {
            background: #fff;
            padding: 20px;
            margin-top: 20px;
            border-radius: 10px;
        }

        .btn {
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
            color: #fff;
        }

        .btn-primary { background: #3490dc; }
        .btn-success { background: #38c172; }
        .btn-danger { background: #e3342f; }

        input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>نظام الموظفين</h2>
    @auth
        <nav style="background: #f8f9fa; padding: 10px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ddd;">
            <div>
                 مرحباً بك، {{ Auth::user()->name }}
            </div>

            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn btn-danger" style="background: #dc3545; color: white; border: none; padding: 5px 15px; border-radius: 5px; cursor: pointer;">
                    تسجيل الخروج
                </button>
            </form>
        </nav>
    @endauth
    @yield('content')
</div>

</body>
</html>