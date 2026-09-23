<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('assets/admin/img/logo.png') }}" alt="">

            <span class="d-none d-lg-block">Perpustakaan</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            {{-- Notivication Nav --}}
            <li class="nav-item dropdown invisible">

                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <span class="badge bg-primary badge-number">4</span>
                </a><!-- End Notification Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                    <li class="dropdown-header">
                        You have 4 new notifications
                        <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li class="notification-item">
                        <i class="bi bi-exclamation-circle text-warning"></i>
                        <div>
                            <h4>Lorem Ipsum</h4>
                            <p>Quae dolorem earum veritatis oditseno</p>
                            <p>30 min. ago</p>
                        </div>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li class="notification-item">
                        <i class="bi bi-x-circle text-danger"></i>
                        <div>
                            <h4>Atque rerum nesciunt</h4>
                            <p>Quae dolorem earum veritatis oditseno</p>
                            <p>1 hr. ago</p>
                        </div>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li class="notification-item">
                        <i class="bi bi-check-circle text-success"></i>
                        <div>
                            <h4>Sit rerum fuga</h4>
                            <p>Quae dolorem earum veritatis oditseno</p>
                            <p>2 hrs. ago</p>
                        </div>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li class="notification-item">
                        <i class="bi bi-info-circle text-primary"></i>
                        <div>
                            <h4>Dicta reprehenderit</h4>
                            <p>Quae dolorem earum veritatis oditseno</p>
                            <p>4 hrs. ago</p>
                        </div>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="dropdown-footer">
                        <a href="#">Show all notifications</a>
                    </li>

                </ul><!-- End Notification Dropdown Items -->

            </li><!-- End Notification Nav -->

            <li class="nav-item dropdown invisible">

                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-chat-left-text"></i>
                    <span class="badge bg-success badge-number">3</span>
                </a><!-- End Messages Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                    <li class="dropdown-header">
                        You have 3 new messages
                        <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li class="message-item">
                        <a href="#">
                            <img src="{{ asset('assets/admin/img/messages-1.jpg') }}" alt=""
                                class="rounded-circle">
                            <div>
                                <h4>Maria Hudson</h4>
                                <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                <p>4 hrs. ago</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li class="message-item">
                        <a href="#">
                            <img src="{{ asset('assets/admin/img/messages-2.jpg') }}" alt=""
                                class="rounded-circle">
                            <div>
                                <h4>Anna Nelson</h4>
                                <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                <p>6 hrs. ago</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li class="message-item">
                        <a href="#">
                            <img src="{{ asset('assets/admin/img/messages-3.jpg') }}" alt=""
                                class="rounded-circle">
                            <div>
                                <h4>David Muldon</h4>
                                <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                <p>8 hrs. ago</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li class="dropdown-footer">
                        <a href="#">Show all messages</a>
                    </li>

                </ul><!-- End Messages Dropdown Items -->

            </li><!-- End Messages Nav -->

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">

                    <img src="{{ Auth::user()->photo ? asset('foto_pegawai/' . Auth::user()->photo) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim(Auth::user()->email))) . '?s=200&d=mp' }}" alt="Avatar" class="rounded-circle" />

                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <span>{{ Auth::user()->role->ROLE_NAME }}</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal"
                            data-bs-target="#profilSaya">
                            <i class="bi bi-person"></i>
                            <span>Profil Saya</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li class="d-none">
                        <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                            <i class="bi bi-gear"></i>
                            <span>Account Settings</span>
                        </a>
                    </li>
                    <li class="d-none">
                        <hr class="dropdown-divider">
                    </li>

                    <li class="d-none">
                        <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                            <i class="bi bi-question-circle"></i>
                            <span>Need Help?</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header>

@auth
    <livewire:admin.profile.update />

    {{--
        Modal "Profil Saya" (x-admin.components.modal.modal) dibungkus
        wire:ignore, jadi Livewire moal bisa nutup modal-na sorangan atawa
        némbongkeun pesen sukses/gagal ti jero éta modal. Ku kituna kadua
        hal ieu ditanganan manual ku JS di dieu, ngadangukeun event nu
        di-dispatch ti App\Livewire\Admin\Profile\Update::updateProfile().
    --}}
    <div id="profilNotifikasi" class="alert d-none position-fixed top-0 end-0 m-3 shadow"
        style="z-index: 2000; min-width: 320px;" role="alert"></div>

    <script>
        document.addEventListener('livewire:init', () => {
            const modalEl = document.getElementById('profilSaya');
            const notif = document.getElementById('profilNotifikasi');
            let hideTimeout;

            const showNotifikasi = (message, isSuccess) => {
                notif.textContent = message;
                notif.classList.remove('d-none', 'alert-success', 'alert-danger');
                notif.classList.add(isSuccess ? 'alert-success' : 'alert-danger');

                clearTimeout(hideTimeout);
                hideTimeout = setTimeout(() => notif.classList.add('d-none'), 5000);
            };

            // Ngabersihkeun <input type="file"> unggal modal ditutup (ku cara
            // naon wae: tombol X, tombol Tutup, klik backdrop, atawa Esc),
            // supados foto lami nu kapilih moal kabawa deui teu kahaja
            // dina sesi buka-tutup modal salajengna.
            modalEl?.addEventListener('hidden.bs.modal', () => {
                const fileInput = modalEl.querySelector('input[type="file"]');
                if (fileInput) fileInput.value = '';
            });

            // Livewire ngintun parameter nu di-dispatch kalayan nami
            // (contona "message: $x") minangka hiji objék, sanés string
            // langsung — ku kituna kudu di-destructure { message }.
            Livewire.on('profile-updated', ({ message }) => {
                showNotifikasi(message ?? 'Profil berhasil diperbaharui.', true);
                // Nutup modal ku cara nyimulasikeun klik kana tombol tutup
                // bawaan (data-bs-dismiss), sanés maké API JS Bootstrap
                // langsung — sabab "window.bootstrap" teu diékspos global
                // ku bundel Vite proyék ieu (napak kana pola nu sarua
                // dipaké ku sadaya modal séjén di aplikasi ieu).
                modalEl?.querySelector('.btn-close')?.click();
            });

            Livewire.on('profile-update-failed', ({ message }) => {
                showNotifikasi(message ?? 'Gagal memperbaharui profil.', false);
            });
        });
    </script>
@endauth
