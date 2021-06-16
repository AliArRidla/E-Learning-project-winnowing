<!-- HEADER DESKTOP-->
<header class="header-desktop">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="header-wrap float-right">
                <div class="header-button">
                    {{-- <div class="noti-wrap">
                        <div class="noti__item js-item-menu">
                            <i class="zmdi zmdi-notifications"></i>
                            <span class="quantity">3</span>
                            <div class="notifi-dropdown js-dropdown">
                                <div class="notifi__title">
                                    <p>You have 3 Notifications</p>
                                </div>
                                <div class="notifi__item">
                                    <div class="bg-c1 img-cir img-40">
                                        <i class="zmdi zmdi-email-open"></i>
                                    </div>
                                    <div class="content">
                                        <p>You got a email notification</p>
                                        <span class="date">April 12, 2018 06:50</span>
                                    </div>
                                </div>
                                <div class="notifi__item">
                                    <div class="bg-c2 img-cir img-40">
                                        <i class="zmdi zmdi-account-box"></i>
                                    </div>
                                    <div class="content">
                                        <p>Your account has been blocked</p>
                                        <span class="date">April 12, 2018 06:50</span>
                                    </div>
                                </div>
                                <div class="notifi__item">
                                    <div class="bg-c3 img-cir img-40">
                                        <i class="zmdi zmdi-file-text"></i>
                                    </div>
                                    <div class="content">
                                        <p>You got a new file</p>
                                        <span class="date">April 12, 2018 06:50</span>
                                    </div>
                                </div>
                                <div class="notifi__footer">
                                    <a href="#">All notifications</a>
                                </div>
                            </div>
                        </div>
                    </div> --}}
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
                                        <a href="{{ request()->is('siswa/kerjakan-ulangan/*') ? '#' : route('profilAcc', ['id' => Auth::user()->id]) }}">
                                            <i class="zmdi zmdi-account"></i>Account</a>
                                    </div>
                                </div>
                                <div class="account-dropdown__footer">
                                    {{-- <a href="#">
                                        <i class="zmdi zmdi-power"></i>Logout
                                    </a> --}}
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                            <i class="zmdi zmdi-power"></i>Logout
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
