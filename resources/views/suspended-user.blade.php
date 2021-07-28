<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cashplug - You have been suspended</title>
</head>
<body>
    <h4>Suspended account</h4>
    <p>Sorry, you have been suspended from this site,
        <br> please contact admin with you details to register a complaint</p>
    <p>
        <h5>Your details are: </h5>
        Name: {{Auth::user()->name}} <br>
        Email: {{Auth::user()->email}} <br>
        Ref ID: {{Auth::user()->ref_id}}
    </p>
    <a href="{{route('landing-page')}}">Home</a>
    <br><br>
    <form action="{{route('logout')}}" method="post" id="logout-form">
        @csrf
        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="javascript:{}"
            aria-expanded="false" onclick="document.getElementById('logout-form').submit()">
            <i class="fas fa-sign-out-alt text-danger" aria-hidden="true"></i>
            <span class="hide-menu">Logout <br>{{Auth::user()->name}}</span>
        </a>
    </form>
</body>
</html>
