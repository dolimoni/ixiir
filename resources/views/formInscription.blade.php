<form action="{{route('register')}}" method="POST" name="frm_inscr" >
    @csrf
    <div class="row">

        <div class="col-lg-12 no-pdd">

            <div class="sn-field">

                <input type="text" name="nom" placeholder="{{config('lang.lbl_nom')[empty(session('lang'))?0:session('lang')]}}" required />

                <i class="la la-user"></i>

            </div>

        </div>

        <div class="col-lg-12 no-pdd">

            <div class="sn-field">

                <input type="text" name="prenom" placeholder="{{config('lang.lbl_prenom')[empty(session('lang'))?0:session('lang')]}}" required />

                <i class="la la-user"></i>

            </div>

        </div>

        <div class="col-lg-12 no-pdd">

            <div class="sn-field">

                <select name="pays" id="country" onchange="getVilles();" required >

                    <option value='' >{{config('lang.lbl_pays')[empty(session('lang'))?0:session('lang')]}}</option>
                        @foreach($pays as $p)
                        <option value="{{$p->id}}">{{session('lang')==1?$p->nom_ar:(session('lang')==2?$p->nom_fr:$p->nom_en)}}</option>
                        @endforeach
                </select>

                <i class="la la-globe"></i>

                <span><i class="fa fa-ellipsis-h"></i></span>

            </div>

        </div>

        <div class="col-lg-12 no-pdd">

            <div class="sn-field">

                <select name="ville" id="city" required >

                    <option value='' >{{config('lang.lbl_ville')[empty(session('lang'))?0:session('lang')]}}</option>

                    @foreach($villes as $ville)
                        <option value="{{$ville->id}}">{{$ville->nom_en}}</option>
                    @endforeach

                </select>

                <i class="la la-map-marker"></i>

                <span><i class="fa fa-ellipsis-h"></i></span>

            </div>

        </div>

        <div class="col-lg-12 no-pdd">

            <div class="sn-field">

                <select name="specialite" >

                    <option value='' >{{config('lang.lbl_specialite')[empty(session('lang'))?0:session('lang')]}}</option>

                    @foreach($specialites as $specialite)
                        <option value="{{$specialite->id}}">{{$specialite->nom_en}}</option>
                    @endforeach

                </select>

                <i class="la la-tags"></i>

                <span><i class="fa fa-ellipsis-h"></i></span>

            </div>

        </div>

        <div class="col-lg-12 no-pdd">

            <div class="sn-field">

                <input type="email" name="login" placeholder="{{config('lang.lbl_email')[empty(session('lang'))?0:session('lang')]}}" required />

                <i class="la la-envelope"></i>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
               @enderror
            </div>

        </div>

        <div class="col-lg-12 no-pdd">

            <div class="sn-field">

                <input type="password" name="password" placeholder="{{config('lang.lbl_password')[empty(session('lang'))?0:session('lang')]}}" required />

                <i class="la la-lock"></i>
                @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
              @enderror
            </div>

        </div>

        <div class="col-lg-12 no-pdd">

            <div class="sn-field">

                <input type="password" name="password_confirmation" placeholder="{{config('lang.lbl_repeter_mot_passe')[empty(session('lang'))?0:session('lang')]}}" required />

                <i class="la la-lock"></i>
               
            </div>

        </div>

        <div class="col-lg-12 no-pdd">

            <div class="checky-sec st2">

                <div class="fgt-sec">

                    <input type="checkbox" name="chk_cvg" id="c2" value="yes" required/>

                    <label for="c2">

                        <span></span>

                    </label>

                    <small>{!!str_replace("[[PARAM]]", "conditions",config('lang.lbl_yes_acepcondi')[empty(session('lang'))?0:session('lang')])!!}</small>

                </div><!--fgt-sec end-->

            </div>

        </div>

        <div class="col-lg-12 no-pdd">

            <input type="hidden" name="nameform" value="sinscrire" />

            <button type="submit" >{{config('lang.lbl_sinscrit')[empty(session('lang'))?0:session('lang')]}}</button>

        </div>

    </div>

</form>