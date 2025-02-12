<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center justify-content-center">

                <div class="d-flex justify-content-center py-4">
                    <a href="index.html" class="logo d-flex align-items-center w-auto">
                        <img src="./assets/admin/img/logo.png" alt="">
                        <span class="d-none d-lg-block">{{ env('APP_NAME') }}</span>
                    </a>
                </div><!-- End Logo -->

                <div class="card mb-3">

                    <div class="card-body">

                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">Selamat Datang</h5>
                            <p class="text-center small">Silahkan masukan surel dan sandi anda</p>
                        </div>

                        <form wire:submit='login' class="row g-3 needs-validation" novalidate>

                            @if (session('success'))
                                <x-admin.components.alert.success text="{{ session('success') }}" />
                            @endif

                            @if (session('warning'))
                                <x-admin.components.alert.warning text="{{ session('warning') }}" />
                            @endif

                            @if (session('error'))
                                <x-admin.components.alert.error text="{{ session('error') }}" />
                            @endif

                            {{-- Input Email --}}
                            <x-admin.components.form.input type="email" name='email' placeholder='E-Mail' required='required' />

                            {{-- Input Kata Sandi --}}
                            <x-admin.components.form.input type="password" name='password' placeholder='Kata Sandi' required='required' />


                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">Masuk</button>
                            </div>

                            {{-- <div class="col-12">
                            <p class="small mb-0">Don't have account? <a
                                    href="pages-register.html">Create an account</a></p>
                        </div> --}}
                        </form>

                    </div>
                </div>

                <x-login.footer />

            </div>
        </div>
    </div>

</section>
