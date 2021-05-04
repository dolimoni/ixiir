besys.controller('IndexTopicController',['$scope','BASE_URL','topicService',function($scope,BASE_URL,topicService){
    var vm=$scope;
    vm.baseUrl=BASE_URL;
    vm.topics = js_topics;
    vm.deleteTopic = function (topic){
        var text = "Vous voulez vraiment supprimer ce topic ?";
        //swal({title: "Erreur", text: text, type: "warning", showConfirmButton: true});


        swal({
            title: "Attention",
            text: text,
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonText: 'Confirmer',
            cancelButtonText: 'Annuler',
            dangerMode: false,
        }, function () {
            topic.loading = true;
            topicService.delete(topic.id).then(function success(data) {

                location.reload();

                /*if(data.data.status=="success"){
                    location.reload();
                }else{
                    alert(data.data.msg);
                }*/

            });
        });
    }
}]);
