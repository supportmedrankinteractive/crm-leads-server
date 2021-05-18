@component('mail::message')
# Welcome  to our MED RANK CRM!

We have created an account for you and you are assigned to {{ $user->profile->company_name }}
Your account details are below:
{{ $user->email }}
{{ $user->plain_password }}

@component('mail::button', ['url' => 'http://app.medrankcrm.com/#/user-guest', 'color' => 'blue'])
Click this button to login
@endcomponent

Thanks,<br>
MED RANK CRM
@endcomponent
