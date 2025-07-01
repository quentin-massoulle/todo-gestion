<div class="overlay hidden" id="overlay"></div>

<div class="pop-up hidden" id="pop-upGroupe">
  <button class="close" id="close-popUp">X</button>

  <div class="popup-content">
    @if ($groupeActif)
        <h1 class="text-xl font-semibold text-black mb-6">Modification du groupe</h1>
    @else 
        <h1 class="text-xl font-semibold text-black mb-6">Creation d’un groupe</h1>
    @endif
    <form action="/groupe/store" method="POST">
      @csrf
      <div class="input">
        <h1 class="text-xl">Titre du groupe</h1>
        @if ($groupeActif)
            <input type="hidden" name="idGroupe" value="{{$groupe->id}}">
            <input type="text" name="NameGroupe" value="{{$groupe->nom}}">
        @else
            <input type="text" placeholder="Nom du groupe" name='NameGroupe'/>
        @endif
      </div>
      
      <div class="input">
        <h1 class="text-xl">Membre du groupe</h1>
        <select class="select2" name="SelectGroupe[]" multiple=true style="width: 100%;" 
                @if ($groupeActif)
                    @foreach ($groupe->users as $user)
                        <option value="{{$user->id}}" selected>
                            {{$user->email}}
                        </option>
                    @endforeach
                @endif>
          @foreach ($users as $user)
              <option value="{{$user->id}}">
                  {{$user->email}}
              </option>
          @endforeach
        </select>
      </div>
        

      <button type="submit">cree le groupe</button>
    </form>
  </div>
</div>
