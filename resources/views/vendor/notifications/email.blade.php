# Halo!

Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.

<x-mail::button :url="$actionUrl" color="primary">
Atur Ulang Password
</x-mail::button>

Jika Anda tidak meminta reset password, abaikan saja email ini dan tidak perlu melakukan tindakan apa pun.

Salam, Humas dan Kerjasama ITERA<br>
{{ config('app.name') }}

<x-slot:subcopy>
Jika Anda mengalami kesulitan mengklik tombol "Atur Ulang Password", salin dan tempel URL di bawah ini ke browser Anda:
<span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
