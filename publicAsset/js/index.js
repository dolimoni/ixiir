$( document ).ready(function() {
    $('.ed-opts b').on("click", function(){
        var postId = $(this).attr('data-post');
        var content = $(this).attr('data-content');
        var dataTagName = $(this).attr('data-tag-name');
        var dataTagId = $(this).attr('data-tag-id');
        $('#editPostContent').val(content);
        $('#modalUpdatePost a span').text(dataTagName);
        if(content.length<=70){
            $('#editPostContent').attr('maxlength','70');
        }else{
            $('#editPostContent').attr('maxlength','10000');
        }
        $('#updatePostId').val(postId);
        if(dataTagId !== undefined){
            $("#txt_hash_selectModal").val(dataTagId);
        }
    });

    $('#txt_hash_selectModal').on('change',function (){
        var optionSelected = $(this).find("option:selected");
        var valueSelected  = optionSelected.val();
        var textSelected   = optionSelected.text();
        $('#modalUpdatePost a span').text(textSelected);
    });

    $('#txt_hashModal').on('keyup',function (){
        var dInput = this.value;
        $('#modalUpdatePost a span').text(dInput);
    });

    $('.showMore').on('click',function (){
        var postId = $(this).attr('data-post-id');
        console.log(postId);
        console.log('element', $('.social-media-share[data-post-id='+postId+']'));
        $('.social-media-share[data-post-id='+postId+']').show();
    });

    $('#modalUpdatePost .submitPostModal').click(function(){
        var optionSelected = $('#txt_hash_selectModal').find("option:selected").val();
        if(optionSelected === ''){
            alert('You should select a topic');
        }else{
            console.log(optionSelected);
        }
    });


    function initPage(){
        autosize();
        function autosize(){
            textarea = document.querySelector("#editPostContent");
            textarea.addEventListener('input', autoResize, false);

            function autoResize() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            }
        }
    }

    initPage();
});


