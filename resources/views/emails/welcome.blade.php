<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to MediPOS</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #0b1120;
            color: #ffffff;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #1e293b;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .header {
            padding: 40px 30px;
            text-align: center;
            background-color: #0f172a;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .brand-icon {
            display: inline-block;
            background: linear-gradient(135deg, #0ea5e9, #6366f1);
            width: 50px;
            height: 50px;
            border-radius: 12px;
            line-height: 50px;
            font-size: 24px;
            color: #ffffff;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .header h1 span {
            color: #60a5fa;
        }
        .content {
            padding: 40px 30px;
        }
        .content h2 {
            margin-top: 0;
            font-size: 22px;
            font-weight: 700;
            color: #f8fafc;
        }
        .content p {
            font-size: 16px;
            line-height: 1.6;
            color: #94a3b8;
            margin-bottom: 25px;
        }
        .button-wrapper {
            text-align: center;
            margin: 35px 0;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            color: #ffffff;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        }
        .features {
            background-color: rgba(15, 23, 42, 0.5);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .feature-item {
            margin-bottom: 10px;
            color: #cbd5e1;
            font-size: 15px;
        }
        .feature-item strong {
            color: #f8fafc;
        }
        .footer {
            padding: 25px 30px;
            text-align: center;
            background-color: #0f172a;
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        .footer p {
            margin: 0;
            font-size: 13px;
            color: #64748b;
        }
        .footer a {
            color: #60a5fa;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="email-container">
    
    <div class="header">
        <div class="brand-icon">M</div>
        <h1>Medi<span>POS</span></h1>
    </div>

    <div class="content">
        <h2>Welcome to the Future of Medical Retail, {{ $user->name ?? 'Pharmacist' }}!</h2>
        
        <p>Thank you for joining MediPOS. We're thrilled to have you on board. You've just taken the first step towards transforming how you manage your pharmacy, saving time and maximizing your profits.</p>
        
        <div class="features">
            <div class="feature-item"><strong>📦 Smart Inventory:</strong> Never lose track of your stock or expiry dates again.</div>
            <div class="feature-item"><strong>⚡ Lightning POS:</strong> Process transactions faster than ever before.</div>
            <div class="feature-item"><strong>📊 Real-time Analytics:</strong> Get insights into your best-selling items and daily profits.</div>
        </div>
        
        <p>To get started, simply log in to your dashboard and complete your store setup. It only takes a few minutes to import your inventory.</p>
        
        <div class="button-wrapper">
            <a href="{{ route('login') }}" class="btn">Go to Dashboard</a>
        </div>
        
        <p>If you have any questions or need a demo, our 24/7 support team is always here for you. Just reply to this email or reach us on WhatsApp!</p>
        
        <p style="margin-bottom:0;">Best regards,<br><strong style="color:#f8fafc;">The MediPOS Team</strong></p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} MediPOS. All rights reserved.</p>
        <p style="margin-top:8px;">
            <a href="mailto:mutechstudio1@gmail.com">mutechstudio1@gmail.com</a> | 
            <a href="https://wa.me/923086452242">+92 308 645 2242</a>
        </p>
    </div>

</div>

</body>
</html>
