@if(session()->get('errorLogin'))
<p class="p_msg_erreur">{{config('lang.lbl_msg_login_err_authentf')[empty(session('lang'))?0:session('lang')]}}</p>
@endif
@if(session()->get('desactivated'))
<p class="p_msg_erreur">{{config('lang.lbl_desactivacount')[empty(session('lang'))?0:session('lang')]}}</p>
@endif
<form action="{{route('login')}}" method="POST" >
    @csrf
    <div class="row">

        <div class="col-lg-12 no-pdd">

            <div class="sn-field">

                <input type="text" name="login" placeholder="{{config('lang.lbl_nomutilisateur')[empty(session('lang'))?0:session('lang')]}}" value="{{ old('login') }}" />
                
                <i class="la la-envelope"></i>

            </div><!--sn-field end-->
        </div>

        <div class="col-lg-12 no-pdd">

            <div class="sn-field">

                <input type="password" name="password" placeholder="{{config('lang.lbl_password')[empty(session('lang'))?0:session('lang')]}}" />

                <i class="la la-lock"></i>

            </div>

        </div>

        <div class="col-lg-12 no-pdd">

            <div class="checky-sec">

                <div class="fgt-sec">

                    <a href="{{ route('forgetPass') }}" title="">{{config('lang.lbl_mot_passe_oublie')[empty(session('lang'))?0:session('lang')]}}</a>

                </div>

            </div>

        </div>

        <div class="col-lg-12 no-pdd">

            <input type="hidden" name="nameform" value="login" />

            <button type="submit" value="submit">{{config('lang.lbl_login')[empty(session('lang'))?0:session('lang')]}}</button>

        </div>

    </div>

</form>