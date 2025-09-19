<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Confirmation</title>
    <style>
        body {
            background-color: #e5f8f2;
            margin: 0;
            padding: 0;
            font-family: 'Lato', Helvetica, Arial, sans-serif;
        }
        .btn {
            font-size: 20px;
            font-family: Helvetica, Arial, sans-serif;
            color: #014122 !important;
            text-decoration: none;
            padding: 15px 25px;
            border-radius: 2px;
            border: 1px solid #014122;
            display: inline-block;
        }
    </style>
</head>
<body>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:40px 0;">
                <h1 style="color:#014122;">Booking Confirmation</h1>
                <img src="{{ asset('assets/media/logos/custom-1.png') }}" width="125" height="120" alt="Logo">
            </td>
        </tr>

        <tr>
            <td align="center" style="padding:20px;">
                <p style="font-size:18px; color:#014122;">
                    Hello {{ $full_name }},
                </p>
                <p style="font-size:16px; color:#014122;">
                    Thank you for your booking! You can view your profile and booking details here:
                </p>
                <p>
                    <a href="{{ $profile_link }}" class="btn">View My Profile</a>
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
