<x-mail::message>
# Xác thực tài khoản

Cảm ơn quý khách đã sử dụng dịch vụ của chúng tôi! Để hoàn tất quá trình đăng ký và kích hoạt tài khoản của quý khách, vui lòng xác thực địa chỉ email bằng cách nhấp vào nút bên dưới

<x-mail::button :url="'http://localhost:8000/api/auth/active/'.$token">
    Xác thực tài khoản
</x-mail::button>


Nếu quý khách không thực hiện yêu cầu này, vui lòng bỏ qua email này. 

Trân trọng,<br>
{{ config('app.name') }}
</x-mail::message>
{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
    <div>
        <h2>Email Verification</h2>
        <p>Vui lòng kiểm tra email của bạn và nhấp vào liên kết để xác nhận địa chỉ email của bạn.</p>
        <form method="POST" action="{{ $activeLink }}">
            @csrf
            <button type="submit">Gửi lại email xác nhận</button>
        </form>
    </div>
</body>
</html> --}}