<form method="POST" enctype="multipart/form-data" >
    @csrf
    <div class="post-topbar">

        <div style="position: relative;">

            <div class="form-group">
                <label for="tag"></label>
                <input placeholder="Titre" type="text" ng-model="topic.tag" class="form-control" id="tag" name="tag" >
                <small id="emailHelp" class="form-text text-muted"></small>
            </div>

             <div class="form-group">
                <label for="topicContent"></label>
                 <textarea placeholder="Contenu" name="topicContent" ng-model="topic.content" class="form-control" id="topicContent"></textarea>
                <small id="emailHelp" class="form-text text-muted"></small>
            </div>


            <div class="form-group">
                <label for="sources"></label>
                <input placeholder="Sources" type="text" name="sources" ng-model="topic.sources" id="sources" class="form-control">
                <small id="emailHelp" class="form-text text-muted"></small>
            </div>


        </div>


        <input type='hidden' name="txt_updpost_id" id="txt_updpost_id" />


        <div class="user-picy" style="visibility: hidden;" >

            <i class='la la-picture-o i_btnpicture' id='i_pictpost' onclick="frm_post.image.click();" ></i>

            <i class='la la-youtube i_btnpicture' id='i_btnyoutube'></i>

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

                    <button ng-click="add()" class='dv_btn active submitPost' >

                        <i class='fa fa-paper-plane' ></i>

                    </button>

                </li>

            </ul>

        </div>

    </div>

</form>
