<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Confirmation</title>
</head>
<body style="font-family: 'Arial', sans-serif;">

    <div style="background-color: #f4f4f4; padding: 20px; text-align: center;">

        <h1 style="color: #333;">Email Confirmation</h1>

        <p style="color: #666;">Please click the link below to confirm your email.</p>

        <div style="margin-top: 20px;">
            <a href="{{ config('api.hris_web_ui_url') }}/confirm-email?token={{ $content['token'] }}" style="background-color: #3490dc; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Confirm</a>
        </div>

        <p style="color: #888; margin-top: 20px;">If you have any questions or need assistance, feel free to contact us.</p>

    </div>

</body>
</html>