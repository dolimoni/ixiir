<!DOCTYPE html>

<html>



<!-- Mirrored from gambolthemes.net/html/workwise/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 13 Sep 2018 11:47:37 GMT -->

<head>

	<meta charset="UTF-8" />

	<title>Ixxiir</title>

	<meta name="description" content="" />

	<meta name="keywords" content="" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<link rel="shortcut icon" href="images/icon.png">

	

	<link rel="stylesheet" type="text/css" href="{{asset('css/animate.css')}}" />

	<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}" />

	<link rel="stylesheet" type="text/css" href="{{asset('css/line-awesome.css')}}" />

	<link rel="stylesheet" type="text/css" href="{{asset('css/line-awesome-font-awesome.min.css')}}" />

	<link rel="stylesheet" type="text/css" href="{{asset('css/font-awesome.min.css')}}" />

	<link rel="stylesheet" type="text/css" href="{{asset('lib/slick/slick.css')}}" />

	<link rel="stylesheet" type="text/css" href="{{asset('lib/slick/slick-theme.css')}}" />

	

	<link rel="stylesheet" type="text/css" href="{{asset('css/responsive.css')}}" />

	<link rel="stylesheet" type="text/css" href="{{asset('css/flatpickr.min.css')}}" />

	<link rel="stylesheet" type="text/css" href="{{asset('css/jquery.range.css')}}" />

	<link rel="stylesheet" type="text/css" href="{{asset('css/jquery.mCustomScrollbar.min.css')}}">

	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

	<link href="https://fonts.googleapis.com/css?family=Tajawal" rel="stylesheet"> 

	<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}" />

	<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>

	

	<!-- Global site tag (gtag.js) - Google Analytics -->

	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-135770010-1"></script>

	<script>

	  window.dataLayer = window.dataLayer || [];

	  function gtag(){dataLayer.push(arguments);}

	  gtag('js', new Date());



	  gtag('config', 'UA-135770010-1');

	</script>




    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
</head>
<body>
  <div class='col-md-12'>
    <div class='posty' id="dv_post_{{$post['post_id']}}">
        <div class='post-bar no-margin'>
        <div class='post_topbar'>
            <div class='usy-dt'>
                <a href="{{route('getProfil',['user_id'=>$post['par']])}}">
                    <div class='usr-pic-profil' style="background-image: url({{asset(!empty($post['userDetails']['image'])?$post['userDetails']['image']:'/images/deaultuser.jpg')}});" >
                       
                    </div> 
                </a>
                <div class='usy-name'>
                    <h3 style='font-size:11pt;padding:0px;' >
                    <a href="{{route('getProfil',['user_id'=>$post['par']])}}">{{isset($post['userDetails'])?$post['userDetails']['prenom']:''}} {{isset($post['userDetails'])?$post['userDetails']['nom']:''}}</a>
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
            <p id="p_detail_{{$post['post_id']}}">
                {{htmlspecialchars($post['detail'])}}
            </p> 
            @if(!empty($post['image']))
            <img src="{{asset($post['image'])}}" style="max-width:100%;margin-bottom:20px;" alt="">
            @endif
            @if(!empty($post['youtube']))
            <iframe style='width:100%;height:400px;border:none;' src="{{$post['youtube']}}" name='iframe1' frameborder='0'  allow='autoplay; encrypted-media' allowfullscreen></iframe>
            @endif
        </div>
      </div>
    </div>
</div>
</body>