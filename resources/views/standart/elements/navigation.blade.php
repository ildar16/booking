@if($menu)
    <ul id="nav">
        @include(config('settings.theme').'.elements.customMenuItems',['items'=>$menu->roots()])
    </ul>
@endif
