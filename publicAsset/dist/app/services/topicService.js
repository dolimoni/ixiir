dolimoni.service('topicService',function($http){


    this.add=function (topic){

        var data = $.param({
            topic: 'topic'
        });

        return $http({
            method: 'POST',
            data:data,
            url: ADD_TOPIC_URL,
            headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}

        });
    };

});
