<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
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
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e9ecef;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }
        .otp-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            margin: 30px 0;
        }
        .otp-code {
            font-size: 36px;
            font-weight: bold;
            letter-spacing: 8px;
            background: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 8px;
            display: inline-block;
            margin: 20px 0;
            font-family: 'Courier New', monospace;
        }
        .instructions {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #007bff;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 14px;
        }
        .security-note {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Gifts Hub</div>
            <h2>Email Verification</h2>
        </div>

        <div class="otp-container">
            <h3>Your Verification Code</h3>
            <div class="otp-code">{{ $otp }}</div>
            <p>This code will expire in 5 minutes</p>
        </div>

        <div class="instructions">
            <h4>How to use this code:</h4>
            <ol>
                <li>Return to the Gifts Hub website</li>
                <li>Enter this 6-digit code in the verification form</li>
                <li>Click "Verify OTP" to complete the process</li>
            </ol>
        </div>

        <div class="security-note">
            <strong>🔒 Security Notice:</strong>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Never share this code with anyone</li>
                <li>Our team will never ask for your OTP</li>
                <li>This code can only be used once</li>
                <li>If you didn't request this code, please ignore this email</li>
            </ul>
        </div>

        <div style="text-align: center; margin: 20px 0;">
            <p>Having trouble? <a href="#" style="color: #007bff;">Contact Support</a></p>
        </div>

        <div class="footer">
            <p>This is an automated message from Gifts Hub.</p>
            <p>© {{ date('Y') }} Gifts Hub. All rights reserved.</p>
            <p style="font-size: 12px; color: #999;">
                If you received this email by mistake, please delete it immediately.
            </p>
        </div>
    </div>
</body>
</html>
