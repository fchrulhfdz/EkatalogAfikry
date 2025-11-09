<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Afikry</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full space-y-8 p-8">
        <!-- Header -->
        <div class="text-center">
            <h1 class="text-3xl font-bold text-afikry-primary">Afikry</h1>
            <h2 class="mt-6 text-2xl font-bold text-gray-900">Login ke Admin Panel</h2>
            <p class="mt-2 text-sm text-gray-600">
                Masuk sebagai admin atau kasir
            </p>
        </div>

        <!-- Login Form -->
        <form class="mt-8 space-y-6 bg-white p-6 rounded-lg shadow-md" method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input 
                    id="email" 
                    name="email" 
                    type="email" 
                    required 
                    autocomplete="email"
                    autofocus
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-afikry-primary focus:border-afikry-primary @error('email') border-red-500 @enderror"
                    value="{{ old('email') }}"
                >
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input 
                    id="password" 
                    name="password" 
                    type="password" 
                    required 
                    autocomplete="current-password"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-afikry-primary focus:border-afikry-primary @error('password') border-red-500 @enderror"
                >
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input 
                        id="remember" 
                        name="remember" 
                        type="checkbox"
                        class="h-4 w-4 text-afikry-primary focus:ring-afikry-primary border-gray-300 rounded"
                    >
                    <label for="remember" class="ml-2 block text-sm text-gray-900">
                        Ingat saya
                    </label>
                </div>

                @if (Route::has('password.request'))
                <div class="text-sm">
                    <a href="{{ route('password.request') }}" class="font-medium text-afikry-primary hover:text-afikry-secondary">
                        Lupa password?
                    </a>
                </div>
                @endif
            </div>

            <!-- Submit Button -->
            <div>
                <button 
                    type="submit" 
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-afikry-primary hover:bg-afikry-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-afikry-primary transition duration-300"
                >
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-sign-in-alt text-afikry-secondary group-hover:text-afikry-primary"></i>
                    </span>
                    Masuk
                </button>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>

        <!-- Back to Home -->
        <div class="text-center">
            <a href="{{ route('home') }}" class="text-afikry-primary hover:text-afikry-secondary font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Beranda
            </a>
        </div>
    </div>

    <script>
        // Simple form validation enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const email = document.getElementById('email');
            const password = document.getElementById('password');

            form.addEventListener('submit', function(e) {
                let valid = true;

                // Email validation
                if (!email.value) {
                    showError(email, 'Email harus diisi');
                    valid = false;
                } else if (!isValidEmail(email.value)) {
                    showError(email, 'Format email tidak valid');
                    valid = false;
                } else {
                    clearError(email);
                }

                // Password validation
                if (!password.value) {
                    showError(password, 'Password harus diisi');
                    valid = false;
                } else {
                    clearError(password);
                }

                if (!valid) {
                    e.preventDefault();
                }
            });

            function showError(input, message) {
                clearError(input);
                input.classList.add('border-red-500');
                
                let errorDiv = document.createElement('p');
                errorDiv.className = 'mt-1 text-sm text-red-600';
                errorDiv.textContent = message;
                
                input.parentNode.appendChild(errorDiv);
            }

            function clearError(input) {
                input.classList.remove('border-red-500');
                const errorDiv = input.parentNode.querySelector('.text-red-600');
                if (errorDiv) {
                    errorDiv.remove();
                }
            }

            function isValidEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }
        });
    </script>
</body>
</html>