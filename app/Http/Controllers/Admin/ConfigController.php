<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Cate;
use Illuminate\Http\Request;
use App\Model\Config;
use Exception;
use Illuminate\Support\Facades\DB;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $conf = Config::get();

        foreach($conf as $v){
            switch($v->field_type){
                case 'input':
                    $v->conf_contents = '<input type="text" name="conf_content[]" value="'.$v->conf_content.'" class="layui-input">';
                break;

                case 'textarea':
                    $v->conf_contents='<textarea name="conf_content[]" class="layui-textarea">'.$v->conf_content.'</textarea>';
                break;

                case 'radio':
                    case 'radio':
                    $str = '';
                    $arr = explode(',',$v->field_value) ;
                        
                    foreach ($arr as $n){
                        $a = explode('|',$n);
                        
                        if($a[0] == $v->conf_content){
                            $str.= '<input type="radio" checked name="conf_content[]" value="'.$a[0].'" title="'.$a[1].'">'.$a[1].'&nbsp;&nbsp;&nbsp;';
                        }else{
                            $str.= '<input type="radio"  name="conf_content[]" value="'.$a[0].'" title="'.$a[1].'">'.$a[1].'&nbsp;&nbsp;&nbsp;';
                        }
                        
                    }
                        
                    $v->conf_contents = $str;
                        
                        
                break;
                        
            }
        }



        return view('admin.config.list',compact('conf'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.config.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->except('_token');
        $conf_title = $input['conf_title'];
        $conf_name = $input['conf_name'];
        $conf_content = $input['conf_content'];
        $field_type = $input['field_type'];
        $conf_order = $input['conf_order'];
        $conf_tips = $input['conf_tips'];
        $res = Config::create(['conf_title'=>$conf_title,'conf_name'=>$conf_name,'conf_content'=>$conf_content,'field_type'=>$field_type,'conf_order'=>$conf_order,'conf_tips'=>$conf_tips]);
        if($res){
            return redirect('/admin/config');
        }else{
            return back()->with('msg','添加失败');
        }
        $this->putContent();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $conf = Config::find($id);
        $conf->delete();
        $res = $conf->save();
        if($res){
            $data = [
                'status'=>'0',
                'message'=>'删除成功',
            ];
        }else{
            $data = [
                'status'=>'1',
                'message'=>'删除失败',
            ];
        }
        $this->putContent();
        return $data;
    }



    // 批量修改
    public function changeContent(Request $request)
    {
        $input = $request->except('_token');
        DB::beginTransaction();

        try{
            foreach($input['conf_id'] as $k=>$v){
                DB::table('config')->where('conf_id',$v)->
                    update(['conf_content'=>$input['conf_content'][$k]]);
            }
            DB::commit();
            $this->putContent();
            return redirect('/admin/config');
        }catch(Exception $e){
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error'=>$e->getMessage()]);
        }
    }


    // 写入配置文件 每次增加 删除 修改 都要调用此方法更新配置文件
    public function putContent()
    {
        $content = Config::pluck('conf_content','conf_name')->all();
        
        $str = '<?php return '.var_export($content,true).';';

        file_put_contents(config_path().'/webconfig.php',$str);
    }
}
