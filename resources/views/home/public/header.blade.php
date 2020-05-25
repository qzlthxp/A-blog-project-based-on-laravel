@include('home.public.adminscript')
@include('home.public.adminstyles')
@include('home.public.script')
@include('home.public.styles')
<header class="header-wrap" id="nav-scroll">
    <div class="nav-wrap">
        <div class="logo-title">
            <a href="/" alt="博客" title="博客"> 博客 </a>
        </div>
        <!-- Toggle menu -->
        <div class="toggle-menu">
            <i class="fa fa-bars"></i>
        </div>
        <!-- /.Toggle menu -->
        <!-- Search button -->
        <div class="search-btn-click">
            <i class="fa fa-search"></i>
            <div class="header-search-slide">
                <form method="get" id="searchform-slide" class="searchform" action="http://www.lmonkey.com" role="search">
                    <input type="search" class="field" name="s" value="" placeholder="Search" required="" />
                </form>
            </div>
        </div>
        <!-- /.Search button -->
        <!-- /.Search button -->
    @if(session('homeuser'))
        <!-- Login status -->
            <div id="login-reg">
                <span> <a href="/loginout">退出登录</a></span>
            </div>
            <!-- /.Login status -->
            <!-- Login status -->
            <div id="login-reg">
                <span> <a href="#">{{ session('homeuser')->user_name }}</a></span>
            </div>
            <!-- /.Login status -->


    @else
        <!-- Login status -->
            <!-- Login status -->
            <div id="login-reg">
                <span> <a href="/login">登录</a></span>
            </div>
            <!-- /.Login status -->
            <div id="login-reg">
                <span> <a href="/emailregister">注册</a></span>
            </div>
            <!-- /.Login status -->


    @endif
        <!-- Focus us -->
        <div id="focus-us">
            关注我们
            <div id="focus-slide" class="ie_pie">
                <div class="focus-title">
                    关注我们
                </div>
                <p class="focus-content"> <a href="#" target="_blank" class="sinaweibo"><span><i class="fa fa-weibo"></i>新浪微博</span></a> <a href="http://t.qq.com/iydu_net" target="_blank" class="sinaweibo"><span><i class="fa fa-tencent-weibo"></i>腾讯微博</span></a> </p>
                <div class="focus-title">
                    联系我们
                </div>
                <p class="focus-content" style="line-height: 20px;margin-bottom: 10px;"> <a href="#" target="_blank" class="qq"><span><i class="fa fa-qq"></i>QQ</span></a> <a href="#" target="_blank"><span><i class="fa fa-envelope"></i>发送邮件</span></a>
                    <!-- 可删除 --> <a target="_blank" href="#"><i class="fa fa-users">&nbsp;&nbsp;</i>加入QQ群</a>
                    <!-- 删除截止 --> </p>
                <div class="focus-title">
                    订阅本站
                    <i class="fa fa-rss"></i>
                </div>
                <p class="focus-content"> <input type="text" name="rss" class="rss" value="#" /> </p>
                <p class="focus-content">订阅到： <a rel="external nofollow" target="_blank" href="#">鲜果</a> <a rel="external nofollow" target="_blank" href="#">有道</a> <a rel="external nofollow" target="_blank" href="#">Feedly</a></p>
                <form action="#" target="_blank" method="post">
                    <input type="hidden" name="t" value="qf_booked_feedback" />
                    <input type="hidden" name="id" value="" />
                    <input type="email" name="to" id="to" class="focus-email" placeholder="输入邮箱,订阅本站" required="" />
                    <input type="submit" class="focus-email-submit" value="订阅" />
                </form>
            </div>
        </div>
       
        <!-- /.Focus us -->
        <!-- Menu Items Begin -->
        <nav >
            <div class="menu-%e9%a1%b6%e9%83%a8%e8%8f%9c%e5%8d%95-container"> 
            @include('home.public.ul')
               
             </div>
        </nav>
        <!-- Menu Items End -->
    </div>
    <div class="clr"></div>
    <div class="site_loading"></div>
</header>
<div class="hidefixnav"></div>
<!-- End Nav -->
<script type="text/javascript">
    $('.site_loading').animate({'width':'33%'},50);  //第一个进度节点
</script>

<script language="javascript" type="text/javascript">
 function showSubLevel(Obj){
  Obj.className="hover";
 }
 function hideSubLevel(Obj){
  Obj.className="";
 }
</script>