<footer class="footer-custom mt-auto">
    <div class="container">
        <div class="row">
        <!-- CONTACT -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5>CONTACT US</h5>
                <div class="icon-text">
                    <i class="fa fa-envelope"></i>
                    <span>giftshub@gmail.com</span>
                </div>
                <div class="icon-text">
                    <i class="fa fa-map-marker-alt"></i>
                    <span>Pokhara Birauta-17, Nepal</span>
                </div>
                <div class="icon-text">
                    <i class="fa fa-phone-alt"></i>
                    <span>Viber/Whatsapp: +977 9829124784</span>
                </div>
            </div>


            <!-- ACCOUNT -->

            <div class="col-lg-3 col-md-6 mb-4">
                <h5>ACCOUNT</h5>
                    <ul>
                    <li><a href="{{url('cart-list/product')}}">Cart</a></li>
                    <li><a href="#">Account Detail</a></li>
                    <li><a href="{{ url('register1') }}">Sign In / Sign up</a></li>
            <li><a href="#">Orders</a></li>
            </ul>

            </div>


            <!-- SOCIAL -->

            <div class="col-lg-3 col-md-6 mb-4">

                <h5>SOCIAL MEDIA</h5>

                <ul>
                    <li><a href="#"><i class="fab fa-facebook"></i> Facebook</a></li>
                    <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
                    <li><a href="#"><i class="fab fa-linkedin"></i> Linkedin</a></li>
                    <li><a href="#"><i class="fab fa-tiktok"></i> TikTok</a></li>
                </ul>

            </div>


            <!-- INFO -->

            <div class="col-lg-3 col-md-6 mb-4">

                <h5>INFORMATION</h5>

                <ul>
                    <li><a href="#">FAQ's</a></li>
                    <li><a href="{{ route('contact.index') }}">Contact Us</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="#">Delivery Information</a></li>
                    <li><a href="#">Blogs</a></li>
                </ul>
            </div>
        </div>
    </div>


    <div class="footer-bottom">
        <div class="container">
            Copyright {{ date('Y') }} Gifts Hub. All Rights Reserved.
        </div>

    </div>

</footer>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    @stack('scripts')
  </body>
</html>