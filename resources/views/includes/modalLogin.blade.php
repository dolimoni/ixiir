<!-- Modal -->
<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="login-sec">
                    <ul class="sign-control">

                        <li data-tab="tab-login" class="current"><a href="#" title="">{{config('lang.lbl_login')[empty(session('lang'))?0:session('lang')]}}</a></li>

                        <li data-tab="tab-register"><a href="#" title="">{{config('lang.lbl_sinscrit')[empty(session('lang'))?0:session('lang')]}}</a></li>

                    </ul>
                    <div class="sign_in_sec current" id="tab-login">
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
                    <div class="sign_in_sec" id="tab-register">
                        <h3 style="text-align:left;" >{{config('lang.lbl_sinscrit')[empty(session('lang'))?0:session('lang')]}}</h3>
                        <div class="dff-tab current" id="tab-3">
                            @include('formInscription')
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

