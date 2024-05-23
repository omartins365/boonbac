
<a href="javascript:void(0)" class="btn btn-danger btn-lg my-2 btn-block d-inline-block"
    onclick="window.location.assign('{{ route('oauth.init', ['driver'=>'google']) }}');"><i class="fab fa-google"></i> Sign in with
    Google</a>
<a href="javascript:void(0)" class="btn btn-primary btn-lg my-2 btn-block d-inline-block"
                 onclick="window.location.assign('{{ route('oauth.init', ['driver'=>'facebook']) }}');"
                 style="background-color: #4267b2;border-color: #4267b2;"><i class="fab fa-facebook-square "></i> Sign in with
    Facebook</a>

