@extends('layouts.app')

@section('content')
<div class="container">
     <div class="row">
        <div class="col-8">
           <img src="/storage/{{ $post->image }}" class="w-100">
        </div>
        <div class="col-4">
          <div>
             <div class="d-flex align-items-center">
               <div class="pr-3">
                    <img src="{{ $post->user->profile->profileImage() }}" class="rounded-circle w-100" style="max-width: 40px;">
                </div>
                  <div>
                     <div class="font-weight-bold">
                        <a href="/profile/{{ $post->user->id }}">
                           <span class="text-dark">{{ $post->user->username }}</span>
                        </a>
                        <a href="#" class="pl-2">Follow</a>
                     </div>
                  </div>
             </div>

             <hr>
             

             <p>
               <span class="font-weight-bold pr-2">
                  <a href="/profile/{{ $post->user->id }}"> 
                     <span class="text-dark">{{ $post->user->username }}</span>
                   </a>
               </span>{{ $post->caption }}
            </p>
            <form action="{{ route('posts.like_1',$post->id) }}" method="POST" id="form-js" class="ml-2">
              @csrf
              <div id="count-js">{{ $post->likes->count() }} Like(s)</div>
              <input type="hidden" id="post-id-js" value="{{ $post->id }}">
              <button type="submit" style="background-color: white; border: none;">
                  <i class="{{$post->heartAnimation()}}" id='heart' style="font-size: 2em"></i>
              </button>
              
             </form>
          </div>
        </div>
     </div>
</div>
@endsection
