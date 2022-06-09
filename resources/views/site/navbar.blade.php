<ul class="navbar-nav ml-auto">
    <li class="nav-item @if($active === 'home'){{'active'}}@endif">
        <a class="nav-link" href="{{url('/')}}">Home</a>
    </li>
    <li class="nav-item @if($active === 'about'){{'active'}}@endif">
        <a class="nav-link" href="{{url('/aboutus')}}">AboutUS</a>
    </li>
    <li class="nav-item @if($active === 'products'){{'active'}}@endif">
        <a class="nav-link" href="{{url('/site/products')}}">Products</a>
    </li>
    <li class="nav-item @if($active === 'solutions'){{'active'}}@endif">
        <a class="nav-link" href="{{url('/site/solutions')}}">Solutions</a>
    </li>
    <li class="nav-item @if($active === 'caseStudies'){{'active'}}@endif">
        <a class="nav-link" href="{{url('/caseStudies')}}">CaseStudies</a>
    </li>
    <li class="nav-item @if($active === 'references'){{'active'}}@endif">
        <a class="nav-link" href="{{url('/site/references')}}">References</a>
    </li>

    <li class="nav-item @if($active === 'contact'){{'active'}}@endif">
        <a class="nav-link" href="{{url('/contact')}}">Contact</a>
    </li>
</ul>