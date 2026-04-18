<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
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
        .success-container {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            margin: 30px 0;
        }
        .success-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        .order-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
        }
        .payment-info {
            background-color: #e7f5ff;
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
        .amount {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-label {
            font-weight: 600;
            color: #666;
        }
        .detail-value {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Gifts Hub</div>
            <h2>Payment Successful!</h2>
        </div>

        <div class="success-container">
            <div class="success-icon">&#10004;</div>
            <h3>Your payment has been completed successfully</h3>
            <p>Thank you for your purchase! Your order has been confirmed.</p>
        </div>

        @if(isset($order))
        <div class="order-details">
            <h4>Order Details</h4>
            <div class="detail-row">
                <span class="detail-label">Order ID:</span>
                <span class="detail-value">{{ $order->order_id ?? 'N/A' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Order Date:</span>
                <span class="detail-value">{{ $order->created_at->format('M d, Y H:i') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status:</span>
                <span class="detail-value">{{ ucfirst($order->status) }}</span>
            </div>
            @if(isset($order->total))
            <div class="detail-row">
                <span class="detail-label">Total Amount:</span>
                <span class="detail-value amount">Rs. {{ number_format($order->total, 2) }}</span>
            </div>
            @endif
        </div>
        @endif

        @if(isset($payment))
        <div class="payment-info">
            <h4>Payment Information</h4>
            <div class="detail-row">
                <span class="detail-label">Transaction ID:</span>
                <span class="detail-value">{{ $payment->transaction_id ?? 'N/A' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Payment Method:</span>
                <span class="detail-value">{{ ucfirst($payment->payment_method ?? 'N/A') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Payment Status:</span>
                <span class="detail-value" style="color: #28a745; font-weight: bold;">{{ ucfirst($payment->status ?? 'Completed') }}</span>
            </div>
            @if(isset($payment->amount))
            <div class="detail-row">
                <span class="detail-label">Amount Paid:</span>
                <span class="detail-value amount">Rs. {{ number_format($payment->amount / 100, 2) }}</span>
            </div>
            @endif
            <div class="detail-row">
                <span class="detail-label">Payment Date:</span>
                <span class="detail-value">{{ $payment->completed_at->format('M d, Y H:i') }}</span>
            </div>
        </div>
        @endif

        <div style="text-align: center; margin: 30px 0;">
            <h4>What's Next?</h4>
            <p>Your order is now being processed. You will receive updates as your order progresses.</p>
            <a href="{{ url('/') }}" class="btn">Continue Shopping</a>
            <a href="{{ url('/user/orders') }}" class="btn" style="background-color: #6c757d;">View My Orders</a>
        </div>

        <div style="background-color: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; border-radius: 6px; margin: 20px 0;">
            <strong>&#128221; Important:</strong>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Please keep this email for your records</li>
                <li>Your order confirmation will be sent separately</li>
                <li>If you have any questions, feel free to contact our support team</li>
            </ul>
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
