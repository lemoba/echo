<header class="bg-light sticky-top" th:fragment="header" style="box-shadow: 5px 5px 5px #cfcccc;">
    <div class="container">
        <!-- 导航 -->
        <nav class="navbar navbar-expand-lg navbar-dark">
            <!-- logo -->
            <a class="navbar-brand" href="/"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- 功能 -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item ml-3 btn-group-vertical">
                        <a class="nav-link" href="/">
                            <i class="bi bi-house"></i> 首页
                        </a>
                    </li>
                    <li class="nav-item ml-3 btn-group-vertical" th:if="${loginUser != null}">
                        <a class="nav-link position-relative" th:href="@{/letter/list}">
                            <i class="bi bi-envelope"></i> 消息
                            <span class="badge badge-danger" th:text="${allUnreadCount!=0 ? allUnreadCount : ''}"></span>
                        </a>
                    </li>
                    <li class="nav-item ml-3 btn-group-vertical">
                        <a class="nav-link" href="/register">注册</a>
                    </li>
                    <li class="nav-item ml-3 btn-group-vertical">
                        <a class="nav-link" href="/login">登录</a>
                    </li>
                    <li class="nav-item ml-3 btn-group-vertical dropdown" th:if="${loginUser != null}">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img th:src="${loginUser.headerUrl}" class="rounded-circle" style="width:30px;"/>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item text-center" th:href="@{|/user/profile/${loginUser.id}|}"><i class="bi bi-person-fill"></i> 个人主页</a>
                            <a class="dropdown-item text-center" th:href="@{/user/setting}"><i class="bi bi-gear"></i> 账号设置</a>
                            <a class="dropdown-item text-center" th:href="@{/data}" sec:authorize="hasAnyAuthority('admin')"><i class="bi bi-clipboard-data"></i> 数据统计</a>
                            <a class="dropdown-item text-center" th:href="@{/logout}"><i class="bi bi-box-arrow-right"></i> 退出登录</a>
                            <div class="dropdown-divider"></div>
                            <span class="dropdown-item text-center text-secondary" th:utext="${loginUser.username}"></span>
                        </div>
                    </li>
                    <li class="nav-item ml-3 btn-group-vertical">
                        <a class="nav-link" href="https://ylaila.com">🔥 CS-WiKi</a>
                    </li>
                </ul>
                <!-- 搜索 -->
                <form class="form-inline my-2 my-lg-0" method="get" th:action="@{/search}">
                    <input class="form-control mr-sm-2" type="search" name="keyword" th:value="${keyword}" aria-label="Search" />
                    <button class="btn btn-outline-light my-2 my-sm-0 serach-btn" type="submit"><i class="bi bi-search"></i> 搜索</button>
                </form>
            </div>
        </nav>
    </div>
</header>