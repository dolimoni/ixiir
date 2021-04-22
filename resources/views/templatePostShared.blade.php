
@extends('header-meta2')

<meta id="ogurl" property="og:url"                content="{{route('showPost',['id'=>$post['post_id']])}}" />
<meta property="fb:app_id"               content="289587106105936" />
<meta property="og:type"               content="article" />
<meta id="ogtitle" property="og:title"              content="Article ixiir" />
<meta id="ogdescription" property="og:description"        content="{{htmlspecialchars($post['detail'])}}" />
@if(!empty($post['image']))
    <meta id="ogimage" property="og:image" content="{{asset($post['image'])}}" />
    <meta name="twitter:image" content="{{asset($post['image'])}}">
@else
    <meta id="ogimage" property="og:image" content="{{asset('images/ixiir_en.jpeg')}}" />
    <meta name="twitter:image" content="{{asset('images/ixiir_en.jpeg')}}">
@endif


@section('body')

    <div class="wrapper">
        @include('header-menu')

        <main>

            <div class="main-section" id="dv_mainlistpost" >

                <div class="container">

                    <div class="main-section-data">

                        <div class="row">

                            <div class="col-lg-3 col-md-8 no-pd" id="dv_leftpartpost" >


                                <div class="right-sidebar">

                                    <div class="widget widget-about">

                                        <img src="images/cm-logo.png" alt="" style='margin:20px 0px;' />

                                        <h3>{{config('lang.lbl_comutilefficace')[empty(session('lang'))?0:session('lang')]}}</h3>

                                        <span style="padding:10px 20px;" >{{config('lang.lbl_restconnectenvr')[empty(session('lang'))?0:session('lang')]}}</span>

                                    </div>

                                    <div class="tags-sec full-width">
                                        <ul>

                                            <li><a href="{{route('qui-sommes-nous')}}">{{config('lang.lbl_quisomenous')[empty(session('lang'))?0:session('lang')]}}</a></li>

                                            <li><a href="{{route('conditions')}}">{{config('lang.lbl_condition_utilisation')[empty(session('lang'))?0:session('lang')]}}</a></li>

                                            <li><a href="mailto:ixiirpress@gmail.com" >ixiirpress@gmail.com</a></li>

                                            <li><a href="{{route('setLang','fr')}}" >Français</a></li>

                                            <li><a href="{{route('setLang','ar')}}" >العربية</a></li>

                                            <li><a href="{{route('setLang','en')}}" >English</a></li>

                                        </ul>
                                        <div class="cp-sec">
                                            {{str_replace("[[PARAM2]]",'IXIIR',str_replace("[[PARAM1]]", Carbon\Carbon::now()->year,config('lang.lbl_copyright')[empty(session('lang'))?0:session('lang')]))}}
                                        </div>

                                    </div>

                                </div>

                            </div>
                            <div class="col-lg-9 pd-right-none no-pd">
                                <div class='posty' id="dv_post_{{$post['post_id']}}">
                                    <div class='post-bar no-margin'>
                                        <div class='post_topbar'>
                                            <div class='usy-dt'>
                                                @if(Auth::check())
                                                    <a href="{{route('getProfil',['user_id'=>$post['par']])}}">
                                                        <div class='usr-pic-profil' style="background-image: url({{asset(!empty($post['userDetails']['image'])?$post['userDetails']['image']:'/images/deaultuser.jpg')}});" >

                                                        </div>
                                                    </a>
                                                @else
                                                    <a href="#" data-toggle="modal" data-target="#modalLogin">
                                                        <div class='usr-pic-profil' style="background-image: url({{asset(!empty($post['userDetails']['image'])?$post['userDetails']['image']:'/images/deaultuser.jpg')}});" >

                                                        </div>
                                                    </a>
                                                @endif

                                                <div class='usy-name'>
                                                    <h3 style='font-size:11pt;padding:0px;' >
                                                        @if(Auth::check())
                                                            <a href="{{route('getProfil',['user_id'=>$post['par']])}}">{{isset($post['userDetails'])?$post['userDetails']['prenom']:''}} {{isset($post['userDetails'])?$post['userDetails']['nom']:''}}</a>
                                                        @else
                                                            <a href="#" data-toggle="modal" data-target="#modalLogin">{{isset($post['userDetails'])?$post['userDetails']['prenom']:''}} {{isset($post['userDetails'])?$post['userDetails']['nom']:''}}</a>
                                                        @endif
                                                    </h3>
                                                    <span>{{$post['date_ajout']}}</span>
                                                    <div>
                                                        @if(!empty($post['userDetails']['city']))
                                                            <b style='color:#A3A3A3;font-size: 14px;'>{{$post['userDetails']['city'][empty(session('lang')) || session('lang')==0?'nom_en':(session('lang')==1?'nom_ar':'nom_fr')]}}</b>
                                                        @endif
                                                        @if(!empty($post['userDetails']['country']) && !empty($post['userDetails']['city']))
                                                            <span>
                         <b style='color:#A3A3A3;font-size: 14px;' > - {{$post['userDetails']['country'][empty(session('lang')) || session('lang')==0?'nom_en':(session('lang')==1?'nom_ar':'nom_fr')]}}</b>
                      </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='job_descp'>
                                            <p dir="rtl" id="p_detail_{{$post['post_id']}}">
                                                {!! html_entity_decode(nl2br(e($post['detail']))) !!}
                                            </p>
                                            @if(!empty($post['image']))
                                                <div class="text-center">
                                                    <img src="{{asset($post['image'])}}" style="max-width:400px;margin-bottom:20px;" alt="">
                                                </div>
                                            @endif
                                            @if(!empty($post['youtube']))
                                                <iframe style='width:100%;height:400px;border:none;' src="{{$post['youtube']}}" name='iframe1' frameborder='0'  allow='autoplay; encrypted-media' allowfullscreen></iframe>
                                            @endif
                                        </div>
                                        <div class='job-status-bar'>

                                            <ul class='like-com'>

                                                <li class='sp_cmntlik' onclick="@if(Auth::check() && $post['userDetails']['id']!=Auth::user()->id)set_jaime({{$post['post_id']}}, 0);@endif" >

                                                    <i class='la la-heart' id="i_icojaime_{{$post['post_id']}}" style="cursor:pointer;@if(App\Models\Post::postsJaimeUser($post['post_id'],Auth::user()['id'])>0)color:orange;@endif"></i>
                                                    <b id="b_nbrjaime_{{$post['post_id']}}" >{{App\Models\Post::countPostJaime($post['post_id'])}}</b>
                                                    <input type='hidden' id="txt_isuserjaime_{{$post['post_id']}}" value="{{App\Models\Post::postsJaimeUser($post['post_id'],Auth::user()['id'])>0?1:0}}" />

                                                </li>

                                                <li class='sp_cmntlik comment-link' onclick="show('cacher_comment_{{$post['post_id']}}');show('comments_label_{{$post['post_id']}}');" style="cursor:pointer;@if(Auth::check() && App\Models\Post::countPostComment($post['post_id'])>0)color:orange;@endif">

                                                    <i class='la la-comment'></i>

                                                    <b id="b_nbrcmntr_{{$post['post_id']}}" >{{App\Models\Post::countPostComment($post['post_id'])}}</b>

                                                </li>

                                                <li class='sp_cmntlik' id="i_icovue_{{$post['post_id']}}" onclick="@if(Auth::check() && $post['userDetails']['id']!=Auth::user()->id && App\Models\Post::postsVueUser($post['post_id'],Auth::user()->id)<=0)set_vue({{$post['post_id']}})@endif"  style="cursor:pointer;@if(Auth::check() && App\Models\Post::postsVueUser($post['post_id'],Auth::user()->id)>0)color:orange;@endif">

                                                    <i class='la la-eye'></i>

                                                    <b id="b_nbrvue_{{$post['post_id']}}" >{{App\Models\Post::countPostVues($post['post_id'])}}</b>
                                                    <input type='hidden' id="txt_isuservue_{{$post['post_id']}}" value="{{App\Models\Post::postsVueUser($post['post_id'],Auth::user()['id'])>0?1:0}}" />
                                                </li>

                                                <li class='sp_cmntlik' id="li_abonne_{{$post['post_id']}}" onclick="@if(Auth::check() && $post['userDetails']['id']!=Auth::user()->id)init_abonne({{$post['post_id']}}, {{$post['par']}}, {{Auth::user()['id']}})@endif"  style="cursor:pointer;@if(App\Models\User::abonnesUser($post['userDetails']['id'],Auth::user()['id'])>0)color:orange;@endif">
                                                    @if(count($post['userDetails']['abonnes'])<=0)
                                                        <i class='la la-hand-rock-o' id="i_icoabone_{{$post['post_id']}}" ></i>
                                                    @else
                                                        <i class='la la-hand-pointer-o' id="i_icoabone_{{$post['post_id']}}" ></i>
                                                    @endif
                                                    <b id="sp_nbrabone_{{$post['post_id']}}" >{{App\Models\User::countAbonnes($post['userDetails']['id'])}}</b>
                                                    @if(App\Models\User::countAbonnes($post['userDetails']['id'])>1)
                                                        {{config('lang.lbl_suivis')[empty(session('lang'))?0:session('lang')]}}
                                                    @else
                                                        {{config('lang.lbl_suivi')[empty(session('lang'))?0:session('lang')]}}
                                                    @endif
                                                    <input type='hidden' id="txt_isabonne_{{$post['post_id']}}" value="{{App\Models\User::abonnesUser($post['userDetails']['id'],Auth::user()['id'])>0?1:0}}" />
                                                </li>

                                            </ul>

                                        </div>

                                        <div  class='comment-section' style="display:block;" >

                                            <div class='comment-sec'>

                                                <ul  dir="{{session('lang') !='1' ? 'ltr':'rtl' }}" lang="{{session('lang') !='1' ? 'ar':'fr' }}" id="ul_cmentaire_{{$post['post_id']}}" >



                                                    @if(App\Models\Post::countPostComment($post['post_id'])>0)

                                                        @foreach(App\Models\Post::postComment($post['post_id']) as $comment)


                                                            <li id="li_cmentaire_{{$post['post_id']}}_{{$comment['id']}}" >

                                                                <div class='comment-list'>

                                                                    <div class='bg-img'>

                                                                        <a>

                                                                            <div class='usr-pic-profil' style="background-image:url({{asset(!empty($comment['user']['image'])?$comment['user']['image']:'/images/deaultuser.jpg')}});" ></div>

                                                                        </a>

                                                                    </div>

                                                                    <div class='comment'>

                                                                        <h3>

                                                                            <a>{{$comment['user']['prenom'].' '.$comment['user']['nom']}}</a>

                                                                        </h3>

                                                                        <span><img src='images/clock.png' alt=''> {{$comment['date_ajout']}}</span>

                                                                        <p>{{$comment['detail']}}</p>

                                                                        @if(Auth::check() && ($comment['user']['id']==Auth::user()->id || $post['par']==Auth::user()->id || Auth::user()->user_type==0))

                                                                            <b class='btn_delcmnt' onclick="deleteComment({{$post['post_id']}}, {{$comment['id']}});" >{{config('lang.lbl_delete')[empty(session('lang'))?0:session('lang')]}}</b>

                                                                        @endif

                                                                    </div>

                                                                </div>

                                                            </li>

                                                        @endforeach

                                                    @endif

                                                </ul>

                                            </div>

                                            <div class='post-comment'>

                                                <div class='comment_box'>

                                                    @if(Auth::check())

                                                        <input type='text' id="txt_comentaire_{{$post['post_id']}}" placeholder="{{config('lang.lbl_yourcmnt')[empty(session('lang'))?0:session('lang')]}}" required />

                                                        <button class='btncmnt' onclick="set_comnt({{$post['post_id']}});" >{{config('lang.lbl_commenter')[empty(session('lang'))?0:session('lang')]}}</button>

                                                    @endif

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </main>



    </div><!--theme-layout end-->
    @include('includes.modalLogin')
@endsection


