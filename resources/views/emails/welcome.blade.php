<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chào mừng đến với {{ config('app.name') }}</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            margin: 0;
        }
        .email-container {
            background-color: #ffffff;
            max-width: 600px;
            margin: auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .email-header {
            text-align: center;
            padding-bottom: 20px;
        }
        .email-header h1 {
            color: #2e6edc;
            font-size: 28px;
        }
        .email-body {
            color: #333;
            line-height: 1.6;
        }
        .email-footer {
            margin-top: 30px;
            font-size: 13px;
            color: #999;
            text-align: center;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            background-color: #2e6edc;
            color: #fff;
            padding: 12px 24px;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Chào mừng {{ $user->name }}!</h1>
        </div>
        <div class="email-body">
            <p>Cảm ơn bạn đã đăng ký tài khoản tại <strong>{{ config('app.name') }}</strong>.</p>

            <p>Dưới đây là thông tin tài khoản của bạn:</p>
            <ul>
                <li><strong>Họ và tên:</strong> {{ $user->name }}</li>
                <li><strong>Email:</strong> {{ $user->email }}</li>
            </ul>

            <p>Hãy bắt đầu khám phá và tận hưởng những tính năng tuyệt vời mà chúng tôi cung cấp.</p>

            <a href="{{ url('/') }}" class="btn">Truy cập Website</a>
        </div>
        <div class="email-footer">
            © {{ date('Y') }} {{ config('app.name') }}. Mọi quyền được bảo lưu.<br>
            Địa chỉ: 123 Đường ABC, Quận XYZ, TP. HCM
        </div>
    </div>
</body>
</html>
