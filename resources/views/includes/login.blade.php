<div class="login-sec" id="homeLogin">
    <ul class="sign-control">

        <li data-tab="tab-1" class="current"><a href="#" title="">{{config('lang.lbl_login')[empty(session('lang'))?0:session('lang')]}}</a></li>

        <li data-tab="tab-2"><a href="#" title="">{{config('lang.lbl_sinscrit')[empty(session('lang'))?0:session('lang')]}}</a></li>

    </ul>
    <div class="sign_in_sec current" id="tab-1">
        <h3>{{config('lang.lbl_login')[empty(session('lang'))?0:session('lang')]}}</h3>
        @include('sign-inForm')
        <div class="login-resources">

            <h3 style="text-align:left;" >{{config('lang.lbl_connexion_via_reseau_soc')[empty(session('lang'))?0:session('lang')]}}</h3>

            <ul>

                <li><a href="{{ url('/login/facebook') }}" title="" class="fb"><i class="fa fa-facebook"></i>{{config('lang.lbl_connexion_facebook')[empty(session('lang'))?0:session('lang')]}}</a></li>



                <li><a href="{{ url('/login/google') }}" title="" class="gp"><i class="fa fa-google"></i>{{config('lang.lbl_connexion_googleplus')[empty(session('lang'))?0:session('lang')]}}</a></li>



            </ul>

        </div><!--login-resources end-->

    </div><!--sign_in_sec end-->
    <div class="sign_in_sec" id="tab-2">
        <h3 style="text-align:left;" >{{config('lang.lbl_sinscrit')[empty(session('lang'))?0:session('lang')]}}</h3>
        <div class="dff-tab current" id="tab-3">
            @include('formInscription')
        </div>
    </div>
</div>
