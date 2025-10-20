<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Mật Khẩu - S-MIS</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }

        .content {
            padding: 30px;
        }

        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }

        .message {
            margin-bottom: 25px;
            color: #555;
        }

        .password-box {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }

        .password-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .password-value {
            font-size: 28px;
            font-weight: bold;
            color: #667eea;
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
            word-break: break-all;
        }

        .warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .warning-icon {
            color: #ff9800;
            font-weight: bold;
            margin-right: 8px;
        }

        .instructions {
            margin: 20px 0;
            padding: 15px;
            background-color: #e7f3ff;
            border-radius: 4px;
        }

        .instructions ol {
            margin: 10px 0;
            padding-left: 20px;
        }

        .instructions li {
            margin: 8px 0;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
            border-top: 1px solid #e9ecef;
        }

        .footer a {
            color: #667eea;
            text-decoration: none;
        }

        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
            font-weight: 600;
        }

        .contact-info {
            margin-top: 20px;
            font-size: 13px;
            color: #999;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>🔐 Reset Mật Khẩu Thành Công</h1>
        </div>

        <div class="content">
            <div class="greeting">
                Xin chào <strong>{{ $userName }}</strong>,
            </div>

            <div class="message">
                Mật khẩu tài khoản của bạn vừa được reset bởi quản trị viên hệ thống <strong>S-MIS</strong>.
            </div>

            <div class="password-box">
                <div class="password-label">Mật khẩu mới của bạn:</div>
                <div class="password-value">{{ $newPassword }}</div>
            </div>

            <div class="warning">
                <span class="warning-icon">⚠️</span>
                <strong>Lưu ý quan trọng:</strong> Vui lòng đổi mật khẩu này ngay sau khi đăng nhập lần đầu để đảm bảo
                an toàn tài khoản.
            </div>

            <div class="instructions">
                <strong>Hướng dẫn đăng nhập:</strong>
                <ol>
                    <li>Truy cập: <a href="{{ $loginUrl }}">{{ $loginUrl }}</a></li>
                    <li>Nhập email: <strong>{{ $userEmail }}</strong></li>
                    <li>Nhập mật khẩu mới ở trên</li>
                    <li>Click "Đăng nhập"</li>
                    <li>Vào <strong>Tài khoản</strong> → <strong>Đổi mật khẩu</strong> để thay đổi</li>
                </ol>
            </div>

            <div style="text-align: center;">
                <a href="{{ $loginUrl }}" class="button">Đăng Nhập Ngay</a>
            </div>

            <div class="message" style="margin-top: 30px;">
                Nếu bạn không yêu cầu reset mật khẩu, vui lòng liên hệ ngay với quản trị viên để bảo vệ tài khoản của
                bạn.
            </div>
        </div>

        <div class="footer">
            <p>
                <strong>S-MIS - Student Management Information System</strong><br>
                Hệ thống Quản lý Sinh viên
            </p>
            <div class="contact-info">
                Email: <a href="mailto:support@smis.edu.vn">support@smis.edu.vn</a><br>
                Hotline: 0123 456 789<br>
                Website: <a href="http://smis.edu.vn">smis.edu.vn</a>
            </div>
            <p style="margin-top: 15px; font-size: 12px; color: #999;">
                © {{ date('Y') }} S-MIS. All rights reserved.<br>
                Email này được gửi tự động, vui lòng không reply.
            </p>
        </div>
    </div>
</body>

</html>
