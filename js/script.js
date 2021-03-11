$(window).on("load", function() {
    "use strict";

    

    //  ============= POST PROJECT POPUP FUNCTION =========

    $(".post_project").on("click", function(){
        $(".post-popup.pst-pj").addClass("active");
        $(".wrapper").addClass("overlay");
        return false;
    });
    $(".post-project > a").on("click", function(){
        $(".post-popup.pst-pj").removeClass("active");
        $(".wrapper").removeClass("overlay");
        return false;
    });

    //  ============= POST JOB POPUP FUNCTION =========

    $(".post-jb").on("click", function(){
        $(".post-popup.job_post").addClass("active");
        $(".wrapper").addClass("overlay");
        return false;
    });
    $(".post-project > a").on("click", function(){
        $(".post-popup.job_post").removeClass("active");
        $(".wrapper").removeClass("overlay");
        return false;
    });

    //  ============= SIGNIN CONTROL FUNCTION =========

    $('.sign-control li').on("click", function(){
        var tab_id = $(this).attr('data-tab');
        $('.sign-control li').removeClass('current');
        $('.sign_in_sec').removeClass('current');
        $(this).addClass('current animated fadeIn');
        $("#"+tab_id).addClass('current animated fadeIn');
        return false;
    });

    //  ============= SIGNIN TAB FUNCTIONALITY =========

    $('.signup-tab ul li').on("click", function(){
        var tab_id = $(this).attr('data-tab');
        $('.signup-tab ul li').removeClass('current');
        $('.dff-tab').removeClass('current');
        $(this).addClass('current animated fadeIn');
        $("#"+tab_id).addClass('current animated fadeIn');
        return false;
    });

    //  ============= SIGNIN SWITCH TAB FUNCTIONALITY =========

    $('.tab-feed ul li').on("click", function(){
        var tab_id = $(this).attr('data-tab');
        $('.tab-feed ul li').removeClass('active');
        $('.product-feed-tab').removeClass('current');
        $(this).addClass('active animated fadeIn');
        $("#"+tab_id).addClass('current animated fadeIn');
        return false;
    });

    //  ============= COVER GAP FUNCTION =========

    var gap = $(".container").offset().left;
    $(".cover-sec > a, .chatbox-list").css({
        "right": gap
    });

    //  ============= OVERVIEW EDIT FUNCTION =========

    $(".overview-open").on("click", function(){
        $("#overview-box").addClass("open");
        $(".wrapper").addClass("overlay");
        return false;
    });
    $(".close-box").on("click", function(){
        $("#overview-box").removeClass("open");
        $(".wrapper").removeClass("overlay");
        return false;
    });

    //  ============= EXPERIENCE EDIT FUNCTION =========

    $(".exp-bx-open").on("click", function(){
        $("#experience-box").addClass("open");
        $(".wrapper").addClass("overlay");
        return false;
    });
    $(".close-box").on("click", function(){
        $("#experience-box").removeClass("open");
        $(".wrapper").removeClass("overlay");
        return false;
    });

    //  ============= EDUCATION EDIT FUNCTION =========

    $(".ed-box-open").on("click", function(){
        $("#education-box").addClass("open");
        $(".wrapper").addClass("overlay");
        return false;
    });
    $(".close-box").on("click", function(){
        $("#education-box").removeClass("open");
        $(".wrapper").removeClass("overlay");
        return false;
    });

    //  ============= LOCATION EDIT FUNCTION =========

    $(".lct-box-open").on("click", function(){
        $("#location-box").addClass("open");
        $(".wrapper").addClass("overlay");
        return false;
    });
    $(".close-box").on("click", function(){
        $("#location-box").removeClass("open");
        $(".wrapper").removeClass("overlay");
        return false;
    });

    //  ============= SKILLS EDIT FUNCTION =========

    $(".skills-open").on("click", function(){
        $("#skills-box").addClass("open");
        $(".wrapper").addClass("overlay");
        return false;
    });
    $(".close-box").on("click", function(){
        $("#skills-box").removeClass("open");
        $(".wrapper").removeClass("overlay");
        return false;
    });

    //  ============= ESTABLISH EDIT FUNCTION =========

    $(".esp-bx-open").on("click", function(){
        $("#establish-box").addClass("open");
        $(".wrapper").addClass("overlay");
        return false;
    });
    $(".close-box").on("click", function(){
        $("#establish-box").removeClass("open");
        $(".wrapper").removeClass("overlay");
        return false;
    });

    //  ============= CREATE PORTFOLIO FUNCTION =========

    $(".gallery_pt > a").on("click", function(){
        $("#create-portfolio").addClass("open");
        $(".wrapper").addClass("overlay");
        return false;
    });
    $(".close-box").on("click", function(){
        $("#create-portfolio").removeClass("open");
        $(".wrapper").removeClass("overlay");
        return false;
    });

    //  ============= EMPLOYEE EDIT FUNCTION =========

    $(".emp-open").on("click", function(){
        $("#total-employes").addClass("open");
        $(".wrapper").addClass("overlay");
        return false;
    });
    $(".close-box").on("click", function(){
        $("#total-employes").removeClass("open");
        $(".wrapper").removeClass("overlay");
        return false;
    });

    //  =============== Ask a Question Popup ============

    $(".ask-question").on("click", function(){
        $("#question-box").addClass("open");
        $(".wrapper").addClass("overlay");
        return false;
    });
    $(".close-box").on("click", function(){
        $("#question-box").removeClass("open");
        $(".wrapper").removeClass("overlay");
        return false;
    });


    //  ============== ChatBox ============== 


    $(".chat-mg").on("click", function(){
        $(this).next(".conversation-box").toggleClass("active");
        return false;
    });
    $(".close-chat").on("click", function(){
        $(".conversation-box").removeClass("active");
        return false;
    });

    //  ================== Edit Options Function =================

	/*
    $(".ed-opts-open").on("click", function(){
        $(this).next(".ed-options").toggleClass("active");
        return false;
    });
	*/


    // ============== Menu Script =============

    $(".menu-btn > a").on("click", function(){
        $("nav").toggleClass("active");
        return false;
    });


    //  ============ Notifications Open =============

    $(".not-box-open").on("click", function(){
        $(this).next(".notification-box").toggleClass("active");
    });

    // ============= User Account Setting Open ===========

    $(".user-info").on("click", function(){
        $(this).next(".user-account-settingss").toggleClass("active");
    });

    //  ============= FORUM LINKS MOBILE MENU FUNCTION =========

    $(".forum-links-btn > a").on("click", function(){
        $(".forum-links").toggleClass("active");
        return false;
    });
    $("html").on("click", function(){
        $(".forum-links").removeClass("active");
    });
    $(".forum-links-btn > a, .forum-links").on("click", function(){
        e.stopPropagation();
    });

    //  ============= PORTFOLIO SLIDER FUNCTION =========

    /*$('.profiles-slider').slick({
        slidesToShow: 3,
        slck:true,
        slidesToScroll: 1,
        prevArrow:'<span class="slick-previous"></span>',
        nextArrow:'<span class="slick-nexti"></span>',
        autoplay: true,
        dots: false,
        autoplaySpeed: 2000,
        responsive: [
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
            infinite: true,
            dots: false
          }
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]


    });*/





});

jQuery(document).ready(function ($) {
    $(document).mouseup(function (e) {
        var container = $(".hide-out");
        if (!container.is(e.target) && container.has(e.target).length === 0) { container.hide(); }
    });
	$( "a" ).click(function() 
	{
		if($(this).attr('href')!="" && $(this).attr('href')!="#" && $(this).attr('href')!="javascript:void(0)" && $(this).attr('href').indexOf('#')<=-1){show_loading();}
	});
});

function isNumeric(n) {return !isNaN(parseFloat(n)) && isFinite(n);}
function afiche(id){try{document.getElementById(id).style.display='inline-block';}catch(ex){}}
function showb(id){try{document.getElementById(id).style.display='inline-block';}catch(ex){}}
function showbO(obj){try{obj.style.display='inline-block';}catch(ex){}}
function aficheb(id){try{document.getElementById(id).style.display='block';}catch(ex){}}
function show(id){
    try{
        document.getElementById(id).style.display='block';
    }
    catch(ex){}
}
function showO(obj){try{obj.style.display='block';}catch(ex){}}
function fermer(id){try{document.getElementById(id).style.display='none';}catch(ex){}}
function hide(id){try{document.getElementById(id).style.display='none';}catch(ex){}}
function hideO(obj){try{obj.style.display='none';}catch(ex){}}
function gobg(id){return document.getElementById(id);}
function getobj(id){try{return document.getElementById(id);}catch(ex){return null;}}
function redirect(url){document.location=url;}
function show_loading(){show('dv_loading_glob');}
function hide_loading(){hide('dv_loading_glob');}
function replaceAll(obj, search, replacement) { return obj.replace(new RegExp(search, 'g'), replacement); };
function clear_param(val) { return replaceAll(replaceAll(replaceAll(val, "\\&", "--ANDCOM--"), "\\?", "--APOSTRO--"), "#", "--DYIZ--"); }

function show_pst(obj)
{
	$(obj).next(".ed-options").toggleClass("active");
}

function get_option(pays_id, vile_sel, tbl)
{
	show_loading();
	try{xhrajx=new XMLHttpRequest();} catch(e){try{xhrajx=new ActiveXObject("Microsoft.XMLHTTP");} catch(e1){try{xhrajx=new ActiveXObject("Msxml2.XMLHTTP");} catch(e2){}}}
	xhrajx.onreadystatechange=function()
	{
		if(xhrajx.readyState==4)
		{
			hide_loading();
			if(tbl=="ville"){document.frm_inscr.txt_ville.innerHTML=xhrajx.responseText;}
			if(tbl=="specialite"){document.frm_inscr.txt_specialite.innerHTML=xhrajx.responseText;}
		}
		else{show_loading();}
	}
	xhrajx.open("GET", url_of_site+"ajax/ajax_option.php?param_id="+pays_id+"&param_sel="+vile_sel+"&tbl="+tbl, true);
	xhrajx.send("null");
}
function set_jaime(post_id, pour)
{
	is_jaime=!(getobj('txt_isuserjaime_'+post_id+'_'+pour).value==0);
	show_loading();
	try{xhrjaime=new XMLHttpRequest();} catch(e){try{xhrjaime=new ActiveXObject("Microsoft.XMLHTTP");} catch(e1){try{xhrjaime=new ActiveXObject("Msxml2.XMLHTTP");} catch(e2){}}}
	xhrjaime.onreadystatechange=function()
	{
        console.log(xhrjaime);
		if(xhrjaime.readyState==4)
		{
			hide_loading();
			if(is_jaime)
			{
				getobj('b_nbrjaime_'+post_id+'_'+pour).innerHTML=(parseInt(getobj('b_nbrjaime_'+post_id+'_'+pour).innerHTML)-1);
				getobj('i_icojaime_'+post_id+'_'+pour).style.color="inherit";
				getobj('txt_isuserjaime_'+post_id+'_'+pour).value=0;
			}
			else
			{
				getobj('b_nbrjaime_'+post_id+'_'+pour).innerHTML=(parseInt(getobj('b_nbrjaime_'+post_id+'_'+pour).innerHTML)+1);
				getobj('i_icojaime_'+post_id+'_'+pour).style.color="orange";
				getobj('txt_isuserjaime_'+post_id+'_'+pour).value=1;
			}
		}
		else{show_loading();}
	}
	xhrjaime.open("GET", url_of_site+"ajax/post.php?txt_idposjaime="+post_id+"&txt_jaimeornot="+getobj('txt_isuserjaime_'+post_id+'_'+pour).value, true);
	xhrjaime.send("null");
}
function deletecmntr(post_id, pour, cmnt_id)
{
	show_loading();
	try{xhrjaime=new XMLHttpRequest();} catch(e){try{xhrjaime=new ActiveXObject("Microsoft.XMLHTTP");} catch(e1){try{xhrjaime=new ActiveXObject("Msxml2.XMLHTTP");} catch(e2){}}}
	xhrjaime.onreadystatechange=function()
	{
		if(xhrjaime.readyState==4)
		{
			hide_loading();
			getobj('b_nbrcmntr_'+post_id+'_'+pour).innerHTML=(parseInt(getobj('b_nbrcmntr_'+post_id+'_'+pour).innerHTML)-1);
			hide('li_cmentaire_'+post_id+"_"+cmnt_id+'_'+pour);
		}
		else{show_loading();}
	}
	xhrjaime.open("GET", url_of_site+"ajax/post.php?txt_idcomntdelete="+cmnt_id, true);
	xhrjaime.send("null");
}
function deletepost(post_id, pour, opera)
{
	if(confirm(str_msgconf))
	{
		show_loading();
		try{xhrdelpst=new XMLHttpRequest();} catch(e){try{xhrdelpst=new ActiveXObject("Microsoft.XMLHTTP");} catch(e1){try{xhrdelpst=new ActiveXObject("Msxml2.XMLHTTP");} catch(e2){}}}
		xhrdelpst.onreadystatechange=function()
		{
			if(xhrdelpst.readyState==4)
			{
				hide_loading();
				hide('dv_post_'+post_id+'_'+pour);
			}
			else{show_loading();}
		}
		xhrdelpst.open("GET", url_of_site+"ajax/post.php?txt_idpostdelete="+post_id+"&opeartion="+opera, true);
		xhrdelpst.send("null");
	}
}
function deletefolow(user_id, user_vue, oper, isreload)
{
	show_loading();
	try{xhrdelflw=new XMLHttpRequest();} catch(e){try{xhrdelflw=new ActiveXObject("Microsoft.XMLHTTP");} catch(e1){try{xhrdelflw=new ActiveXObject("Msxml2.XMLHTTP");} catch(e2){}}}
	xhrdelflw.onreadystatechange=function()
	{
		if(xhrdelflw.readyState==4)
		{
			hide_loading();
			if(isreload){location.reload();}
		}
		else{show_loading();}
	}
	xhrdelflw.open("GET", url_of_site+"ajax/post.php?oper="+oper+"&user_vue="+user_vue+"&user_id="+user_id, true);
	xhrdelflw.send("null");
}
function init_abonne(id_ab, str_par, usrid)
{
	opr=Number(getobj('txt_isabonne_'+id_ab).value);
	if(opr==0)
	{
		getobj('li_abonne_'+id_ab).style.color='orange';
		getobj('sp_nbrabone_'+id_ab).innerHTML=(Number(getobj('sp_nbrabone_'+id_ab).innerHTML)+1);
		deletefolow(str_par, usrid, 'flw', false);
		getobj('txt_isabonne_'+id_ab).value=1;
	}
	else
	{
		getobj('li_abonne_'+id_ab).style.color='inherit';
		getobj('sp_nbrabone_'+id_ab).innerHTML=(Number(getobj('sp_nbrabone_'+id_ab).innerHTML)-1);
		deletefolow(str_par, usrid, 'delflw', false);
		getobj('txt_isabonne_'+id_ab).value=0;
	}
	if(getobj('sp_nbrabone_'+id_ab).innerHTML=='0'){getobj('i_icoabone_'+id_ab).className='la la-hand-rock-o';}
	else{getobj('i_icoabone_'+id_ab).className='la la-hand-pointer-o';}
}
function updatepost(post_id, pour)
{
	getobj('txt_post').value=getobj('txt_detail_'+post_id+'_'+pour).value;
	getobj('txt_youtube').value=getobj('txt_youtube_'+post_id+'_'+pour).value;
	if(getobj('txt_youtube_'+post_id+'_'+pour).value!=''){showb('dv_txtyoutube');hide('i_btnyoutube');}
	getobj('txt_updpost_id').value=post_id;
	$("#frm_post").addClass('frm_postupdt');
}
function set_comnt(post_id)
{
	if(getobj('txt_comentaire_'+post_id).value!="")
	{
		getobj('txt_comentaire_'+post_id).style.borderColor="#efefef";
		show_loading();
		try{xhrcmnt=new XMLHttpRequest();} catch(e){try{xhrcmnt=new ActiveXObject("Microsoft.XMLHTTP");} catch(e1){try{xhrcmnt=new ActiveXObject("Msxml2.XMLHTTP");} catch(e2){}}}
		xhrcmnt.onreadystatechange=function()
		{
			if(xhrcmnt.readyState==4)
			{
				hide_loading();
				getobj('txt_comentaire_'+post_id).value='';
				getobj('ul_cmentaire_'+post_id).innerHTML+=xhrcmnt.responseText;
				getobj('b_nbrcmntr_'+post_id).innerHTML=(parseInt(getobj('b_nbrcmntr_'+post_id).innerHTML)+1);
			}
			else{show_loading();}
		}
		xhrcmnt.open("GET", url_of_site+"ajax/post.php?txt_idpost="+post_id+"&txt_comentaire="+getobj('txt_comentaire_'+post_id).value, true);
		xhrcmnt.send("null");
	}
	else{getobj('txt_comentaire_'+post_id).style.borderColor="red";}
}
function valideinscr()
{
	show_loading();
	err=0;
	if(document.frm_inscr.txt_password.value!=document.frm_inscr.txt_repeat_password.value){err=1;}
	else{}
	document.frm_inscr.submit();
}
function load_ajax_post(sprparam)
{
	show('dv_loadingpost');hide('btn_loadplus');
	str_page++;
	try{xhrpst=new XMLHttpRequest();} catch(e){try{xhrpst=new ActiveXObject("Microsoft.XMLHTTP");} catch(e1){try{xhrpst=new ActiveXObject("Msxml2.XMLHTTP");} catch(e2){}}}
	xhrpst.onreadystatechange=function()
	{
		if(xhrpst.readyState==4)
		{
			str_rephtml=xhrpst.responseText;
			hide('dv_loadingpost');
			if(str_rephtml!="")
			{
				getobj('dv_post_ajax').innerHTML+=str_rephtml;
                console.log($(str_rephtml).innerHTML);
				show('btn_loadplus');
			}
		}
	}
	xhrpst.open("GET", url_of_site+"ajax/post.php?operation=getpost&page="+str_page+"&pour="+str_pour+sprparam, true);
	xhrpst.send("null");
}
function selpictpost(obj)
{
	if(obj.value!=""){$("#i_pictpost").addClass("i_selimgactive");}
}
function cancel_post(obj)
{
	getobj('frm_post').className='';getobj('txt_updpost_id').value='';getobj('txt_post').value='';
	$("#i_pictpost").removeClass("i_selimgactive");
	hide('dv_txtyoutube');showb('i_btnyoutube');
}
curnt_msg=0;
function select_lstmsg(num)
{
	getobj('dv_msgprofile_'+num).className='notfication-details dv_selmsgprof';
	getobj('dv_msgprofile_'+curnt_msg).className='notfication-details';
	hide('dv_msgdetail_'+curnt_msg);
	show('dv_msgdetail_'+num);
	curnt_msg=num;
	
}

function search_ajax(strparam, str_for, autrprm) {
    str_filefor = str_for;
    autrprm += "&idaff=" + str_for;
    if (strparam == "") {getobj('idajax_' + str_for).value = ""; getobj('infajax_' + str_for).value = "";hide('dv_cntnt_' + str_for);}
    show('dv_cntnt_' + str_for);
    getobj('dv_cntnt_' + str_for).innerHTML = getobj("dv_loading_glob").innerHTML;
    try { xhrsrch = new XMLHttpRequest(); } catch (e) { try { xhrsrch = new ActiveXObject("Microsoft.XMLHTTP"); } catch (e1) { try { xhrsrch = new ActiveXObject("Msxml2.XMLHTTP"); } catch (e2) { } } }
    xhrsrch.onreadystatechange = function () {
        if (xhrsrch.readyState == 4) {
            getobj('dv_cntnt_' + str_for).innerHTML = xhrsrch.responseText;
        }
    }
    xhrsrch.open("GET", url_of_site + "ajax/get-" + str_filefor + ".php?param=" + clear_param(strparam) + autrprm, true);
    xhrsrch.send("null");
}
function select_line(id, str_for) {
    getobj('idajax_' + str_for).value = id;
    getobj('txtajax_' + str_for).value = getobj('ln_' + str_for + '_' + id).innerHTML.trim();
    hide('dv_cntnt_' + str_for);
}

function set_vue(post_id, pour)
{
    show_loading();
    try{xhrjaime=new XMLHttpRequest();} catch(e){try{xhrjaime=new ActiveXObject("Microsoft.XMLHTTP");} catch(e1){try{xhrjaime=new ActiveXObject("Msxml2.XMLHTTP");} catch(e2){}}}
    xhrjaime.onreadystatechange=function()
    {
       if(xhrjaime.readyState==4)
        {
            hide_loading();
            getobj('b_nbrvue_'+post_id+'_'+pour).innerHTML=(parseInt(getobj('b_nbrvue_'+post_id+'_'+pour).innerHTML)+1);
        }
        else{show_loading();}
    }
    xhrjaime.open("GET", url_of_site+"ajax/post.php?txt_idposvue="+post_id, true);
    xhrjaime.send("null");
}