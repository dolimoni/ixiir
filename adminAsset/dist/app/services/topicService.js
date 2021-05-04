
besys.service('topicService',function($http,BASE_URL){

    this.delete=function (id){
        var request='/admin/api/topicController/delete/'+id;

        var data = $.param({
            id: id
        });



        console.log(data);

        return $http.get(request,
            {
                id: id,
            });

        return $http({
            method: 'post',
            data:data,
            url: BASE_URL+request,
            headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}

        });
    };

});
