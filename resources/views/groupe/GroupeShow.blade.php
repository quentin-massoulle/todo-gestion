@extends('layout.layoutUser')

@section('title')
  <title>Dashboard Groupe</title>
@endsection

@section('js')
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('css/showGroupe.css') }}">
@endsection

@section('content')
<section class="hero">
    <div class="mx-auto">
        <h2 class="text-4xl font-semibold mb-4">gestion du groupe</h2>
        <div class="containeur">
            <div class="containeurIner containeurTask">

          </div>
            <div class="containeurIner containeurDiscution">
                <div class="chat">
                  <div class="message-box">
                    <textarea style="resize: none" name="" id="" ></textarea>
                  </div>
                  <div class="message-channel">

                  </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
