<div class="topHotTopics col-md-12">
    <span class="trending"><i class="fa fa-fire"></i>Top trending hot topics</span>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Hot topic</th>
          <th scope="col" class="wordCol">Word/Comment</th>
        </tr>
      </thead>
      <tbody>
          <?php $i=0; ?>
        @foreach($topTopics as $key=>$topic)
        <tr>

              <td><span class="number">{{$i+1}}.</span>
                  @if(Auth::check())
                      <a href="{{route('hottopicDetail',['topic'=>$topic->tag])}}">{{$topic->tag}}</a>
                  @else
                      <a href="#" data-toggle="modal" data-target="#modalLogin">{{$topic->tag}}</a>
                  @endif

              </td>
              <td class="word">{{$topic->word}}</td>
              <?php $i++; ?>
        </tr>
        @endforeach

      </tbody>
    </table>
    @if(count($topTopics)<=5)
    <span class="more_topTopics">
        @if(Auth::check())
            <a href="{{route('hotTopics')}}">>></a>
        @else
            <a href="#" data-toggle="modal" data-target="#modalLogin">>></a>
        @endif
    </span>
    @endif
</div>
