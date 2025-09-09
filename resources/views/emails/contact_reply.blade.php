<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Phản hồi liên hệ</title>
</head>
<body style="font-family: Arial, sans-serif; background-color:#f3f4f6; color:#333; padding:20px;">
  <div style="max-width:600px; margin:0 auto; background:#fff; border-radius:8px; overflow:hidden;">
    <!-- Header -->
    <div style="background:#2563eb; color:#fff; text-align:center; padding:16px;">
      <h1 style="margin:0; font-size:20px;">Công ty ABC</h1>
      <p style="margin:0; font-size:14px;">Cảm ơn bạn đã liên hệ với chúng tôi!</p>
    </div>

    <!-- Nội dung -->
    <div style="padding:20px;">
      <p style="font-size:16px; font-weight:bold; text-align:center;">Xin chào {{ $contact->ho_ten }},</p>
      <p style="text-align:center;">Chúng tôi đã nhận được câu hỏi của bạn và xin gửi phản hồi như sau:</p>

      <div style="background:#f9fafb; border-left:4px solid #9ca3af; padding:12px; margin:16px 0;">
        <p style="margin:0; font-weight:bold;">Câu hỏi của bạn:</p>
        <div>{!! nl2br(e($contact->noi_dung)) !!}</div>
      </div>

      <div style="background:#eff6ff; border-left:4px solid #2563eb; padding:12px; margin:16px 0;">
        <p style="margin:0; font-weight:bold;">Phản hồi của chúng tôi:</p>
        <div>{!! nl2br(e($replyContent)) !!}</div>
      </div>

      <p style="margin:0; text-align:center;">Trân trọng,</p>
      <p style="margin:0; text-align:center; font-weight:bold;">Đội ngũ hỗ trợ</p>
    </div>

    <!-- Footer -->
    <div style="background:#f9fafb; text-align:center; font-size:12px; color:#555; padding:12px;">
      <p>Liên hệ: <a href="mailto:support@abc.com" style="color:#2563eb;">support@abc.com</a> |
         <a href="https://abc.com" style="color:#2563eb;">abc.com</a></p>
      <p>© 2025 Công ty ABC. Mọi quyền được bảo lưu.</p>
    </div>
  </div>
</body>
</html>
