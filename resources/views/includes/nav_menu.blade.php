<nav class='nav_menu' >
    <?php
    $li_active=$_SERVER['REQUEST_URI']== '/'?'li_active':'';
    $li_active_country=str_contains($_SERVER['REQUEST_URI'],'/country/')?'li_active':'';
    $li_active_city=str_contains($_SERVER['REQUEST_URI'],'/city/')?'li_active':'';
    $li_active_metier=str_contains($_SERVER['REQUEST_URI'],'/metier/')?'li_active':'';
    ?>
    <ul>
        <li class='header-link {{$li_active_metier}}'>
            <a href="{{route('postsMetier',!empty(Auth::user()->metierSpecialite['id'])?Auth::user()->metierSpecialite['id']:0)}}">
                <span><i class='la la-tags' ></i></span>

                <?php
                $metierSpecialite = !empty(Auth::user()->metierSpecialite)?
                    (empty(session('lang'))?
                        0:
                        session('lang')==0?
                            Auth::user()->metierSpecialite->nom_en:
                            (empty(session('lang'))?
                                0:
                                session('lang')==1?
                                    Auth::user()->metierSpecialite->nom_ar:
                                    Auth::user()->metierSpecialite->nom_fr)):
                    config('lang.lbl_mon_domaine')[empty(session('lang'))?0:session('lang')];

                if(strlen($metierSpecialite)>11){
                    $str_pour_special="<span title='".$metierSpecialite."' >".substr($metierSpecialite, 0, 11)."..</span>";
                }else{
                    $str_pour_special = $metierSpecialite;
                }
                echo $str_pour_special;
                ?>
            </a>
        </li>
        <li class='header-link {{$li_active_city}}'>
            <a href="{{route('postsCity',!empty(Auth::user()->city['id'])?Auth::user()->city['id']:0)}}">
                <span><i class='la la-map-marker' ></i></span>
                <span title="{{!empty(Auth::user()->city)?Auth::user()->city->nom_en:''}}">
								{{ !empty(Auth::user()->city)?\Illuminate\Support\Str::limit(Auth::user()->city->nom_en , $limit = 11, $end = '..'):config('lang.lbl_ma_ville')[empty(session('lang'))?0:session('lang')] }}
							</span>
            </a>
        </li>
        <li class='header-link {{$li_active_country}}'>
            <a href="{{route('postsCountry',!empty(Auth::user()->country->id)?Auth::user()->country->id:0)}}">
                <span><i class='la la-flag' ></i></span>
                <span title="{{!empty(Auth::user()->country)?Auth::user()->country->nom_en:''}}">
								{{ !empty(Auth::user()->country)?\Illuminate\Support\Str::limit(Auth::user()->country->nom_en , $limit = 11, $end = '..'):config('lang.lbl_mon_pays')[empty(session('lang'))?0:session('lang')] }}
							</span>
            </a>
        </li>
        <li class='header-link world-link {{$li_active}}'>
            <a href="{{route('home')}}" >
                <span><i class='la la-globe' ></i></span> {{config('lang.lbl_monde')[empty(session('lang'))?0:session('lang')]}}
            </a>
        </li>
    </ul>
</nav><!--nav end-->
