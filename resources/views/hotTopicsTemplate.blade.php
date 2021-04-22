<div class="topHotTopics col-md-12">
    <span class="trending"><i class="fa fa-fire"></i>{{config('lang.lbl_top_trending_topics')[empty(session('lang'))?0:session('lang')]}}</span>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">{{config('lang.lbl_hot_topic')[empty(session('lang'))?0:session('lang')]}}</th>
          <th scope="col" class="wordCol">{{config('lang.lbl_word_comment')[empty(session('lang'))?0:session('lang')]}}</th>
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
