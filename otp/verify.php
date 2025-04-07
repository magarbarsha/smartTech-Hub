<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OTP Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --accent-color: #2e59d9;
            --text-color: #5a5c69;
            --success-color: #1cc88a;
            --border-radius: 0.5rem;
        }
        
        body {
            background-color: #f5f7ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: radial-gradient(circle at 10% 20%, rgba(78, 115, 223, 0.05) 0%, rgba(78, 115, 223, 0.05) 90%);
        }
        
        .otp-container {
            max-width: 450px;
            width: 100%;
            padding: 2.5rem;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
            animation: fadeInUp 0.5s ease-out;
        }
        
        .otp-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .otp-header h1 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 1.8rem;
        }
        
        .otp-header p {
            color: #6c757d;
            font-size: 0.95rem;
        }
        
        .alert-primary {
            background-color: rgba(78, 115, 223, 0.1);
            border-color: rgba(78, 115, 223, 0.2);
            color: var(--primary-color);
        }
        
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: var(--border-radius);
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
            font-size: 1.1rem;
            letter-spacing: 1px;
            text-align: center;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.15);
        }
        
        .btn-verify {
            background-color: var(--success-color);
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            width: 100%;
            border-radius: var(--border-radius);
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 1rem;
        }
        
        .btn-verify:hover {
            background-color: #17a673;
            transform: translateY(-2px);
        }
        
        .btn-verify:active {
            transform: translateY(0);
        }
        
        /* OTP input specific styling */
        input[type="number"] {
            -webkit-appearance: none;
            -moz-appearance: textfield;
        }
        
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive adjustments */
        @media (max-width: 576px) {
            .otp-container {
                padding: 1.75rem;
                margin: 0 1rem;
            }
            
            .otp-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="otp-container">
        <div class="otp-header">
            <h1>OTP VERIFICATION</h1>
            <p>Enter the 5-digit code sent to your email</p>
        </div>
        
        <div class="alert alert-primary" role="alert">
            <?php if(isset($_REQUEST['msg'])) echo $_REQUEST['msg']; ?>
        </div>
        
        <form action="login.php" method="post">
            <div class="mb-3">
                <label for="otpInput" class="form-label">Enter OTP</label>
                <input type="number" class="form-control" name="otp" id="otpInput" 
                       placeholder="Enter 5-digit code" required maxlength="5" pattern="\d{5}">
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-verify">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    Verify OTP
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add loading spinner on form submission
        document.querySelector('form').addEventListener('submit', function() {
            const btn = this.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.querySelector('.spinner-border').classList.remove('d-none');
            btn.innerHTML = btn.innerHTML.replace('Verify OTP', 'Verifying...');
        });
        
        // Auto-tab between OTP digits (if you had multiple inputs)
        // This can be expanded if you want to split into individual digit boxes
        document.getElementById('otpInput').addEventListener('input', function(e) {
            if(this.value.length > 5) {
                this.value = this.value.slice(0, 5);
            }
        });
    </script>
</body>

</html>