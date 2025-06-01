@extends('layout.layoutUser')

@section('title')
  <title>Dashboard Groupe</title>
@endsection

@section('js')
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('css/showGroupe.css')}}">
@endsection

@section('content')
<section class="hero">
    <div class="mx-auto">
        <h2 class="text-4xl font-semibold mb-4">{{__('groupe.manage_group')}}</h2>
        <div class="containeur">
            <div class="containeurIner containeurTask">

          </div>
            <div class="containeurIner containeurDiscution">
                <div class="chat">
                  <div class="message-box">
                    <form action="/message/addMessageGroupe" method="POST">
                      @csrf
                      <input type="hidden" name='groupe' value="{{$groupe->id}}">
                      <textarea placeholder="{{__('groupe.enter_message')}}" name='message' type="text"></textarea>
                      <button type="submit">{{__('groupe.send')}}</button>
                    </form>
                  </div>
                  <div class="message-channel">

                  </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
