<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Code</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f5f7; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f4f5f7; padding: 40px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="480" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden;">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #0f1b35, #1b2a4a); padding: 30px 40px; text-align: center;">
                            <h1 style="margin: 0; color: #d4a017; font-size: 20px; font-weight: 700; letter-spacing: 1px;">
                                Clinic Monitoring System
                            </h1>
                            <p style="margin: 6px 0 0; color: #a0b0cc; font-size: 13px;">
                                Merchant Marine Academy of Caraga, Inc.
                            </p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 36px 40px;">
                            <p style="margin: 0 0 16px; color: #333; font-size: 15px;">
                                Hello <strong>{{ $name }}</strong>,
                            </p>
                            <p style="margin: 0 0 24px; color: #555; font-size: 14px; line-height: 1.6;">
                                Use the following verification code to complete your login. This code will expire in <strong>10 minutes</strong>.
                            </p>

                            <!-- OTP Code -->
                            <div style="text-align: center; margin: 28px 0;">
                                <div style="display: inline-block; background: #f0f4fa; border: 2px dashed #1b2a4a; border-radius: 10px; padding: 18px 36px; letter-spacing: 12px; font-size: 36px; font-weight: 800; color: #0f1b35;">
                                    {{ $code }}
                                </div>
                            </div>

                            <p style="margin: 24px 0 0; color: #888; font-size: 13px; line-height: 1.5;">
                                If you did not attempt to log in, please ignore this email or contact the system administrator immediately.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8f9fb; padding: 20px 40px; text-align: center; border-top: 1px solid #eee;">
                            <p style="margin: 0; color: #aaa; font-size: 12px;">
                                &copy; {{ date('Y') }} MMACI Clinic Monitoring System. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
