<div class=''>
    <div class='posty' style="margin-bottom: 2px;">
        <div class='post-bar no-margin'>
            <div class="row">
                <div style="padding: 3px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class='usy-dt'>
                                @if(Auth::check())
                                    <a href="{{route('getProfil',['user_id'=>$author->id])}}">
                                @else
                                    <a href="" data-toggle="modal" data-target="#modalLogin">
                                @endif
                                                <div class='usr-pic-profil'
                                                     style="background-image: url({{asset(!empty($author->user_image)?$author->user_image:'/images/deaultuser.jpg')}});">
                                                </div>
                                            </a>
                                            <div class='usy-name'>
                                                <h3 style='font-size:11pt;padding:0px;'>
                                                    @if(Auth::check())
                                                        <a href="{{route('getProfil',['user_id'=>$author->par])}}">{{$author->prenom}} {{$author->nom}}</a>
                                                    @else
                                                        <a href="" data-toggle="modal" data-target="#modalLogin">
                                                            {{$author->prenom}} {{$author->nom}}
                                                        </a>
                                                    @endif
                                                </h3>

                                                <div>
                                                    <b title="{{$author->cityName}}"
                                                       style='color:#A3A3A3;font-size: 14px;'>
                                                        {{\Illuminate\Support\Str::limit($author->cityName , $limit = 13, $end = '..')}}
                                                    </b>
                                                    @if(!empty($author->countryName) && !empty($author->cityName))
                                                        <span>
                        									 <b style='color:#A3A3A3;font-size: 14px;'> - {{\Illuminate\Support\Str::limit($author->countryName , $limit = 13, $end = '..')}}</b>
                      								</span>
                                                    @endif
                                                </div>
                                            </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2 ml-2" style="color: #686868;font-size: 16px;line-height: 24px;">
                            <div class="text-center" style="display: inline-block;">
                                <span style="color: #a349a4;font-weight: bold;font-size: 26px;"><b>{{$key+1}}</b></span>
                                | {{$author->vues}} {{config('lang.lbl_read')[empty(session('lang'))?0:session('lang')]}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



