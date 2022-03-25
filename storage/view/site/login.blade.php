<!doctype html>
<html lang="en" xmlns:th="http://www.thymeleaf.org">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" type="shortcut icon" href="/static/img/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/static/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="/static/css/global.css" />
	<link rel="stylesheet" type="text/css" href="/static/css/login.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
	<title>Echo - 登录</title>
</head>
<body>
	<div class="nk-container">
		<!-- 头部 -->
		@include('site.comm.header')
		<!-- 内容 -->
		<div class="main">
			<div class="container pl-5 pr-5 pt-3 pb-3 mt-3 mb-3">
				<h3 class="text-center text-info border-bottom pb-3">登&nbsp;&nbsp;录</h3>
				<div class="mt-5">
					<div class="form-group row">
						<label for="username" class="col-sm-2 col-form-label text-right">账号:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control"
								   id="email" name="email" placeholder="请输入邮箱" required>
						</div>
					</div>
					<div class="form-group row mt-4">
						<label for="password" class="col-sm-2 col-form-label text-right">密码:</label>
						<div class="col-sm-10">
							<input type="password" class="form-control"
								   id="password" name="password" placeholder="请输入密码" required>
						</div>
					</div>
					<div class="form-group row mt-4">
						<label for="code" class="col-sm-2 col-form-label text-right">验证码:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control"
								   id="code" name="code" placeholder="请输入验证码">
							<input type="hidden" class="form-control"
								   id="token" value="{{$Token}}">
						</div>
						<div class="col-sm-4">
							<img src="/kaptcha" id = "kaptcha"  style="width:100px;height:40px;" class="mr-2"/>
							<a href="javascript:refresh_kaptcha();" class="font-size-12 align-bottom">刷新验证码</a>
						</div>
					</div>
					<div class="form-group row mt-4">
						<div class="col-sm-2"></div>
						<div class="col-sm-10">
							<input type="checkbox" id="rememberMe" name="rememberMe">
							<label class="form-check-label" for="rememberMe">记住我</label>
							<a href="/user/reset-pwd" class="text-danger float-right">忘记密码?</a>
						</div>
					</div>				
					<div class="form-group row mt-4">
						<div class="col-sm-2"></div>
						<div class="col-sm-10 text-center">
							<button id="submit" onclick="login()" class="btn btn-info text-white form-control">立即登录</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- 尾部 -->
		@include('site.comm.footer')
	</div>
	<script src="/static/js/jquery-3.1.0.min.js"></script>
	<script src="/static/js/popper.min.js"></script>
	<script src="/static/js/bootstrap.min.js"></script>
	<script src="/static/js/global.js"></script>
	<script src="/static/js/reset-pwd.js"></script>
	<script src="/static/layer/layer.js"></script>
	<script src="/static/js/jq.cookies.min.js"></script>
	<script>
		function login()
		{
			var email = $("#email").val();
			var password = $("#password").val();
			var code = $("#code").val();
			var token = $("#token").val();


			console.log(token)
			var rememberMe = 0;
			var expire = 0.2
			if ($("#rememberMe").is(':checked')) {
				rememberMe = 1
				expire = 7
			}

			if (email == '') {
				layer.msg("邮箱不能为空");
				return
			}
			if (password == '') {
				layer.msg("密码不能为空");
				return
			}

			if (code == '') {
				layer.msg("验证不能为空");
				return
			}
			$.ajax({
				url: '/user/doLogin',
				type: 'post',
				dataType: 'json',
				data: {
					email: email,
					password: password,
					code: code,
					rememberMe: rememberMe,
					token: token
				},
				success:function (res) {
					if (res.code == 200) {
						layer.msg('登录成功')
						console.log(res.data)
						var options = {
							expires: expire,
							path: '/'
						}
						$.cookie('token', res.data.token+'_'+res.data.email, options)
						$.cookie('username', res.data.username, options)
						$.cookie('header_url', res.data.header_url, options)

						window.setTimeout(function() {
							window.location.href="/"
						},2000);
					}else if (res.code == 405 || res.code == 403) {
						layer.msg(res.msg)
						refresh_kaptcha();
					}else if (res.code == 400) {
						layer.msg('密码错误❌')
						refresh_kaptcha();
					} else {
						layer.msg('未知错误，请稍后重试')
						refresh_kaptcha();
					}
				}
			})
		}
	</script>
</body>
</html>
