<!-- HEADER DESKTOP-->
<header class="header-desktop">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="header-wrap float-right">
                <div class="header-button">
                    <div class="account-wrap">
                        <div class="account-item clearfix js-item-menu">
                            <div class="image">
                                @if ($fotoP != null)
                                <img src="{{ asset('storage/profilPic/'.$fotoP) }}" alt="{{ Auth::user()->name }}"
                                    style="max-width:200px; max-height:200px; !important">
                                @else
                                <img src="{{ asset('lms/images/icon/avatar-01.jpg') }}"
                                    alt="{{ Auth::user()->name }}" />
                                @endif
                                {{-- <img src="{{ asset('lms/images/icon/avatar-01.jpg') }}"
                                alt="{{ Auth::user()->name }}" /> --}}
                            </div>
                            <div class="content">
                                {{ Auth::user()->name }}
                            </div>
                            <div class="account-dropdown js-dropdown">
                                <div class="info clearfix">
                                    <div class="image">
                                        @if ($fotoP != null)
                                        <img src="{{ asset('storage/profilPic/'.$fotoP) }}"
                                            alt="{{ Auth::user()->name }}"
                                            style="max-width:200px; max-height:200px; !important">
                                        @else
                                        <img src="{{ asset('lms/images/icon/avatar-01.jpg') }}"
                                            alt="{{ Auth::user()->name }}" />
                                        @endif
                                        {{-- <img src="{{ asset('lms/images/icon/avatar-01.jpg') }}"
                                        alt="{{ Auth::user()->name }}" /> --}}
                                    </div>
                                    <div class="content">
                                        <h5 class="name">
                                            {{ Auth::user()->name }}
                                        </h5>
                                        <span class="email">{{ Auth::user()->email }}</span>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="{{ request()->is('siswa/kerjakan-ulangan/*') ? '#' : route('profilAcc') }}">
                                            <i class="zmdi zmdi-account"></i>Kelola Akun</a>
                                    </div>
                                </div>
                                <div class="account-dropdown__footer">
                                    {{-- <a href="#">
                                        <i class="zmdi zmdi-power"></i>Keluar
                                    </a> --}}
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                            <i class="zmdi zmdi-power"></i>Keluar
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- HEADER DESKTOP-->
