<div class="body-login">
    <div class="login-container">
        <div class="row g-0">
            <!-- Logo Section -->
            <div class="col-lg-5 d-none d-lg-block">
                <div class="logo-section">
                    <div class="logo-img">
                        {{-- <i class="bi bi-book-half" style="font-size: 40px; color: #4285F4;"></i> --}}

                        <img src="./assets/admin/img/logo.png" width="60">
                        {{-- <span class="d-none d-lg-block">{{ getenv('APP_NAME') }}</span> --}}
                    </div>
                    <div class="logo-text">{{ getenv('APP_NAME') }}</div>
                    <p class="text-center mt-3">Akses ilmu pengetahuan tanpa batas</p>
                </div>
            </div>

            <!-- Form Section -->
            <div class="col-lg-7">
                <div class="form-section">
                    <div class="welcome-text pb-4">
                        <h4>Selamat Datang</h4>
                    </div>

                    <div class="">
                        {{-- Alert --}}
                        @if (session('success'))
                            <x-admin.components.alert.success text="{{ session('success') }}" />
                        @endif

                        @if (session('warning'))
                            <x-admin.components.alert.warning text="{{ session('warning') }}" />
                        @endif

                        @if (session('error'))
                            <x-admin.components.alert.error text="{{ session('error') }}" />
                        @endif
                    </div>

                    <!-- Login Form -->
                    <form wire:submit='login' class="row g-3 needs-validation" novalidate>
                        @csrf

                        {{-- Input Email --}}
                        <div class="mb-3">
                            <x-admin.components.form.input type="email" name='email' placeholder='E-Mail'
                                required='required' />
                        </div>

                        {{-- Input Kata Sandi --}}
                        <div class="mb-4">
                            <x-admin.components.form.input type="password" name='password' placeholder='Kata Sandi'
                                required='required' />
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Masuk</button>
                        </div>
                    </form>

                    <div class="divider">ATAU</div>

                    <!-- Google Login Buttons -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('google.login', ['domain' => 'praja']) }}" class="btn btn-sm btn-google btn-google-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24">
                                    <path fill="#4285F4"
                                        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                    <path fill="#34A853"
                                        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                    <path fill="#FBBC05"
                                        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                    <path fill="#EA4335"
                                        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                                </svg>
                                Masuk Sebagai Praja
                            </a>
                        </div>

                        <div class="col-md-6 mb-3">
                            <a href="{{ route('google.login', ['domain' => 'pegawai']) }}" class="btn btn-sm btn-google btn-google-warning">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24">
                                    <path fill="#4285F4"
                                        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                    <path fill="#34A853"
                                        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                    <path fill="#FBBC05"
                                        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                    <path fill="#EA4335"
                                        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                                </svg>
                                Masuk Sebagai Pegawai
                            </a>
                        </div>
                    </div>

                    <x-login.footer />

                </div>
            </div>
        </div>
    </div>
</div>
