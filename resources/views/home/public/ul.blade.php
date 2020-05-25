@include('home.public.adminscript')
@include('home.public.adminstyles')
@include('home.public.script')
@include('home.public.styles')

<!-- <nav id="primary-navigation" class="site-navigation primary-navigation " role="navigation"> -->
<style>
        *{ margin:0; padding:0;}
        .wrap{background: url("img/timg.jpg") no-repeat center;background-size: cover; position: absolute;     top: 0;
            left: 0;
            right: 0;
            bottom: 0;}
        .mainbar{ width:1200px; margin:0 auto;}
        .navList{ margin-top:30px;}
        .layui-nav{background-color:rgba(0,0,0,0);padding: 10px 0 0 0 }
        .layui-nav-itemed>.layui-nav-child{background-color: rgba(0,0,0,0)!important;}
        .layui-nav-tree .layui-nav-item a:hover {
            background-color: rgba(0,0,0,0);
        }
    </style>
<ul class="layui-nav" lay-filter="">

  <li class="layui-nav-item "><a href="{{ url('index') }}">首页</a></li>
  @foreach($cateone as $k=>$v)
  <li class="layui-nav-item">
 
    <a href="javascript:;">{{ $v->cate_name }}</a>
    @if(!empty($catetwo[$k]))
    
    <dl class="layui-nav-child"> <!-- 二级菜单 -->   
    @foreach($catetwo[$k] as $m=>$n)
    <dd><a href="{{ url('/lists/'.$n->cate_id) }}">{{ $n->cate_name }}</a></dd>
    @endforeach
    </dl>
    
    @endif
    
  </li>
  @endforeach
</ul>

<!-- </nav> -->
 
<script>
//注意：导航 依赖 element 模块，否则无法进行功能性操作
layui.use('element', function(){
  var element = layui.element;
  
  //…
});
</script>
      