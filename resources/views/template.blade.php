<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Cash Plug Africa</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('landing-page/assets/favicon.ico') }}" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('landing-page/css/styles.css') }}" rel="stylesheet" />
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#page-top"><img src="{{ asset('plugins/images/logo-icon.png') }}"
                    alt="..." /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars ms-1"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#how-it-works">How it works</a></li>
                    <li class="nav-item"><a class="nav-link" href="#team">Team</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    @if (Auth::check())
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="post" id="logout-form">
                                @csrf
                                <a class="btn btn-primary btn-sm" href="javascript:{}"
                                    onclick="document.getElementById('logout-form').submit()">
                                    <span class="text-sm">Logout <br>{{ Auth::user()->name }}</span>
                                </a>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-warning" href="{{ route('login') }}">Login</a>
                            <a class="btn btn-info" href="{{ route('register') }}">Register</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead">
        <div class="container">
            <div class="masthead-subheading">Africa's No1 contribution platform</div>
            <div class="masthead-heading text-uppercase">Welcome To Cashplug Africa</div>
            <a class="btn btn-info btn-xl text-uppercase" href="#about">Tell Me More</a>
            @if (Auth::check())
                <a class="btn btn-primary btn-xl text-uppercase" href="{{ route('login') }}">Dashboard</a>
            @else
                <a class="btn btn-primary btn-xl text-uppercase" href="{{ route('login') }}">Login</a>
            @endif
        </div>
    </header>
    <!-- about-->
    <section class="page-section" id="about">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">About</h2>
                <h3 class="section-subheading text-muted">About cashplug.</h3>
            </div>
            <div class="row text-center">
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-robot fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Automated</h4>
                    <p class="text-muted">CashPlug Africa is an automated system that works for you. It is a proven
                        support chain system that will totally eradicate poverty using the power of Team work.
                        It is the Africans’ fastest and reliable platform to help you meet your financial goals...The
                        moment you sign up and make a contribution you will be
                        assigned automatically matched contributors that work on your behalf and you get paid the moment
                        your contributors reach the needed number.
                    </p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-users fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Team work</h4>
                    <p class="text-muted">Team Work boosts productivity – when workload is shared equally by members of
                        a
                        team and the tasks are allocated according to the strengths and skills of each team member,
                        tasks are completed faster and more efficiently which results in a noticeable increase in
                        productivity. With CashPlug, you become a member of a team, and that team works for you and with
                        you. With
                        our automated matching system, people around the globe support each other without even realizing
                        it by simply signing up and making a contribution on CashPlug.</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-lock fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Secure</h4>
                    <p class="text-muted">CashPlug automatically matches individuals and they contribute to one another
                        on a fair ‘first come first serve basis’ your initial contribution is automatically matched to
                        an existing member,and from then on, new members will be assigned to you too.With a guaranteed
                        plan and secure technical
                        setup(servers) your info is safe. All sensitive information is stored on a secure server and is
                        not shared with anyone.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- services Grid-->
    <section class="page-section bg-light" id="services">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Plans</h2>
                <h3 class="section-subheading text-muted">Here's a list of available contribution plans</h3>
            </div>
            <div class="row">
                @foreach ($plans as $plan)
                    <div class="col-sm-4 mb-2">
                        <div class="card">
                            <img src="{{ asset('landing-page/assets/img/header-bg.jpg') }}" alt=""
                                class="card-image-top">
                            <div class="card-body">
                                <h3>{{ $plan->name }}</h3>
                                <p>
                                    <i class="fas fa-check"></i> {{ $plan->refs }} contributors per cycle <br>
                                    <i class="fas fa-check"></i> {{ $plan->price }} NGN <br>
                                    <i class="fas fa-check"></i> {{ $plan->validity }} Days <br>
                                    <i class="fas fa-check"></i> Make at least
                                    {{ $plan->price * $plan->refs * env('USER_PERCENTAGE') }} NGN <br>
                                    <i class="fas fa-check"></i> Min withdarwal
                                    {{ $plan->price * 4 * env('USER_PERCENTAGE') }} NGN <br>
                                </p>
                                <a href="{{ route('register') }}" class="btn btn-warning">
                                    Contribute
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- About-->
    <section class="page-section" id="how-it-works">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">How it works</h2>
                <h3 class="section-subheading text-muted">How to get on-board.</h3>
            </div>
            <ul class="timeline">
                <li>
                    <div class="timeline-image d-flex align-items-center justify-content-center">
                        <h1 class="" style="font-size: 5rem">1</h1>
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="subheading">Sign Up</h4>
                        </div>
                        <div class="timeline-body">
                            <p class="text-muted">Sign Up by filling out the <a href="{{ route('register') }}">
                                    registration form </a>, <a href="{{ route('login') }}">login</a> using your
                                email and password, add your beneficiary bank account.</p>
                        </div>
                    </div>
                </li>
                <li class="timeline-inverted">
                    <div class="timeline-image d-flex align-items-center justify-content-center">
                        <h1 class="" style="font-size: 5rem">2</h1>
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="subheading">Activate a plan</h4>
                        </div>
                        <div class="timeline-body">
                            <p class="text-muted"> Activate ANY Contribution plan by selecting it in the settings tab of
                                your
                                dashboard (The screen you get after logging in) and making a
                                payment (via our payment gateways) to activate the selected Contribution plan of choice.
                                After a
                                successful payment(which serves as your contribution to whomever the system places you
                                under-this would be the person who invited you, if you signed up with an invitation
                                link).
                                Your account
                                automatically opens and the system automatically starts placing new Contributors under
                                you
                            </p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="timeline-image d-flex align-items-center justify-content-center">
                        <h1 class="" style="font-size: 5rem">3</h1>
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="subheading">Withdraw</h4>
                        </div>
                        <div class="timeline-body">
                            <p class="text-muted">After the system automatically places the maximum nunber of
                                automatic Contributors(depends on your selected contribution plan) under you, you will
                                be able to
                                withdraw your funds( subject to admin approval) directly to your bank account</p>
                        </div>
                    </div>
                </li>
                <li class="timeline-inverted">
                    <div class="timeline-image d-flex align-items-center justify-content-center">
                        <h1 class="" style="font-size: 5rem">4</h1>
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>July 2020</h4>
                            <h4 class="subheading">Renew</h4>
                        </div>
                        <div class="timeline-body">
                            <p class="text-muted">After Your withdrawal, you will be required to invite 1 person, upon
                                confirmation, the system
                                will automatically allow you to renew or upgrade your contribution plan if you wish to
                                save more.</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="timeline-image d-flex align-items-center justify-content-center">
                        <h1 class="" style="font-size: 5rem">5</h1>
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="subheading">Invitation (optional)</h4>
                        </div>
                        <div class="timeline-body">
                            <p class="text-muted">CashPlug has an automatic system that helps members by automatically
                                matching contributors to other contributors, but members can cut the wait by sourcing
                                for and
                                inviting friends and family to contribute to them.</p>
                        </div>
                    </div>
                </li>
                <li class="timeline-inverted">
                    <div class="timeline-image d-flex align-items-center justify-content-center">
                        <h4>
                            Be Part
                            <br />
                            Of Our
                            <br />
                            Story!
                        </h4>
                    </div>
                </li>
            </ul>

        </div>
    </section>
    <!-- Team-->
    <section class="page-section bg-light" id="team">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Our Amazing Team</h2>
                <h3 class="section-subheading text-muted">The brains behind CashPlug.</h3>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="team-member">
                        <img class="mx-auto rounded-circle" src="{{ asset('landing-page/assets/img/team/1.jpg') }}"
                            alt="..." />
                        <h4>Parveen Anand</h4>
                        <p class="text-muted">Lead Designer</p>
                        <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="team-member">
                        <img class="mx-auto rounded-circle" src="{{ asset('landing-page/assets/img/team/2.jpg') }}"
                            alt="..." />
                        <h4>Samuel Sambo</h4>
                        <p class="text-muted">Lead Marketer</p>
                        <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="team-member">
                        <img class="mx-auto rounded-circle" src="{{ asset('landing-page/assets/img/team/3.jpg') }}"
                            alt="..." />
                        <h4>Walshak Apollos</h4>
                        <p class="text-muted">Lead Developer</p>
                        <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <p class="large text-muted">CashPlug was made to bring people together, because it started with
                        people coming together.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Clients-->
    <div class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3 col-sm-6 my-3">
                    <a href="#!"><img class="img-fluid img-brand d-block mx-auto"
                            src="{{ asset('landing-page/assets/img/logos/fluterwave.png') }}" alt="..." /></a>
                </div>
                <div class="col-md-3 col-sm-6 my-3">
                    <a href="#!"><img class="img-fluid img-brand d-block mx-auto"
                            src="{{ asset('landing-page/assets/img/logos/uba.png') }}" alt="..." /></a>
                </div>
                <div class="col-md-3 col-sm-6 my-3">
                    <a href="#!"><img class="img-fluid img-brand d-block mx-auto"
                            src="{{ asset('landing-page/assets/img/logos/ocean.png') }}" alt="..." /></a>
                </div>
                <div class="col-md-3 col-sm-6 my-3">
                    <a href="#!"><img class="img-fluid img-brand d-block mx-auto"
                            src="{{ asset('landing-page/assets/img/logos/paystack.png') }}" alt="..." /></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact-->
    <section class="page-section" id="contact">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Contact Us</h2>
                <h3 class="section-subheading text-muted">Get in touch with us.</h3>
            </div>
            <form id="contactForm">
                <div class="row align-items-stretch mb-5">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input class="form-control" id="name" type="text" placeholder="Your Name *"
                                required="required" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="form-group">
                            <input class="form-control" id="email" type="email" placeholder="Your Email *"
                                required="required" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="form-group mb-md-0">
                            <input class="form-control" id="phone" type="tel" placeholder="Your Phone *"
                                required="required" />
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-textarea mb-md-0">
                            <textarea class="form-control" id="message" placeholder="Your Message *"
                                required="required"></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <div id="success"></div>
                    <button class="btn btn-primary btn-xl text-uppercase" id="sendMessageButton" type="submit">Send
                        Message</button>
                </div>
            </form>
        </div>
    </section>
    <!-- Footer-->
    <footer class="footer py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 text-lg-start">
                    Copyright &copy; CashPlug
                    <!-- This script automatically adds the current year to your website footer-->
                    <!-- (credit: https://updateyourfooter.com/)-->
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                </div>
                <div class="col-lg-4 my-3 my-lg-0">
                    <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a class="link-dark text-decoration-none me-3" href="#!">Privacy Policy</a>
                    <a class="link-dark text-decoration-none" href="#!">Terms of Use</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('landing-page/js/scripts.js') }}"></script>
</body>

</html>
