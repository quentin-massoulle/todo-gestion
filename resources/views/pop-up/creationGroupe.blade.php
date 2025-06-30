<div class="overlay hidden" id="overlay"></div>

<div class="pop-up hidden" id="pop-upGroupe">
  <button class="close" id="close-popUp">X</button>

  <div class="popup-content">
    <h1 class="text-xl font-semibold text-black mb-6">creation d’un groupe</h1>

    <form action="">
      <div class="input">
        <h1 class="text-xl">Titre du groupe</h1>
        <input type="text" placeholder="Nom du groupe" />
      </div>
      
        <div class="input">
          <h1 class="text-xl">Membre du groupe</h1>
          <select class="select2" name="SelectGroupe" multiple=true style="width: 100%;">
            <@foreach ($users as $user)
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
