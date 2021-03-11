<footer>
			<div class="footy-sec mn no-margin">
				<div class="container">
					<ul>

						<li><a href="{{route('qui-sommes-nous')}}">{{config('lang.lbl_quisomenous')[empty(session('lang'))?0:session('lang')]}}</a></li>

						<li><a href="{{route('conditions')}}">{{config('lang.lbl_condition_utilisation')[empty(session('lang'))?0:session('lang')]}}</a></li>

						<li><a href="mailto:ixiirpress@gmail.com" >ixiirpress@gmail.com</a></li>

						<li><a href="{{route('setLang','fr')}}" >Français</a></li>

						<li><a href="{{route('setLang','ar')}}" >العربية</a></li>

						<li><a href="{{route('setLang','en')}}" >English</a></li>

			      </ul>
				</div>
			</div>
</footer>
		<style>
			.comment_box input{width:auto;}
		.like-com li a, .like-com .sp_cmntlik {width:auto;}
		.frm_postupdt{display:block !important;}
		</style>
		<script>
    			var $disabledResults = $(".js-example-disabled-results");
    	        $disabledResults.select2({
    	        	placeholder: 'Enter the actuality',
    	        	tags: true
    	        }
    	        );
    	        var array=[];
    	        $('#items').select2({
                  ajax: {
                    /*url: '/getTopics',
                    data: function (params) {
                      return {
                        topic: params.topic
                      };
                    },
                    processResults: function (data,params) {
                      var topic=data.topics.filter(topic=>{
                          console.log(params);
                          return topic.topic==params.term;
                      });
                      topic=topic.map(t=>{
                          return t.topic;
                      });
                      return {
                        results: topic
                      };
                    },
                    cache: true,*/
                    tags:true
                  }
                });
				function set_jaime(post_id, pour)
				{
					is_jaime=!($('#txt_isuserjaime_'+post_id).val()==0);
					show_loading();
					try{xhrjaime=new XMLHttpRequest();} catch(e){try{xhrjaime=new ActiveXObject("Microsoft.XMLHTTP");} catch(e1){try{xhrjaime=new ActiveXObject("Msxml2.XMLHTTP");} catch(e2){}}}
					xhrjaime.onreadystatechange=function()
					{
						if(xhrjaime.readyState==4)
						{
							hide_loading();
							if(is_jaime)
							{
								$('#b_nbrjaime_'+post_id).html((parseInt($('#b_nbrjaime_'+post_id).html())-1));
								$('#i_icojaime_'+post_id).css('color',"inherit");
								$('#txt_isuserjaime_'+post_id).attr("value",0);
							}
							else
							{
								$('#b_nbrjaime_'+post_id).html((parseInt($('#b_nbrjaime_'+post_id).html())+1));
								$('#i_icojaime_'+post_id).css('color',"orange");
								$('#txt_isuserjaime_'+post_id).attr("value",1);
							}
						}
						else{show_loading();}
					}
					xhrjaime.open("GET", "/aimerPost?txt_idposjaime="+post_id+"&txt_jaimeornot="+$('#txt_isuserjaime_'+post_id).val(), true);
					xhrjaime.send("null");
				}

				function init_abonne(id_ab, str_par, usrid)
				{
					opr=Number($('#txt_isabonne_'+id_ab).val());
					if(opr==0)
					{
						$('#li_abonne_'+id_ab).css('color',"orange");
						$('#sp_nbrabone_'+id_ab).html((Number($('#sp_nbrabone_'+id_ab).html())+1));
						deletefolow(str_par, usrid, 'flw', false);
						$('#txt_isabonne_'+id_ab).attr("value",1);
					}
					else
					{
						$('#li_abonne_'+id_ab).css('color','inherit');
						$('#sp_nbrabone_'+id_ab).html((Number($('#sp_nbrabone_'+id_ab).html())-1));
						deletefolow(str_par, usrid, 'delflw', false);
						$('#txt_isabonne_'+id_ab).attr("value",0);
					}
					if($('#sp_nbrabone_'+id_ab).html()=='0'){$('#i_icoabone_'+id_ab).attr("class",'la la-hand-rock-o');}
					else{$('#i_icoabone_'+id_ab).attr("class",'la la-hand-pointer-o');}
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
					xhrdelflw.open("GET", "/followPost/"+oper+"/"+user_vue+"/"+user_id, true);
					xhrdelflw.send("null");
				}
				function getVilles(type='')
				{
					show_loading();
					try{xhrdelflw=new XMLHttpRequest();} catch(e){try{xhrdelflw=new ActiveXObject("Microsoft.XMLHTTP");} catch(e1){try{xhrdelflw=new ActiveXObject("Msxml2.XMLHTTP");} catch(e2){}}}
					xhrdelflw.onreadystatechange=function()
					{
						if(xhrdelflw.readyState==4)
						{
							optionsVilles='';
							hide_loading();
							villes=JSON.parse(xhrdelflw.response).villes;
							villes.forEach(ville=>{
								optionsVilles+="<option value='"+ville.id+"'>"+ville.nom_en+"</option>";
							});
							$("#city"+type).html(optionsVilles);
						}
						else{show_loading();}
					}

					xhrdelflw.open("GET", "/getVilles/"+$( "#country"+type +" option:selected" ).val(), true);
					xhrdelflw.send("null");
				}
				/*function updateProfil(e)
				{
				    e.preventDefault();
					show_loading();
					var donnees = $("#updateProfilForm").serialize();
                	$.ajax({
                	    url:"/updateProfil", 
                        data:donnees,
                        type : 'POST',
                        success:function(code_html, statut){
                            hide_loading();
                        }
                	}
                        
                    );
				}*/
				$('#updateProfilForm').submit(function(event) {
                    event.preventDefault(); // Prevent the form from submitting via the browser
                    show_loading();
                    var formdata = new FormData(this);
                    /*var bcrypt = new bcrypt();
                    var salt = bcrypt.genSaltSync(10);
                    formdata.set('password',bcrypt.hashSync($("#passProfil").val(), salt));
                    formdata.set('txt_repeat_password',bcrypt.hashSync($("#passRepeatProfil").val(), salt));*/
                    $.ajax({
                      type: 'POST',
                      url: "/updateProfil",
                      contentType: false,
                      cache: false,
                      processData:false,
                      data: formdata,
                      beforeSend: function() {
                        if($("#passProfil").val()!=$("#passRepeatProfil").val()){
                            alert("Password and password confirmation mismatch");
                            return false;
                        }
                      }
                    }).done(function(data) {
                      hide_loading();
                    }).fail(function(data) {
                      hide_loading();
                    });
                });
				function set_vue(post_id)
				{
					show_loading();
					try{xhrjaime=new XMLHttpRequest();} catch(e){try{xhrjaime=new ActiveXObject("Microsoft.XMLHTTP");} catch(e1){try{xhrjaime=new ActiveXObject("Msxml2.XMLHTTP");} catch(e2){}}}
					xhrjaime.onreadystatechange=function()
					{
						if(xhrjaime.readyState==4)
						{
							hide_loading();
							$('#b_nbrvue_'+post_id).html((parseInt($('#b_nbrvue_'+post_id).html())+1));
							$('#i_icovue_'+post_id).css('color',"orange");
							$('#i_icovue_'+post_id).attr('onclick','');
						}
						else{show_loading();}
					}
					xhrjaime.open("GET", "/vuePost?txt_idposvue="+post_id, true);
					xhrjaime.send("null");
				}
				function set_comnt(post_id)
				{
					if($('#txt_comentaire_'+post_id).val()!="")
					{
						$('#txt_comentaire_'+post_id).css("border-color","#efefef");
						show_loading();
						try{xhrcmnt=new XMLHttpRequest();} catch(e){try{xhrcmnt=new ActiveXObject("Microsoft.XMLHTTP");} catch(e1){try{xhrcmnt=new ActiveXObject("Msxml2.XMLHTTP");} catch(e2){}}}
						xhrcmnt.onreadystatechange=function()
						{
							if(xhrcmnt.readyState==4)
							{
								hide_loading();
								$('#txt_comentaire_'+post_id).attr('value','');
								$('#b_nbrcmntr_'+post_id).html((parseInt($('#b_nbrcmntr_'+post_id).html())+1));
								var postsComment=JSON.parse(xhrcmnt.response).postsComment;
								var user=JSON.parse(xhrcmnt.response).user;
								var comment='<li id="li_cmentaire_"'+post_id+'"_'+postsComment.id+'">\
												<div class="comment-list">\
												<div class="bg-img">\
												<div class="usr-pic-profil" style="background-image:url('+user.image+');" ></div>\
												</div>\
												<div class="comment">\
												<h3><a>'+user.prenom+' '+user.nom+'</a></h3>\
												<span><img src="images/clock.png" alt=""> <?php echo date("d/m/Y H:i"); ?></span>\
												<p>'+$('#txt_comentaire_'+post_id).val()+'</p>\
												<b class="btn_delcmnt" onclick="deleteComment('+post_id+', '+postsComment.id+')" >Supprimer</b>\
												</div>\
												</div>\
												</li>';
								$('#ul_cmentaire_'+post_id).append(comment);				
							}
							else{show_loading();}
						}
						xhrcmnt.open("GET", "/commentPost?txt_idpost="+post_id+"&txt_comentaire="+$('#txt_comentaire_'+post_id).val(), true);
						xhrcmnt.send("null");
					}
					else{$('#txt_comentaire_'+post_id).css("border-color","#efefef");}
				}

				function deleteComment(post_id, cmnt_id)
				{
					show_loading();
					try{xhrjaime=new XMLHttpRequest();} catch(e){try{xhrjaime=new ActiveXObject("Microsoft.XMLHTTP");} catch(e1){try{xhrjaime=new ActiveXObject("Msxml2.XMLHTTP");} catch(e2){}}}
					xhrjaime.onreadystatechange=function()
					{
						if(xhrjaime.readyState==4)
						{
							hide_loading();
							if(xhrjaime.response){
								$('#b_nbrcmntr_'+post_id).html((parseInt($('#b_nbrcmntr_'+post_id).html())-1));
								$('#li_cmentaire_'+post_id+"_"+cmnt_id).remove();
							}
							
						}
						else{show_loading();}
					}
					xhrjaime.open("GET", "/deleteCommentPost?txt_idcomntdelete="+cmnt_id, true);
					xhrjaime.send("null");
				}
				
				function loadPosts(num)
				{
					show_loading();
					try{xhrjaime=new XMLHttpRequest();} catch(e){try{xhrjaime=new ActiveXObject("Microsoft.XMLHTTP");} catch(e1){try{xhrjaime=new ActiveXObject("Msxml2.XMLHTTP");} catch(e2){}}}
					xhrjaime.onreadystatechange=function()
					{
						if(xhrjaime.readyState==4)
						{
							hide_loading();
							if(xhrjaime.response){
							}
							
						}
						else{show_loading();}
					}
					xhrjaime.open("GET", "?numPosts="+num, true);
					xhrjaime.send("null");
				}
				
				function activePosts(btn){
				    $('.dv_btnfilter').removeClass('dv_filteractive');
				    $('.'+btn).addClass('dv_filteractive');
				}
				function updatepost(post_id)
                {
                	$('#txt_post').html($('#p_detail_'+post_id).html());
                	$('#txt_youtube').val($('#txt_youtube_'+post_id).val());
                	if($('#txt_youtube_'+post_id).val()!=''){$('#dv_txtyoutube').show();$('#i_btnyoutube').hide();}
                	$('#txt_updpost_id').val(post_id);
                	$("#frm_post").addClass('frm_postupdt');
                }
                
                function setActive(link){
                    $('.header-link').removeClass('li_active');
                    $('.'+link).addClass('li_active');
                }
                
                $('#i_btnhashtag').click(function(){
                    $('#dv_hashtag').show();
                    $('#dv_hashtag .la-plus-circle').show();
                    $('#dv_hashtag .select').hide();
                    $('#txt_hash_select').show();
                    $('#txt_hash').hide();
                });
                $('#dv_hashtag .la-times').click(function(){
                    $('#dv_hashtag').hide();
                    $('#txt_hash').val("");
                    $("#txt_hash_select[value='']").prop("selected",true);
                    $('#txt_hash_select').prop("required",true);
                    $('#txt_hash').prop("required",false);
                });
                $('#dv_hashtag .la-plus-circle').click(function(){
                    $('#txt_hash_select').hide();
                    $('#txt_hash').show();
                    $('#dv_hashtag .select').show();
                    $(this).hide();
                    $("#txt_hash_select[value='']").prop("selected",true);
                    $('#txt_hash').prop("required",true);
                    $('#txt_hash_select').prop("required",false);
                });
                $('#dv_hashtag .select').click(function(){
                    $('#txt_hash_select').show();
                    $('#txt_hash').hide();
                    $('#dv_hashtag .la-plus-circle').show();
                    $(this).hide();
                    $('#txt_hash').val("");
                    $('#txt_hash_select').prop("required",true);
                    $('#txt_hash').prop("required",false);
                    
                });
                $('.submitPost').click(function(){
                    if($("#dv_hashtag").css('display')=='none'){
                        $("#i_btnhashtag").css('border','2px solid red');
                    }
                });
		</script>
	</body>
	<!--
	<script>'undefined'=== typeof _trfq || (window._trfq = []);'undefined'=== typeof _trfd && (window._trfd=[]),_trfd.push({'tccl.baseHost':'secureserver.net'}),_trfd.push({'ap':'cpsh'},{'server':'a2plcpnl0235'}) // Monitoring performance to make your website faster. If you want to opt-out, please contact web hosting support.
	</script>
	<script src='../../../img1.wsimg.com/tcc/tcc_l.combined.1.0.6.min.js'></script>
	-->
</html>