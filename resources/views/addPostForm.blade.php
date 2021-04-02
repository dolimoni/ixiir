<form action="{{route('addPost')}}" method="POST" enctype="multipart/form-data" name="frm_post" >
    @csrf
    <div class="post-topbar">

        <?php
            if($params['isHotTopic']){
                $txtPostPlaceHolder = config('lang.lbl_your_word')[empty(session('lang'))?0:session('lang')];
            }else{
                $txtPostPlaceHolder = config('lang.lbl_exprimez_vous')[empty(session('lang'))?0:session('lang')];
            }
        ?>

        <textarea name="detail" id="txt_post" class='put_post' placeholder="<?php echo $txtPostPlaceHolder ?>" required ></textarea>

        <input type='hidden' name="txt_updpost_id" id="txt_updpost_id" />

        <div class="user-picy" >
            @if(isset($topicEntity))
            <i class="fa fa-fire i_btnpicture hidden" id='i_btnhashtag'></i>
            @else
            <i class="fa fa-fire i_btnpicture" id='i_btnhashtag'></i>
            @endif



            <i class='la la-picture-o i_btnpicture' id='i_pictpost' onclick="frm_post.image.click();" ></i>

            <i class='la la-youtube i_btnpicture' id='i_btnyoutube' onclick="show('dv_txtyoutube');hide('i_btnyoutube');"></i>

            <div id='dv_txtyoutube' >

                <input type='text' name='txt_youtube' id='txt_youtube' class='filed_put' placeholder="https://www.youtube.com/embed/xxxxx" />

                <i class='la la-times i_btnpicture i_btncancelpost'style='background:red;' onclick="hide('dv_txtyoutube');show('i_btnyoutube');"></i>

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
