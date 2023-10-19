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

                        <form method="POST" wire:submit='login' class="row g-3 needs-validation" novalidate>

                            @if (session()->has('warning'))
                            <div class="alert alert-warning d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                                <div>
                                    {{ session('warning') }}
                                </div>
                            </div>
                            @endif

                            <div class="col-12">
                                <label for="yourUsername" class="form-label">Username</label>
                                <div class="input-group has-validation">
                                    <input type="text" name="email" wire:model='email' class="form-control"
                                        id="yourUsername" required>
                                    {{-- <span class="input-group-text" id="inputGroupPrepend">@praja.ipdn.ac.id</span> --}}
                                    <div class="invalid-feedback">Please enter your username.</div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="yourPassword" class="form-label">Password</label>
                                <input type="password" name="password" wire:model='password' class="form-control"
                                    id="yourPassword" required>
                                <div class="invalid-feedback">Please enter your password!</div>
                            </div>

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
