@php
    $class = $class ?? false ?: 'es-content-body';
@endphp
<table cellpadding="0" cellspacing="0" class="es-content" align="center">
    <tr>
        <td align="center">
            <table class="{{ $class }}" width="600" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    {{ $slot }}
                </tr>
            </table>
        </td>
    </tr>
</table>
