@extends('layouts.app')

@section('content')
        <div class="container">
          <div class="col-6 offset-1 stories">
            @foreach($utilisateurs as $utilisateur)
            <a href="/profile/{{  $utilisateur->id  }}">                
                <img src="{{ $utilisateur->profile->profileImage() }}" style="width:65px" class="rounded-circle circle"> 
                <p class="sto-p">{{ $utilisateur->truncatex($utilisateur->username,4) }}</p>      
            </a>
            @endforeach
        </div>
     @foreach($posts as $post)
     <div class="row">
        <div class="col-6 offset-1 cadre" >
           <a href="/p/{{ $post->id }}">
             <img src="/storage/{{ $post->image }}" class="w-100 mt-3">
             
            <form action="{{ route('posts.like',$post->id) }}" method="POST" id="form-js" class="ml-2">
              @csrf
              <div id="count-js">{{ $post->likes->count() }} Like(s)</div>
              <input type="hidden" id="post-id-js" value="{{ $post->id }}">
              <button type="submit" style="background-color: white; border: none;">
                  <i class="{{$post->heartAnimation()}}" id='heart' style="font-size: 2em"></i>
              </button>
              
             </form>
             <hr>
             

             <p>
               <span class="font-weight-bold pr-2">
                  <a href="/profile/{{ $post->user->id }}"> 
                     <span class="text-dark">{{ $post->user->username }}</span>
                   </a>
               </span>{{ $post->caption }}
            </p>
           </a>
        </div>
      </div>
      <div class="row pt-2 pb-4">
        <div class="col-6 offset-1">
          <div class="row d-flex">

          </div>
        </div>
     </div>
    @endforeach

    <div class="col-4 suggestion">
      <img src="{{ Auth::user()->profile->profileImage() }}" style="width:55px" class="rounded-circle" >
      <span>
          <a href="/profile/{{ Auth::user()->id }}" style="color:black;margin-left:10px;font-weight:bold;">{{ Auth::user()->username }}</a>
          <p style="color:grey;margin-top:-23px;margin-left:70px;">{{ Auth::user()->name }}</p>
      </span>
      <div class="title">
          <p style="color: grey;">Suggestions For You</p>
          <a href="" style="font-size:0.9em;color:black;">See All</a>
      </div>
      <div class="followers">
          @foreach($utilisateurs as $utilisateur)
          <a href="/profile/{{  $utilisateur->id  }}">                
              <img src="{{ $utilisateur->profile->profileImage() }}" style="width:35px; margin-bottom:8px;" class="rounded-circle"> 
              <p class="sug-p">{{ $utilisateur->username }}
                  <follow-button style="border:none;color:#227DC7;" user-id="{{ $utilisateur->id }}" follows="{{ (auth()->user()) ? auth()->user()->following->contains($utilisateur->id) : false }}"></follow-button>
              </p>
          </a>
          @endforeach
          <div class="folowp">
                  <a class="a" href="#">About .</a>
                  <a class="a" href="#">Help .</a>
                  <a class="a" href="#">Press .</a>
                  <a class="a" href="#">Api .</a>
                  <a class="a" href="#">Jobs .</a>
                  <a class="a" href="#">Privacy .</a>
                  <a class="a" href="#">Terms .</a>
                  <a class="a" href="#">Locations .</a>
                  <a class="a" href="#">Top Accounts .</a>
                  <a class="a" href="#">Hashtags .</a>
                  <a class="a" href="#">Language .</a>
          </div>
      </div>
  </div>

</div>
@endsection
