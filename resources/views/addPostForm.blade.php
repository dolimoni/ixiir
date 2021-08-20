<style>
    @if(!Request::is('profil/*'))


    @endif
    .emojionearea .emojionearea-editor{
        padding: 6px 40px 6px 12px !important;
    }
    .emojionearea-editor{
        text-align: right;
        direction: RTL;
    }


</style>

<form action="{{route('addPost')}}" method="POST" enctype="multipart/form-data" name="frm_post" >
    @csrf
    <div class="post-topbar">

        <?php
            if($params['isHotTopic']){
                $txtPostPlaceHolder = config('lang.lbl_your_word')[empty(session('lang'))?0:session('lang')];
            }else if(!Request::is('profil/*')){
                $txtPostPlaceHolder = "قل كلمتك في الموضوع الساخن، أقل من 70 حرفا بعد كل 7 ساعات";
            }else{
                $txtPostPlaceHolder = config('lang.lbl_exprimez_vous')[empty(session('lang'))?0:session('lang')];
            }
        ?>

        <div style="position: relative;">
            @if(!Request::is('profil/*'))
                <span id="topicLength" style="position: absolute;bottom: 5px;left: 7px;z-index: 10;color: #888;">70</span>
            @endif
            <textarea  maxlength="70" name="detail" id="txt_post" class='put_post' placeholder="<?php echo $txtPostPlaceHolder ?>" required ></textarea>
        </div>


        <input type='hidden' name="txt_updpost_id" id="txt_updpost_id" />
        <input type='hidden' id="from_profile_page" name="from_profile_page" value="{{Request::is('profil/*')}}" />

        <div class="user-picy" >
            @if(isset($topicEntity))
            <i class="fa fa-fire i_btnpicture hidden" id='i_btnhashtag'></i>
            @else
            <i class="fa fa-fire i_btnpicture" id='i_btnhashtag'></i>
            @endif



            <i class='la la-picture-o i_btnpicture' id='i_pictpost' onclick="frm_post.image.click();" ></i>

            <i class='la la-youtube i_btnpicture' id='i_btnyoutube'></i>

            <i class='la la-facebook-official i_btnpicture' id='facebook_logo' onclick="show('facebook_bloc');hide('facebook_bloc');"></i>

            <i class='la la-twitter i_btnpicture' id='twitter_logo' onclick="show('twitter_bloc');hide('twitter_bloc');"></i>

            <div id='dv_txtyoutube' >

                <input type='text' name='txt_youtube' id='txt_youtube' class='filed_put' placeholder="https://www.youtube.com/embed/xxxxx" />

                <i class='la la-times i_btnpicture i_btncancelpost'style='background:red;'></i>

            </div>

            <div id='facebook_bloc'>

                <input type='text' name='facebook_link' id='facebook_link' class='filed_put' placeholder='<iframe src="https://www.facebook.com/plugins/video.php?...' />

                <i class='la la-times i_btnpicture i_btncancelpost'style='background:red;'></i>

            </div>

            <div id='twitter_bloc'>

                <input type='text' name='twitter_link' id='twitter_link' class='filed_put' placeholder='<blockquote class="twitter-tweet"><p lang="en" dir="ltr">...' />

                <i class='la la-times i_btnpicture i_btncancelpost'style='background:red;'></i>

            </div>


            <div id='dv_hashtag' >

                <input type='text' name='txt_hash' id='txt_hash' class='txt_hash form-control' placeholder="{{config('lang.lbl_hottopic')[empty(session('lang'))?0:session('lang')]}}" />

                <select name="txt_hash_select" id='txt_hash_select' class="form-control" required>

                    @if(isset($topicEntity)){
                        <option selected value="{{$topicEntity->id}}">{{$topicEntity->tag}}</option>
                    }@else{
                        <option value="" selected disabled>{{config('lang.lbl_topic')[empty(session('lang'))?0:session('lang')]}}</option>
                        @foreach($topics as $topic)
                            <option value="{{$topic->id}}">{{$topic->tag}}</option>
                        @endforeach
                    }@endif
                </select>

                <i class='la la-times i_btnpicture i_btncancelpost' style='background:red;'></i>
                <i class='la la-plus-circle i_btnpicture i_btncancelpost' style='background:red;'></i>
                <i class='i_btnpicture i_btncancelpost select' style='background:red;'>{{config('lang.lbl_topic_select')[empty(session('lang'))?0:session('lang')]}}</i>
            </div>

            <input type='file' name='image' style='display:none;'/>

        </div>

        <div class="post-st">

            <ul>

                <li>

                    <button type="button" class='dv_btn btn_annuler' style='display:none;' >

                        {{config('lang.lbl_annuler')[empty(session('lang'))?0:session('lang')]}}

                    </button>

                </li>

                <li>

                    <button type="submit" class='dv_btn active submitPost' >

                        <i class='fa fa-paper-plane' ></i>

                    </button>

                </li>

            </ul>

        </div>

    </div>

</form>




<script type="text/javascript">
    $(document).ready(function() {
        $("#txt_post").emojioneArea({
            pickerPosition:"bottom",
            search: false,
            events: {
                emojibtn_click: function (button, event) {
                    controlInput(this,event);
                },keyup: function (editor, event) {
                    controlInput(this,event);
                },keydown: function (editor, event) {
                    controlInput(this,event);
                },paste: function (editor, text,html,event) {
                    @if(!Request::is('profil/*'))
                    var len = this.getText().length;
                    if(len>70)
                    {
                        $(".emojionearea-editor").text($(".emojionearea-editor").text().slice(0,70));
                    }
                    @endif
                },
            }
        });

        function controlInput(element,event){

            @if(!Request::is('profil/*'))
            var cntMaxLength = 70;
            //ne pas controller la longeur du poste dans la page du profile
            if($("#from_profile_page").val()!="1"){
                $('#topicLength').html( cntMaxLength - element.getText().length);

                if (element.getText().length >= cntMaxLength && event.keyCode != 8 &&
                    event.keyCode != 37 && event.keyCode != 38 && event.keyCode != 39 &&
                    event.keyCode != 40) {

                    event.preventDefault();

                    element.setText(function(i, currentHtml) {
                        console.log('currentHtml',currentHtml);
                        return currentHtml.substring(0, cntMaxLength-1);
                    });
                }
            }
            @endif


        }





        function hideFacebook(){
            $("#facebook_bloc").hide();
            $("#facebook_logo").show();
        }

        function hideTwitter(){
            $("#twitter_bloc").hide();
            $("#twitter_logo").show();
        }

        function hideYoutube(){
            $("#dv_txtyoutube").hide();
            $("#i_btnyoutube").show();
        }

        function hideAllVideos(){
            hideFacebook();
            hideTwitter();
            hideYoutube();
        }


        $('#i_btnyoutube').on('click',function (){
            hideAllVideos();
            $('#dv_txtyoutube').show();
            $(this).hide();
        });

        $('#facebook_logo').on('click',function (){
            hideAllVideos();
            $('#facebook_bloc').show();
            $(this).hide();
        });




        $('#twitter_logo').on('click',function (){
            hideAllVideos();
            $('#twitter_bloc').show();
            $(this).hide();
        });

        $('#i_btnyoutube i').on('click',hideYoutube());
        $('#facebook_bloc i').on('click',hideFacebook());
        $('#twitter_bloc i').on('click',hideTwitter());
    });
</script>
