<!-- Modal -->
<div class="modal fade" id="modalUpdatePost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{route('updatePost')}}" method="POST" enctype="multipart/form-data" name="modalFrm_post" >
            @csrf
            <input type="hidden" id="updatePostId" name="txt_updpost_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{config('lang.lbl_edit_post')[empty(session('lang'))?0:session('lang')]}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="pull-right" style="margin-bottom: 10px;">
                        <a class="tag" href="#"><span>IXIIR</span><i class="fa fa-fire"></i></a>
                    </div>
                   <textarea name="detail"  dir="rtl" style="min-height: 150px;" class="form-control autosize" id="editPostContent"></textarea>
                    <div class="user-picy" >
                        @if(isset($topicEntity))
                            <i class="fa fa-fire i_btnpicture hidden" id='hashtagModal'></i>
                        @else
                            <i class="fa fa-fire i_btnpicture" id='hashtagModal'></i>
                        @endif



                        <i class='la la-picture-o i_btnpicture' id='i_pictpost' onclick="modalFrm_post.image.click();" ></i>

                        <i class='la la-youtube i_btnpicture' id='i_btnyoutubeModal' onclick="show('dv_txtyoutubeModal');hide('i_btnyoutubeModal');"></i>

                        <div id='dv_txtyoutubeModal' class="hidden" >

                            <input type='text' name='txt_youtube' id='txt_youtube' class='filed_put' placeholder="https://www.youtube.com/embed/xxxxx" />

                            <i class='la la-times i_btnpicture i_btncancelpost'style='background:red;' onclick="hide('dv_txtyoutubeModal');show('i_btnyoutubeModal');"></i>

                        </div>
                        <div id='dv_hashtagModal' class="hidden" >

                            <input type='text' name='txt_hashModal' id='txt_hashModal' class='txt_hash form-control hidden' placeholder="{{config('lang.lbl_hottopic')[empty(session('lang'))?0:session('lang')]}}" />

                            <select name="txt_hash_selectModal" id='txt_hash_selectModal' class="form-control">

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
                            <i class='i_btnpicture i_btncancelpost select hidden' style='background:red;'>{{config('lang.lbl_topic_select')[empty(session('lang'))?0:session('lang')]}}</i>
                        </div>

                        <input type='file' name='image' style='display:none;'/>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{config('lang.lbl_close')[empty(session('lang'))?0:session('lang')]}}</button>
                    <button type="submit" class="dv_btn active submitPostModal">
                        <i class="fa fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

