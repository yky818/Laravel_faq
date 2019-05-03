@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Questions
                        <a class="btn btn-primary float-right" href="{{ route('questions.create') }}">
                            Create a Question
                        </a>
                     </div>
                        <div class="card-body">
                            <div class="col-sm-4">
                                <form class="form-inline vote-form" action="{{ route('home') }}">
                                  <div class="form-group">
                                    <label for="vote">Sort by </label>
                                      <select class="form-control" id="voteFilter" name="sortby">
                                        <option value="topvoted">Top Voted</option>
                                        <option {{ ($sort =='newest' )?'selected':'' }} value="newest">Newest</option>
                                      </select>
                                  </div>
                                </form> 
                            </div>
                            <hr>
                            <div class="card-deck">
                                @if(count($questions))
                                @foreach($questions as $question)
                                    <div class="col-sm-4 d-flex align-items-stretch">
                                        <div class="card mb-3 ">
                                            <div class="card-header">
                                                <h6> {{ $question->user->profile->fname }} {{ $question->user->profile->lname}}</h6>
                                                <small class="text-muted  float-right">
                                                    Updated: {{ $question->created_at->diffForHumans() }}
                                                    <br>
                                                    Answers: {{ $question->answers()->count() }}
                                                </small>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text">{{$question->body}}</p>
                                            </div>
                                            <div class="card-footer">
                                                <p class="card-text">
                                                    
                                                    <div class="vote" >
                                                    <span>{{ $question->votes_count }}</span>
                                                    <i class="far fa-thumbs-up {{ ($question->isVoted)?'active':'' }}" data-id="{{ $question->id }}"></i>
                                                    </div>
                                                    <a class="btn btn-primary float-right" href="{{ route('questions.show', ['id' => $question->id]) }}">
                                                        View
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @else
                                  There are no questions to view, you can  create a question.
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="float-right">
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet"> 
@endsection
@section('js')
    <script type="text/javascript">
        $(document).on('change', '#voteFilter', function(){
            $('.vote-form').submit();
        });
        $(document).on('click', '.vote .fa-thumbs-up', function(){
            var this_ = $(this);
            var qid = this_.data('id');
            $.ajax({
                    type:'POST',
                    dataType:"json",
                    data: {
                     "_token": "{{ csrf_token() }}",
                     "qid": qid,
                    },
                    url:'{{ route("question.vote") }}',
                    success: function(res){
                        if(res.voteStatus){
                            likespan = this_.closest('.vote').find("span");
                            var likes = likespan.text();
                            likespan.text(parseInt(likes)+1);
                            this_.addClass('active');
                        }else{
                            likespan = this_.closest('.vote').find("span");
                            var likes = likespan.text();
                            likespan.text(parseInt(likes)-1);
                             this_.removeClass('active');
                        }
                    }
                });
            });
    </script>
@endsection
