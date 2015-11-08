@if(Auth::check())
@if(!Auth::user()->check_ps)
	@if(isset($ps))
	<a href="/register/ps" class="button d {{ $fixed or '' }}">{{ trans('global.button_d') }}</a>
	@endif
	@if(isset($rv))
	<a href="/recherche" class="button d {{ $fixed or '' }}">RÉSERVER UNE SÉANCE</a>
	@endif
@endif
<a href="#" class="button l {{ $fixed or '' }}" data-jq-dropdown="#dropdown-nav-{{ $d or '1' }}">{{ Auth::user()->prenom }} <div class="anchor"></div></a>
<div id="dropdown-nav-{{ $d or '1' }}" class="jq-dropdown jq-dropdown-anchor-right" style="margin-top:7px;">
    <ul class="jq-dropdown-menu">
    	@if(Auth::user()->check_ps)
        <li><a href="/profil/{{ Auth::id() }}">MON PROFIL</a></li>
        @endif
        <li><a href="/espace">MON ESPACE</a></li>
        <li class="jq-dropdown-divider"></li>
        <li><a href="/logout">SE DECONNECTER</a></li>
    </ul>
</div>
@else
	@if(isset($ps))
	<a href="/register/1" class="button d {{ $fixed or '' }}">{{ trans('global.button_d') }}</a>
	@endif
	<a href="/register" class="button i {{ $fixed or '' }}">{{ trans('global.button_i') }}</a>
	<a href="#" class="button c {{ $fixed or '' }}">{{ trans('global.button_c') }}</a>
@endif