@extends('layouts.app')

@section('content')
<div id="login" class="container">
  <div style="height: 80vh;" class="row justify-content-center align-items-center">
    <div class="col-md-5">
      <div class="card shadow">
        <div class="card-header">
          注册
        </div>
        <div class="card-body">
          <form method="post" action="">
            @csrf
            @if ($errors->any())
            <div class="alert alert-danger">
              <ul style="margin-bottom: 0; padding-left: 10px;">
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
              </ul>
            </div>
            @endif
            <div class="form-group">
              <label>邮箱</label>
              <input type="email" name="email" class="form-control">
            </div>
            <div class="form-group">
              <label>名称</label>
              <input type="text" name="name" class="form-control">
            </div>
            <div class="form-group">
              <label>密码</label>
              <input type="password" name="password" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">注册</button>
            <button type="button" class="btn btn-success" onclick="location.href='/'">登录</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
