<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // دریافت داده‌های فرم
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // اعتبارسنجی داده‌های فرم
    if (empty($name) OR empty($subject) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // ارسال پیام خطا
        http_response_code(400);
        echo "خطا: تمام فیلدها باید پر شوند.";
        exit;
    }

    // تعیین گیرنده ایمیل
    $recipient = "rajaiyan@ee.sharif.edu";

    // ساختن عنوان ایمیل
    $email_subject = "New contact from $name: $subject";

    // ساختن محتوای ایمیل
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // تنظیم هدرهای ایمیل
    $email_headers = "From: $name <$email>";

    // ارسال ایمیل
    if (mail($recipient, $email_subject, $email_content, $email_headers)) {
        // ارسال پیام موفقیت
        http_response_code(200);
        echo "پیام شما با موفقیت ارسال شد.";
    } else {
        // ارسال پیام خطا
        http_response_code(500);
        echo "خطا: پیام شما ارسال نشد.";
    }
} else {
    http_response_code(403);
    echo "خطا: درخواست معتبر نمی‌باشد.";
}
?>
