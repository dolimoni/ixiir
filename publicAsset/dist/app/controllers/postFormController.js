dolimoni.controller('PostFormController',['$scope',function($scope){
    var vm=$scope;
    vm.topic = "";
    vm.topicLength = 70;
    vm.controlPost = function (){
        vm.topicLength = 70 - vm.topic.length;
    }




}]);
