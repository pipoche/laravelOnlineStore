<header class="header_section">
    <nav class="navbar navbar-expand-lg custom_nav-container">
        <!-- Navbar Toggler Button for Mobile View -->
      

        <ul class="costumnav navbar-nav">
            <!-- Language Buttons -->
            <li class="nav-item">
                <div class="nav-link language-buttons mr-auto d-flex align-items-center">
                    <a href="?lang=en" class="btn" title="English">
                        <img src="{{ asset('assets/images/ukflag.png') }}" alt="">
                    </a>
                    <a href="?lang=fr" class="btn" title="Français">
                        <img src="{{ asset('assets/images/frflag.png') }}" alt="">
                    </a>
                    <a href="?lang=ar" class="btn" title="العربية">
                        <img src="{{ asset('assets/images/maflag.png') }}" alt="">
                    </a>
                </div>
            </li>

            <!-- Brand Title -->
            <li class="nav-item">
                <a class="nav-link navbar-brand" href="{{Route('homepage')}}">
                    <span class="brand-name">QISMO<img src="" alt=""></span>
                </a>
            </li>

            <!-- Social Media Icons -->
            <li class="nav-item">
                <div class="nav-link social-media-icons">
                    <a href="https://www.instagram.com" target="_blank" class="mr-2" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.facebook.com" target="_blank" class="mr-2" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.twitter.com" target="_blank" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse {{ Request::routeIs('homepage') ? '' : 'innerpage_navbar' }}" id="navbarSupportedContent">
            <ul class="navbar-nav ">
                <li class="nav-item {{ Request::routeIs('homepage') ? 'active' : '' }}">
                    <a class="nav-link" href="{{Route('homepage')}}">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item {{ Request::routeIs('edutol') ? 'active' : '' }}">
                    <a class="nav-link" href="{{Route('edutol')}}">educational tools</a>
                </li>
                <li class="nav-item {{ Request::routeIs('bandn') ? 'active' : '' }}">
                    <a class="nav-link" href="{{Route('bandn')}}">books and novels</a>
                </li>
                <li class="nav-item {{ Request::routeIs('lespacks') ? 'active' : '' }}">
                    <a class="nav-link" href="{{Route('lespacks')}}">packs</a>
                </li>
                <li class="nav-item {{ Request::routeIs('contactus') ? 'active' : '' }}">
                    <a class="nav-link" href="{{Route('contactus')}}">Contact Us</a>
                </li>
                
            </ul>

            <!-- <div class="user_option">
                <a href="" class="">
                    <i id="cart-icon" class="fa fa-shopping-bag" aria-hidden="true"></i>
                   
                </a>
            </div> -->
        </div>
    </nav>
</header>
