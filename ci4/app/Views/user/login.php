<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --error: #ef233c;
            --text: #2b2d42;
            --text-light: #8d99ae;
            --bg: #f8f9fa;
            --card: #ffffff;
            --border: #e9ecef;
        }
        
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--text);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }
        
        .login-card {
            background: var(--card);
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            margin: 1rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .login-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        
        .login-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }
        
        .login-subtitle {
            color: var(--text-light);
            font-size: 0.9375rem;
            font-weight: 400;
        }
        
        .alert {
            padding: 0.875rem 1rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            background-color: rgba(239, 35, 60, 0.1);
            color: var(--error);
            border: 1px solid rgba(239, 35, 60, 0.2);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .alert:before {
            content: "!";
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            background: var(--error);
            color: white;
            border-radius: 50%;
            font-weight: bold;
            font-size: 0.75rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text);
        }
        
        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.9375rem;
            transition: all 0.2s ease;
            background-color: var(--card);
            color: var(--text);
        }
        
        .form-input::placeholder {
            color: var(--text-light);
            opacity: 0.6;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }
        
        .login-button {
            width: 100%;
            padding: 0.9375rem;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.9375rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 0.5rem;
        }
        
        .login-button:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
        }
        
        .login-button:active {
            transform: translateY(0);
        }
        
        @media (max-width: 480px) {
            .login-card {
                padding: 2rem 1.5rem;
            }
            
            .login-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="login-header">
            <h1 class="login-title">Login</h1>
        </div>
        
        <?php if (session()->getFlashdata('flash_msg')): ?>
            <div class="alert"><?= session()->getFlashdata('flash_msg') ?></div>
        <?php endif; ?>
        
        <form method="post" action="">
            <div class="form-group">
                <label for="InputForEmail" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-input" id="InputForEmail" 
                       value="<?= set_value('email') ?>" placeholder="Enter your email" required>
            </div>
            
            <div class="form-group">
                <label for="InputForPassword" class="form-label">Password</label>
                <input type="password" name="password" class="form-input" 
                       id="InputForPassword" placeholder="••••••••" required>
            </div>
            
            <button type="submit" class="login-button">Sign In</button>
        </form>
    </div>
</body>

</html>