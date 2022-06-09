<footer class="full-row bg-footer footer-classic-dark text-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <div class="footer-widget mb-4">
                    <div class="footer-logo mb-4">
                        <a href="#"><img src="{{url('assets/images/logo/logo-white.png')}}" alt="image not found!"></a>
                    </div>
                    <div class="widget-content">
                        <p>
                            @php
                                $footer_Description = \App\Models\Setting::where(['key' => \App\Entities\Key::FOOTER_DESCRIPTION])->first();
                                if($footer_Description){
                                    echo $footer_Description->value;
                                }

                                $facebook = \App\Models\Setting::where(['key' => \App\Entities\Key::FACEBOOK])->first();
                                $twitter = \App\Models\Setting::where(['key' => \App\Entities\Key::TWITTER])->first();
                                $linkedin = \App\Models\Setting::where(['key' => \App\Entities\Key::LINKEDIN])->first();
                                $google_plus = \App\Models\Setting::where(['key' => \App\Entities\Key::GOOGLE_PLUS])->first();
                                $instagram = \App\Models\Setting::where(['key' => \App\Entities\Key::INSTAGRAM])->first();
                            @endphp
                        </p>
                    </div>
                </div>
                <div class="footer-widget media-widget mb-4">
                    @if ($facebook)
                        <a href="{{$facebook->value}}">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    @endif
                    @if ($twitter)
                        <a href="{{$twitter->value}}">
                            <i class="fab fa-twitter"></i>
                        </a>
                    @endif
                    @if ($linkedin)
                        <a href="{{$linkedin->value}}">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    @endif
                    @if ($google_plus)
                        <a href="{{$google_plus->value}}">
                            <i class="fab fa-google-plus-g"></i>
                        </a>
                    @endif
                    @if ($instagram)
                        <a href="{{$instagram->value}}">
                            <i class="fab fa-instagram"></i>
                        </a>
                    @endif
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="footer-widget mb-4">
                    <h4 class="widget-title mb-4">Page Links</h4>
                    <ul class="footer-nav">
                        <li><a href="{{url('/')}}">Home</a></li>
                        <li><a href="{{url('/aboutus')}}">AboutUS</a></li>
                        <li><a href="{{url('/site/products')}}">Products</a></li>
                        <li><a href="{{url('/site/solutions')}}">Solutions</a></li>
                        <li><a href="{{url('/caseStudies')}}">CaseStudies</a></li>
                        <li><a href="{{url('/site/references')}}">References</a></li>
                        <li><a href="{{url('/contact')}}">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="footer-widget newslatter-widget mb-4">
                    <h4 class="widget-title mb-4">Newslatter</h4>
                    <p>Subscribe to our news and get most important industry news</p>
                    <form id="subscribe-form" class="subscribe-widget">
                        <input class="form-control" type="email" required name="email"
                               placeholder="Email Address" aria-label="Address">
                        <button class="btn btn-primary" type="submit">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="full-row bg-dark py-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <ul class="bottom-nav">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="{{url('/aboutus')}}">AboutUS</a></li>
                    <li><a href="{{url('/site/products')}}">Products</a></li>
                    <li><a href="{{url('/site/solutions')}}">Solutions</a></li>
                    <li><a href="{{url('/caseStudies')}}">CaseStudies</a></li>
                    <li><a href="{{url('/site/references')}}">References</a></li>
                    <li><a href="{{url('/contact')}}">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <div class="copyright"><span>&copy; {{date('Y')}} All Rights Reserved by <a
                                href="http://milestone-apps.com/"
                                target="_blanck">Milestone-apps</a></span>
                </div>
            </div>
        </div>
    </div>
</div>
<a href="#" class="bg-primary text-white" id="scroll"><i class="fa fa-angle-up"></i></a>