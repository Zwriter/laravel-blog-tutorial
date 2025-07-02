<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Laravel Blog</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 3px; box-sizing: border-box; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 3px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .success { color: green; background: #d4edda; border: 1px solid #c3e6cb; padding: 10px; border-radius: 3px; margin-bottom: 20px; }
        .error { color: red; font-size: 14px; margin-top: 5px; }
        .section { margin-bottom: 40px; padding-bottom: 30px; border-bottom: 1px solid #eee; }
        .section:last-child { border-bottom: none; }
        .danger { background: #dc3545; }
        .danger:hover { background: #c82333; }
        .links { margin-top: 20px; }
        .links a { color: #007bff; text-decoration: none; margin-right: 15px; }
        .links a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Profile Settings</h2>
        
        @if(session('status') === 'profile-updated')
            <div class="success">Profile updated successfully!</div>
        @endif
        
        @if(session('status') === 'password-updated')
            <div class="success">Password updated successfully!</div>
        @endif
        
        <!-- Profile Information -->
        <div class="section">
            <h3>Profile Information</h3>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')
                
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="{{ $user->name }}" required>
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ $user->email }}" required>
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit">Update Profile</button>
            </form>
        </div>
        
        <!-- Update Password -->
        <div class="section">
            <h3>Update Password</h3>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('put')
                
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required>
                    @error('current_password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" required>
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>
                
                <button type="submit">Update Password</button>
            </form>
        </div>
        
        <!-- Delete Account -->
        <div class="section">
            <h3>Delete Account</h3>
            <p>Once your account is deleted, all of its resources and data will be permanently deleted.</p>
            <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
                @csrf
                @method('delete')
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Confirm your password" required>
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="danger">Delete Account</button>
            </form>
        </div>
        
        <div class="links">
            <a href="{{ route('home') }}">← Back to Blog</a>
            @if($user->is_admin)
                <a href="{{ route('admin.posts.index') }}">Admin Panel</a>
            @endif
        </div>
    </div>
</body>
</html>