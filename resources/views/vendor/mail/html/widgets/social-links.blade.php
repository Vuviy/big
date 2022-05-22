<table class="es-table-not-adapt es-social" cellspacing="0" cellpadding="0" role="presentation">
    <tr>
        @foreach($socials as $name => $link)
            @switch($name)
                @case('instagram')
                <td valign="top" align="center" @if(!$loop->last) class="es-p15r" @endif>
                    <a target="_blank" href="{{ $link }}">
                        <img title="{{ ucfirst($name) }}"
                             src="{{ asset('mail/instagram-logo-white.png') }}"
                             alt="{{ ucfirst($name) }}" width="32" height="32"/>
                    </a>
                </td>
                @break
                @case('facebook')
                <td valign="top" align="center" @if(!$loop->last) class="es-p15r" @endif>
                    <a target="_blank" href="{{ $link }}">
                        <img title="{{ ucfirst($name) }}"
                             src="{{ asset('mail/facebook-logo-white.png') }}"
                             alt="{{ ucfirst($name) }}" width="32" height="32"/>
                    </a>
                </td>
                @break
            @endswitch
        @endforeach
    </tr>
</table>
