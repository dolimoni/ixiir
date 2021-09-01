dolimoni.controller('TopicController',['$scope','topicService',function($scope,topicService){
    var vm=$scope;
    vm.topic = {};


    vm.add = function () {

        vm.disableAdd = true;
        topicService.add(vm.topic).then(function success(data) {

            vm.disableAdd = false;
            if(data.data.status=="success"){
                location.reload();
            }else{
                alert(data.data.msg);
            }

        });
    };


}]);
