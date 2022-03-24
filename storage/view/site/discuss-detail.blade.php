<!doctype html>
<html lang="en" xmlns:th="http://www.thymeleaf.org" xmlns:sec="http://www.thymeleaf.org/extra/spring-security">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" type="shortcut icon" href="/static/img/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/static/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="/static/css/global.css" />
	<link rel="stylesheet" type="text/css" href="/static/css/discuss-detail.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

	<link rel="stylesheet" type="text/css" href="/static/editor-md/css/editormd.css" />
	<title>Echo - 帖子详情</title>
</head>
<body>
	<div class="nk-container" >
		<!-- 头部 -->
		@include('header')

		<!-- 内容 -->
		<div class="main">
			<!-- 帖子详情 -->
			<div class="container">
				<!-- 标题 -->
				<h5 class="mb-4">
					<i class="bi bi-award" style="color: rgb(119, 84, 223)"></i>
					<span th:utext="${post.title}"></span>
					<div class="float-right">
						<input type="hidden" id="postId" th:value="${post.id}">
						<input type="hidden" id="postType" th:value="${post.type}">
						<button type="button" th:class="|btn ${post.type == 0 ? 'btn-danger' : 'btn-info'}  btn-sm|" id="topBtn"
						 		th:text="${post.type == 0 ? '置顶' : '取消置顶'}"
								sec:authorize="hasAnyAuthority('moderator')">
						</button>
						<button type="button" class="btn btn-danger btn-sm" id="wonderfulBtn"
								th:disabled="${post.status == 1}" sec:authorize="hasAnyAuthority('moderator')">加精</button>
						<button type="button" class="btn btn-danger btn-sm" id="deleteBtn"
								th:disabled="${post.status == 2}" sec:authorize="hasAnyAuthority('admin')">删除</button>
					</div>
				</h5>
				<!-- 作者 -->
				<div class="media pb-3 border-bottom">
					<a th:href="@{|/user/profile/${user.id}|}">
						<img th:src="${user.headerUrl}" class="align-self-start mr-4 rounded-circle user-header" alt="用户头像" >
					</a>
					<div class="media-body">
						<div class="mt-0 text-warning" th:utext="${user.username}"></div>
						<div class="text-muted mt-3">
							发布于 <b th:text="${#dates.format(post.createTime, 'yyyy-MM-dd HH:mm:ss')}"></b>
							<ul class="d-inline float-right">
								<li class="d-inline ml-2">
									<a href="javascript:;" th:onclick="|like(this, 1, ${post.id}, ${post.userId}, ${post.id});|" class="text-primary">
										<b th:text="${likeStatus == 1 ? '已赞' : '赞'}"></b> <i th:text="${likeCount}"></i>
									</a>
								</li>
								<li class="d-inline ml-2">|</li>
								<li class="d-inline ml-2"><a href="#replyform" class="text-primary">回帖 <i th:text="${post.commentCount}"></i></a></li>
							</ul>
						</div>
					</div>
				</div>	
				<!-- 正文 -->
				<div class="mt-4 mb-3 content" id="md-content">
            		<textarea style="display:none;" th:utext="${post.content}"></textarea>
				</div>

				<!--<div class="mt-4 mb-3 content" id = "md-content" ></div>-->
			</div>
			<!-- 回帖 -->
			<div class="container mt-3">
				<!-- 回帖数量 -->
				<div class="row">
					<div class="col-8">
						<h6><b class="square"></b> <i th:text="${post.commentCount}"></i>条回帖</h6>
					</div>
					<div class="col-4 text-right">
						<a href="#replyform" class="btn btn-primary btn-sm">&nbsp;&nbsp;回&nbsp;&nbsp;帖&nbsp;&nbsp;</a>
					</div>
				</div>
				<!-- 回帖列表 -->
				<ul class="list-unstyled mt-4">
					<li class="media pb-3 pt-3 mb-3 border-bottom" th:each="cvo:${comments}">
						<a th:href="@{|/user/profile/${cvo.user.id}|}">
						<img th:src="${cvo.user.headerUrl}" class="align-self-start mr-4 rounded-circle user-header" alt="用户头像" >
						</a>
						<div class="media-body">
							<div class="mt-0">
								<span class="font-size-12 text-success" th:utext="${cvo.user.username}"></span>
								<span class="badge badge-secondary float-right floor">
									<!-- 楼数 -->
									<i th:text="${page.offset + cvoStat.count}"></i> 楼
								</span>
							</div>
							<div class="mt-2" th:utext="${cvo.comment.content}"></div>
							<div class="mt-4 text-muted font-size-12">
								<span>发布于 <b th:utext="${#dates.format(cvo.comment.createTime, 'yyyy-MM-dd HH:mm:ss')}"></b></span>
								<ul class="d-inline float-right">
									<li class="d-inline ml-2">
										<a href="javascript:;" th:onclick="|like(this, 2, ${cvo.comment.id}, ${cvo.comment.userId}, ${post.id});|" class="text-primary">
											<b th:text="${cvo.likeStatus == 1 ? '已赞' : '赞'}"></b>(<i th:text="${cvo.likeCount}"></i>)
										</a>
									</li>
									<li class="d-inline ml-2">|</li>
									<li class="d-inline ml-2"><a href="#" class="text-primary">回复(<i th:text="${cvo.replyCount}"></i>)</a></li>
								</ul>
							</div>
							<!-- 回复列表 -->
							<ul class="list-unstyled mt-4 bg-gray p-3 font-size-12 text-muted">
								<li class="pb-3 pt-3 mb-3 border-bottom" th:each="rvo:${cvo.replys}">
									<div>
										<span th:if="${rvo.target==null}">
											<a class="text-info" th:utext="${rvo.user.username}" th:href="@{|/user/profile/${rvo.user.id}|}"></a>:&nbsp;&nbsp;
										</span>
										<span th:if="${rvo.target!=null}">
											<a class="text-info" th:text="${rvo.user.username}" th:href="@{|/user/profile/${rvo.user.id}|}"></a> 回复
											<a class="text-info" th:utext="${rvo.target.username}" th:href="@{|/user/profile/${rvo.target.id}|}"></a>:&nbsp;&nbsp;
										</span>
										<span th:text="${rvo.reply.content}"></span>
									</div>
									<div class="mt-3">
										<span th:utext="${#dates.format(rvo.reply.createTime, 'yyyy-MM-dd HH:mm:ss')}"></span>
										<ul class="d-inline float-right">
											<li class="d-inline ml-2">
												<a href="javascript:;" th:onclick="|like(this, 2, ${rvo.reply.id}, ${rvo.reply.userId}, ${post.id});|" class="text-primary">
													<b th:text="${rvo.likeStatus == 1 ? '已赞' : '赞'}"></b>(<i th:text="${rvo.likeCount}"></i>)
												</a>
											</li>
											<li class="d-inline ml-2">|</li>
											<li class="d-inline ml-2"><a th:href="|#huifu-${rvoStat.count}|" data-toggle="collapse" class="text-primary">回复</a></li>
										</ul>
										<div th:id="|huifu-${rvoStat.count}|" class="mt-4 collapse">
											<form method="post" th:action="@{|/comment/add/${post.id}|}">
												<div>
													<input type="text" class="input-size" name="content" th:placeholder="|回复${rvo.user.username}|"/>
													<input type="hidden" name="entityType" value="2">
													<input type="hidden" name="entityId" th:value="${cvo.comment.id}">
													<input type="hidden" name="targetId" th:value="${rvo.user.id}">
												</div>
												<div class="text-right mt-2">
													<button type="submit" class="btn btn-primary btn-sm" >&nbsp;&nbsp;回&nbsp;&nbsp;复&nbsp;&nbsp;</button>
												</div>
											</form>
										</div>
									</div>								
								</li>

								<!-- 回复输入框 -->
								<li class="pb-3 pt-3">
									<form method="post" th:action="@{|/comment/add/${post.id}|}">
										<div>
											<input type="text" class="input-size" name = "content" placeholder="请输入你的观点"/>
											<input type="hidden" name="entityType" value="2">
											<input type="hidden" name="entityId" th:value="${cvo.comment.id}">
											<input type="hidden" name="targetId" th:value="${cvo.user.id}">

										</div>
										<div class="text-right mt-2">
											<button type="submit" class="btn btn-primary btn-sm">&nbsp;&nbsp;回&nbsp;&nbsp;复&nbsp;&nbsp;</button>
										</div>
									</form>
								</li>
							</ul>
						</div>
					</li>

				</ul>

				<!-- 分页 -->
				<nav class="mt-5" th:replace="index::pagination"></nav>

			</div>
			<!-- 回帖输入 -->
			<div class="container mt-3">
				<form class="replyform" method="post" th:action="@{|/comment/add/${post.id}|}">
					<p class="mt-3">
						<a name="replyform"></a>
						<textarea placeholder="在这里畅所欲言你的看法吧!" name = "content"></textarea>
						<input type="hidden" name="entityType" value="1">
						<input type="hidden" name="entityId" th:value="${post.id}">
						<input type="hidden" name="targetId" th:value="${user.id}">
					</p>
					<p class="text-right">
						<button type="submit" class="btn btn-primary btn-sm">&nbsp;&nbsp;回&nbsp;&nbsp;帖&nbsp;&nbsp;</button>
					</p>
				</form>
			</div>
		</div>

		<!-- 尾部 -->
		@include('footer')

	</div>
	<script src="/static/js/jquery-3.1.0.min.js"></script>
	<script src="/static/js/popper.min.js"></script>
	<script src="/static/js/bootstrap.min.js"></script>
	<script src="/static/js/global.js"></script>
	<script src="/static/js/discuss.js"></script>

	<script src="/static/editor-md/lib/marked.min.js"></script>
	<script src="/static/editor-md/lib/prettify.min.js"></script>
	<script src="/static/editor-md/lib/raphael.min.js"></script>
	<script src="/static/editor-md/lib/underscore.min.js"></script>
	<script src="/static/editor-md/lib/sequence-diagram.min.js"></script>
	<script src="/static/editor-md/lib/flowchart.min.js"></script>
	<script src="/static/editor-md/lib/jquery.flowchart.min.js"></script>
	<script src="/static/editor-md/editormd.min.js"></script>
	<script type="text/javascript">
		var testEditor;
		$(function () {
			testEditor = editormd.markdownToHTML("md-content", {
				htmlDecode: "style,script,iframe",
				emoji: true,
				taskList: true,
				tex: true, // 默认不解析
				flowChart: true, // 默认不解析
				sequenceDiagram: true, // 默认不解析
				codeFold: true
			})
		})
	</script>

</body>
</html>
