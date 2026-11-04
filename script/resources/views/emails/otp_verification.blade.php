<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $appName ?? 'ChowChak' }} - Verification Code</title>
    <style>
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                margin: 0 !important;
                border-radius: 0 !important;
            }
            .content-padding {
                padding: 24px 20px !important;
            }
            .otp-code {
                font-size: 32px !important;
                letter-spacing: 8px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased;">
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f1f5f9; padding: 40px 10px;">
        <tr>
            <td align="center">
                
                <!-- Main Card Container -->
                <table role="presentation" class="email-container" width="540" border="0" cellspacing="0" cellpadding="0" style="width: 540px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06); border: 1px solid #e2e8f0;">
                    
                    <!-- Top Accent Gradient Line (Figma Forest Green 4-Color Palette) -->
                    <tr>
                        <td height="6" style="background: linear-gradient(90deg, #253D2C 0%, #2E6F40 50%, #68BA7F 100%); line-height: 6px; font-size: 6px;">&nbsp;</td>
                    </tr>

                    <!-- Header with Logo / Brand -->
                    <tr>
                        <td align="center" style="padding: 32px 30px 16px 30px;">
                            <table role="presentation" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center">
                                        <div style="display: inline-block; background: #CFFFDC; border: 1.5px solid #68BA7F; border-radius: 12px; padding: 8px 18px;">
                                            <span style="font-size: 22px; font-weight: 800; letter-spacing: -0.5px; vertical-align: middle;">🌿 <span style="color: #2E6F40;">CHOW</span><span style="color: #68BA7F;">CHAK</span></span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Main Body Content -->
                    <tr>
                        <td class="content-padding" style="padding: 10px 40px 30px 40px; text-align: center;">
                            
                            <!-- Hero Icon Badge -->
                            <div style="margin: 10px auto 18px auto; width: 60px; height: 60px; background-color: #CFFFDC; border-radius: 50%; border: 2px solid #68BA7F; text-align: center; line-height: 60px;">
                                <span style="font-size: 28px; line-height: 60px;">🔐</span>
                            </div>

                            <h1 style="margin: 0 0 10px 0; font-size: 24px; font-weight: 700; color: #0f172a; letter-spacing: -0.5px;">
                                @if(($type ?? '') === 'customer_verify' || ($type ?? '') === 'email_verify')
                                    Verify Your Email Address
                                @else
                                    Login Verification Code
                                @endif
                            </h1>
                            
                            <p style="margin: 0 0 24px 0; font-size: 15px; line-height: 24px; color: #475569;">
                                Hello <strong style="color: #0f172a;">{{ $name ?? 'there' }}</strong>,<br>
                                @if(($type ?? '') === 'customer_verify' || ($type ?? '') === 'email_verify')
                                    Thank you for signing up with {{ $appName ?? 'ChowChak' }}! Please use the verification code below to verify your email address.
                                @else
                                    You have requested to login to your account. Please use the one-time verification code below to complete your sign-in.
                                @endif
                            </p>

                            <!-- Modern OTP Box -->
                            <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto 24px auto;">
                                <tr>
                                    <td align="center">
                                        <div style="background-color: #CFFFDC; border: 2px dashed #68BA7F; border-radius: 14px; padding: 20px 24px; display: inline-block; min-width: 280px; box-sizing: border-box;">
                                            <div class="otp-code" style="font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, monospace; font-size: 38px; font-weight: 800; letter-spacing: 12px; color: #253D2C; margin-left: 12px; text-align: center;">
                                                {{ $otp }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- Expiry Badge -->
                            <div style="display: inline-block; background-color: #CFFFDC; border: 1.5px solid #68BA7F; border-radius: 20px; padding: 6px 16px; margin-bottom: 24px;">
                                <span style="font-size: 13px; font-weight: 700; color: #253D2C;">
                                    ⏱️ Valid for {{ $expireMinutes ?? 10 }} minutes only
                                </span>
                            </div>

                            <!-- Security Warning Card -->
                            <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 14px 16px; text-align: left;">
                                        <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="100%">
                                            <tr>
                                                <td width="24" valign="top" style="font-size: 16px; padding-right: 10px;">🔒</td>
                                                <td style="font-size: 13px; line-height: 19px; color: #64748b;">
                                                    <strong style="color: #334155;">Security Notice:</strong> Never share this code with anyone. Our team will never ask you for your verification code.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0; font-size: 13px; line-height: 20px; color: #94a3b8;">
                                If you did not request this verification code, please ignore this email. No changes will be made to your account.
                            </p>

                        </td>
                    </tr>

                    <!-- Subtle Divider -->
                    <tr>
                        <td style="padding: 0 40px;">
                            <hr style="border: 0; border-top: 1px solid #edf2f7; margin: 0;">
                        </td>
                    </tr>

                    <!-- Modern Footer -->
                    <tr>
                        <td style="padding: 24px 30px; text-align: center; background-color: #ffffff;">
                            <p style="margin: 0 0 6px 0; font-size: 12px; color: #94a3b8;">
                                Sent by <strong style="color: #64748b;">{{ $appName ?? 'ChowChak' }}</strong> • Automated Notification
                            </p>
                            <p style="margin: 0; font-size: 11px; color: #cbd5e1;">
                                Please do not reply directly to this email. Replies to this address are automatically discarded.
                            </p>
                            <p style="margin: 8px 0 0 0; font-size: 11px; color: #cbd5e1;">
                                &copy; {{ date('Y') }} {{ $appName ?? 'ChowChak' }}. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
                <!-- End Main Card Container -->

            </td>
        </tr>
    </table>
</body>
</html>
