<!doctype html>
<html lang="en" xmlns:th="http://www.thymeleaf.org" xmlns:sec="http://www.thymeleaf.org/extra/spring-security">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" type="shortcut icon" href="/static/img/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/static/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="/static/css/global.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
	<title>Echo - 首页</title>
</head>
<body>
	<div class="nk-container">
		<!-- 头部 -->
		@include('site.comm.header')
		<!-- 内容 -->
		<div class="main">
			<div class="container">
				<div class="position-relative">
					<!-- 筛选条件 -->
					<ul class="nav nav-tabs mb-3">
						<li class="nav-item">
							<a th:class="|nav-link ${orderMode==0 ? 'active' : ''}|" th:href="@{/index(orderMode=0)}"><i class="bi bi-lightning"></i> 最新</a>
						</li>
						<li class="nav-item">
							<a th:class="|nav-link ${orderMode==1 ? 'active' : ''}|" th:href="@{/index(orderMode=1)}"><i class="bi bi-hand-thumbs-up"></i> 最热</a>
						</li>
					</ul>
<!--					<button type="button" class="btn btn-primary btn-sm position-absolute rt-0"-->
<!--							data-toggle="modal" data-target="#publishModal"-->
<!--							th:if="${loginUser != null}"><i class="bi bi-plus-square"></i> 我要发布</button>-->

					<a href="/discuss/publish" th:if="${loginUser != null}">
						<button type="button" class="btn btn-primary btn-sm position-absolute rt-0">
							<i class="bi bi-plus-square"></i> 我要发布
						</button>
					</a>

				</div>
				<!-- 弹出框 -->
<!--				<div class="modal fade" id="publishModal" tabindex="-1" role="dialog" aria-labelledby="publishModalLabel" aria-hidden="true">-->
<!--					<div class="modal-dialog modal-lg" role="document">-->
<!--						<div class="modal-content">-->
<!--							<div class="modal-header">-->
<!--								<h5 class="modal-title" id="publishModalLabel">新帖发布</h5>-->
<!--								<button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--									<span aria-hidden="true">&times;</span>-->
<!--								</button>-->
<!--							</div>-->
<!--							<div class="modal-body">-->
<!--								<form>-->
<!--									<div class="form-group">-->
<!--										<label for="recipient-name" class="col-form-label">标题：</label>-->
<!--										<input type="text" class="form-control" id="recipient-name">-->
<!--									</div>-->
<!--									<div class="form-group">-->
<!--										<label for="message-text" class="col-form-label">正文：</label>-->
<!--										<textarea class="form-control" id="message-text" rows="15"></textarea>-->
<!--									</div>-->
<!--								</form>-->
<!--							</div>-->
<!--							<div class="modal-footer">-->
<!--								<button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>-->
<!--								<button type="button" class="btn btn-primary" id="publishBtn">发布</button>-->
<!--							</div>-->
<!--						</div>-->
<!--					</div>-->
<!--				</div>-->
				<!-- 提示框 -->
				<div class="modal fade" id="hintModal" tabindex="-1" role="dialog" aria-labelledby="hintModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="hintModalLabel">提示</h5>
							</div>
							<div class="modal-body" id="hintBody"></div>
						</div>
					</div>
				</div>

				<!-- 帖子列表 -->
				<ul class="list-unstyled">
					<li class="media pb-3 pt-3 mb-3 border-bottom" th:each="map:${discussPosts}">
						<a th:href="@{|/user/profile/${map.user.id}|}">
							<img th:src="${map.user.headerUrl}" class="mr-4 rounded-circle" alt="用户头像" style="width:50px;height:50px;">
						</a>
						<div class="media-body">
							<h6 class="mt-0 mb-3">
								<a th:href="@{|/discuss/detail/${map.post.id}|}" th:utext="${map.post.title}"></a>
								<span class="badge badge-secondary bg-danger" th:if="${map.post.type==1}"
								   style="font-weight: 500; color: #f85959; background-color: rgba(248,89,89,0.1) !important;">顶</span>
								<span class="badge badge-secondary bg-primary" th:if="${map.post.status==1}"
								   style="font-weight: 500; color: #3c8cff; background-color: rgba(60,140,255,0.1) !important;">精</span>
							</h6>
							<div class="text-muted font-size-12">
								<u class="mr-3" th:utext="${map.user.username}"></u> 发布于 <b th:text="${#dates.format(map.post.createTime,'yyyy-MM-dd HH:mm:ss')}"></b>
								<ul class="d-inline float-right">
									<li class="d-inline ml-2">赞 <span th:text="${map.likeCount}"></span></li>
									<li class="d-inline ml-2">|</li>
									<li class="d-inline ml-2">回帖 <span th:text="${map.post.commentCount}"></span></li>
								</ul>
							</div>
						</div>
					</li>
				</ul>
				<!--分页 -->
				<nav class="mt-5" th:if = "${page.rows>0}" th:fragment="pagination">
					<ul class="pagination justify-content-center">
						<li class="page-item">
							<a class="page-link" th:href="@{${page.path}(current=1)}">首页</a>
						</li>
						<li th:class="|page-item ${page.current==1?'disabled':''}|">
							<a class="page-link" th:href="@{${page.path}(current=${page.current-1})}">上一页</a>
						</li>
						<!--numbers.sequence 生成一个 page.from 到 page.to 的连续整数数组-->
						<li th:each="i:${#numbers.sequence(page.from,page.to)}" th:class="|page-item ${i==page.current? 'active' : ''}|" >
							<a class="page-link" th:href="@{${page.path}(current=${i})}" th:text="${i}"></a>
						</li>
						<li th:class="|page-item ${page.current==page.total ? 'disabled':''}|">
							<a class="page-link" th:href="@{${page.path}(current=${page.current+1})}">下一页</a>
						</li>
						<li class="page-item">
							<a class="page-link" th:href="@{${page.path}(current=${page.total})}">末页</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>

		<!-- 尾部 -->
		@include('site.comm.footer')
	</div>

	<script src="/static/js/jquery-3.1.0.min.js"></script>
	<script src="/static/js/popper.min.js"></script>
	<script src="/static/js/bootstrap.min.js"></script>
	<script src="/static/js/global.js"></script>
	<script src="/static/js/index.js"></script>
	<script src="/static/js/jq.cookies.min.js"></script>
	<script src="/static/layer/layer.js"></script>
	<script>
		console.log($.cookie('token'))
		function logout($method)
		{
			$.ajax({
				url: $method,
				type: 'post',
				dataType: 'json',
				data: {
					token: $.cookie('token')
				},
				success:function (res) {
					if (res.code == 200) {
						$.cookie('token', null, { path: '/' })
						$.cookie('username', null, { path: '/' })
						$.cookie('header_url', null, { path: '/' })
						layer.msg('退出成功')
					}else {
						layer.msg('未知错误')
					}
					window.setTimeout(function() {
						window.location.href="/"
					},2000);
				}
			})
		}
	</script>
</body>
</html>