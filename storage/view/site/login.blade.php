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
				<form class="mt-5" method="post" th:action="/login">
					<div class="form-group row">
						<label for="username" class="col-sm-2 col-form-label text-right">账号:</label>
						<div class="col-sm-10">
							<input type="text" th:class="|form-control ${usernameMsg != null ? 'is-invalid' : ''}|"
								   th:value="${param.username}"
								   id="username" name="username" placeholder="请输入您的账号!" required>
							<div class="invalid-feedback" th:text="${usernameMsg}"></div>
						</div>
					</div>
					<div class="form-group row mt-4">
						<label for="password" class="col-sm-2 col-form-label text-right">密码:</label>
						<div class="col-sm-10">
							<input type="password" th:class="|form-control ${passwordMsg != null ? 'is-invalid' : ''}|"
								   th:value="${param.password}"
								   id="password" name="password" placeholder="请输入您的密码!" required>
							<div class="invalid-feedback" th:text="${passwordMsg}"></div>
						</div>
					</div>
					<div class="form-group row mt-4">
						<label for="code" class="col-sm-2 col-form-label text-right">验证码:</label>
						<div class="col-sm-6">
							<input type="text" th:class="|form-control ${codeMsg != null ? 'is-invalid' : ''}|"
								   id="code" name="code" placeholder="请输入验证码!">
							<div class="invalid-feedback" th:text="${codeMsg}"></div>
						</div>
						<div class="col-sm-4">
							<img th:src="@{/kaptcha}" id = "kaptcha"  style="width:100px;height:40px;" class="mr-2"/>
							<a href="javascript:refresh_kaptcha();" class="font-size-12 align-bottom">刷新验证码</a>
						</div>
					</div>
					<div class="form-group row mt-4">
						<div class="col-sm-2"></div>
						<div class="col-sm-10">
							<input type="checkbox" id="rememberMe" name="rememberMe"
								   th:checked="${rememberMe}">
							<label class="form-check-label" for="rememberMe">记住我</label>
							<a href="/reset-pwd" class="text-danger float-right">忘记密码?</a>
						</div>
					</div>				
					<div class="form-group row mt-4">
						<div class="col-sm-2"></div>
						<div class="col-sm-10 text-center">
							<button type="submit" class="btn btn-info text-white form-control">立即登录</button>
						</div>
					</div>
				</form>				
			</div>
		</div>

		<!-- 尾部 -->
		@include('site.comm.footer')
	</div>
	<script th:src="/static/js/jquery-3.1.0.min.js}"></script>
	<script th:src="/static/js/popper.min.js}"></script>
	<script th:src="/static/js/bootstrap.min.js}"></script>
	<script th:src="/static/js/global.js}"></script>
	<script>
		function refresh_kaptcha() {
			var path = CONTEXT_PATH + "/kaptcha?p=" + Math.random();
			$("#kaptcha").attr("src", path);
		}
	</script>
</body>
</html>
