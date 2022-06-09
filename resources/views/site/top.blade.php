
    @if($phone)
        <li><i class="fas fa-phone"></i> {{$phone->value}} </li>
    @endif
    @if($address && $latitude)
        <li>
            <i class="fas fa-map-marker-alt"></i>
            <a href="https://www.google.com/maps/place/30%C2%B003'08.6%22N+31%C2 %B011'57.4%22E/{{'@'.$latitude->value}},{{$longitude->value}},17z/data=!3m1!4b1!4m5!3 m4!1s0x0:0x0!8m2!3d30.0523815!4d31.1992741?hl=en" target="_blanck">
                {{$address->value}}
            </a>
        </li>
    @endif