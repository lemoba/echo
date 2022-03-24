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
	<title>Echo - 注册</title>
</head>
<body>
	<div class="nk-container">
		<!-- 头部 -->
		@include('site.comm.header')
		<!-- 内容 -->
		<div class="main">
			<div class="container pl-5 pr-5 pt-3 pb-3 mt-3 mb-3">
				<h3 class="text-center text-info border-bottom pb-3">注&nbsp;&nbsp;册</h3>
				<div class="mt-5">
					<div class="form-group row">
						<label for="username" class="col-sm-2 col-form-label text-right">账号:</label>
						<div class="col-sm-10">
							<input type="text" id="username"
								   class="form-control"
								   value="admin@admin.com"
								   name = "username" placeholder="请输入您的账号!" required>
							<!--错误提示消息, 当 上面的 input class = is-invalid 时显示-->
							<div class="invalid-feedback" text="${usernameMsg}"></div>
						</div>
					</div>
					<div class="form-group row mt-4">
						<label for="password" class="col-sm-2 col-form-label text-right">密码:</label>
						<div class="col-sm-10">
							<input type="password" id="password"
								   class="form-control"
								   value="admin"
								   name = "password" placeholder="请输入您的密码!" required>
							<!--错误提示消息-->
							<div class="invalid-feedback" text=""></div>
						</div>
					</div>

					<div class="form-group row mt-4">
						<label for="code" class="col-sm-2 col-form-label text-right">验证码:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control"
								   id="code" name="code" placeholder="请输入验证码!">
							<div class="invalid-feedback" text="${codeMsg}"></div>
						</div>
						<div class="col-sm-4">
							<img src="/kaptcha" id = "kaptcha"  style="width:100px;height:40px;" class="mr-2"/>
							<a href="javascript:refresh_kaptcha();" class="font-size-12 align-bottom">刷新验证码</a>
						</div>
					</div>
					<div class="form-group row mt-4">
						<div class="col-sm-2"></div>
						<div class="col-sm-10 text-center">
							<button type="submit" class="btn btn-info text-white form-control">立即注册</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- 尾部 -->
		@include('site.comm.footer')
	</div>

	<script src="/static/js/jquery-3.1.0.min.js"></body>
	<script src="/static/js/popper.min.js"></script>
	<script src="/static/js/bootstrap.min.js"></script>
	<script src="/static/js/global.js"></script>
	<script src="/static/js/register.js"></script>
	<script src="/static/js/reset-pwd.js"></script>
	<script src="/static/layer/layer.js"></script>
	<script>
		layer.msg('hello');
	</script>
</body>
</html>
