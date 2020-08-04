@extends('mstore/layouts/mstore')
@section('content')
<!-- register -->
<div class="pages section">
    <div class="container">
        <div class="pages-head">
            <h3>REGISTER</h3>
        </div>
        <div class="register">
            <div class="row">
                <form class="col s12" action="registerDo" method="post">
                    @csrf
                    <div class="input-field">
                        <input type="text" name="username" class="validate" placeholder="NAME" required>
                    </div>
                    <div class="input-field">
                        <input type="email" name="useremail" placeholder="EMAIL" class="validate" required>
                    </div>
                    <div class="input-field">
                        <input type="password" name="userpwd" placeholder="PASSWORD" class="validate" required>
                        <b style="color: red">{{session('msg')}}</b>
                    </div>
                    <button class="btn button-default">REGISTER</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end register -->
@endsection