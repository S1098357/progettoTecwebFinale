@if($complete==1)
    @if($page=='promozioneDesigner')
    <input type="{{$type}}" id="{{$parameter}}" name="{{$parameter}}" value="{{$promo->$parameter}}">
    @elseif($page== 'modificaProfilo')
        <input type="{{$type}}" id="{{$parameter}}" name="{{$parameter}}" value="{{$utente[$parameter]}}">
    @elseif($page== 'modificaStaff')
        <input type="{{$type}}" id="{{$parameter}}" name="{{$parameter}}" value="{{$membro->$parameter}}">
    @elseif($page== 'aziendaDesigner')
        <input type="{{$type}}" id="{{$parameter}}" name="{{$parameter}}" value="{{$a->$parameter}}">
    @endif
@else
    <input type="{{$type}}" id="{{$parameter}}" name="{{$parameter}}">
@endif





@if($type =='date')
    <br><br>
@endif

@if ($errors->first($parameter))
    <ul class="errore">
        @foreach ($errors->get($parameter) as $message)
            {{ $message }}
        @endforeach
    </ul>
@endif

@if($type!='hidden')
<br><br>
@endif
