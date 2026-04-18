<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay with Khalti</title>
    <!-- Use basic Bootstrap 5 CSS for quick styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .khalti-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 40px;
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .khalti-btn {
            background-color: #5C2D91;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .khalti-btn:hover {
            background-color: #4B2475;
        }
        .khalti-logo {
            width: 150px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="khalti-card">
        <!-- Khalti Logo placeholder image -->
        <img src="https://khalti.com/static/images/khalti-logo.svg" alt="Khalti Logo" class="khalti-logo">
        
        <h4 class="mb-4">Complete your payment</h4>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('payment.initiate') }}" method="POST">
            @csrf
            
            <div class="mb-3 text-start">
                <label for="amount" class="form-label">Amount (Paisa)</label>
                <input type="number" class="form-control" name="amount" id="amount" value="1000" required>
                <div class="form-text">Note: 1000 Paisa = Rs 10</div>
            </div>

            <button type="submit" class="khalti-btn">Pay with Khalti</button>
        </form>
    </div>

</body>
</html>