<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	private $group = null;
	private $user = null;
	private $content = null;
	private $content_p = null;
	
	public function __construct(){
		parent::__construct();
		$this->group = M('Group');
        $this->user = M('User');
        $this->content = M('Content');
        $this->content_p = M('Content_picture');	
	}

	//统计数据
	public function lists(){
		$m = M();
		//发布的文章数
		//$data1 = $m->query('select sum(c.con) as conn,g.group_name,g.group_id from (Select count(a.content_id) as con,b.group_id,b.username from jc_content a 
		//left join jc_user b on b.user_id=a.user_id GROUP BY a.user_id ) c left join jc_group g on g.group_id=c.group_id group by c.group_id');
		//发布的图片个数
		$data = $m->query('select sum(c.con) as com,g.group_name,g.group_id from (Select count(a.content_id) as con,a.sort_date,b.group_id,b.username from jc_content a left join jc_user b on b.user_id=a.user_id LEFT JOIN jc_content_picture p on p.content_id=a.content_id GROUP BY a.user_id) c left join jc_group g on g.group_id=c.group_id group by c.group_id');
		/* p($data1);
		p($data); */
		$this->assign(array(
			//'data1'=>$data1,
			'data'=>$data,
		));
		$this->display();
	}
	//导出全部数据表格
	public function excelExport(){
		$m = M();
		$data = $m->query('select g.group_name,sum(c.con) as com from (Select count(a.content_id) as con,a.content_id,b.group_id,b.username from jc_content a left join jc_user b on b.user_id=a.user_id LEFT JOIN jc_content_picture p on p.content_id=a.content_id GROUP BY a.user_id) c left join jc_group g on g.group_id=c.group_id group by c.group_id');
		$title = array('基层公司','年度照片上传数量'); //设置要导出excel的表头
		exportExcel($data, '媒资系统年度上传统计', $title);
	}
	//导出2015年数据
	public function excel2015(){
		//2015年时间段
		$stime5 = date('2015-01-01 00:00:00',time());
		$etime5 = date('2015-12-31 23:59:59',time());
		$excel=1;
		$where['sort_date'] = array('between',"$stime5,$etime5");
		//根据用户查询发布的文章数
		$data = $this->content->alias('a')
		->field(array("count(a.content_id)"=>"countCom",'a.sort_date','b.group_id','b.username'))
		->join('left join __USER__ b on b.user_id=a.user_id')
		->where($where)
		->group('a.user_id')->buildSql();
		//根据公司查全部数据
		$arr = $this->group->alias('c')
		->field(array('g.group_name',"sum(c.countCom)"=>"conn"))
		->table($data)
		->join('left join __GROUP__ g on g.group_id=c.group_id')
		->group('c.group_id')
		->select();
		if(empty($arr)){
			$this->error('没有数据');
		}else{
			
			$this->assign('excel' , $excel);
			$title = array('基层公司','照片上传数量'); //设置要导出excel的表头
			exportExcel($arr, '媒资系统2015照片上传数量统计', $title);
		}
	}
	//导出2016年数据
	public function excel2016(){
		//2016年时间段
		$stime6 = date('2016-01-01 00:00:00',time());
		$etime6 = date('2016-12-31 23:59:59',time());
		$excel=1;
		//2016
		$where['sort_date'] = array('between',"$stime6,$etime6");
		
		//根据用户查询发布的文章数
		$data = $this->content->alias('a')
		->field(array("count(a.content_id)"=>"countCom",'a.sort_date','b.group_id','b.username'))
		->join('left join __USER__ b on b.user_id=a.user_id')
		->where($where)
		->group('a.user_id')->buildSql();
		//根据公司查全部数据
		$arr = $this->group->alias('c')
		->field(array('g.group_name',"sum(c.countCom)"=>"conn"))
		->table($data)
		->join('left join __GROUP__ g on g.group_id=c.group_id')
		->group('c.group_id')
		->select();
		//p(M()->getLastSql());die;
		if(empty($arr)){
			$this->error('没有数据');
		}else{
			$this->assign('excel' , $excel);
			$title = array('基层公司','照片上传数量'); //设置要导出excel的表头
			exportExcel($arr, '媒资系统2016照片上传数量统计', $title);
		}
	}
	//导出2017年数据
	public function excel2017(){
		//2016年时间段
		$stime6 = date('2017-01-01 00:00:00',time());
		$etime6 = date('2017-12-31 23:59:59',time());
		$excel=3;
		//2016
		$where['sort_date'] = array('between',"$stime6,$etime6");
		
		//根据用户查询发布的文章数
		$data = $this->content->alias('a')
		->field(array("count(a.content_id)"=>"countCom",'a.sort_date','b.group_id','b.username'))
		->join('left join __USER__ b on b.user_id=a.user_id')
		->where($where)
		->group('a.user_id')->buildSql();
		//根据公司查全部数据
		$arr = $this->group->alias('c')
		->field(array('g.group_name',"sum(c.countCom)"=>"conn"))
		->table($data)
		->join('left join __GROUP__ g on g.group_id=c.group_id')
		->group('c.group_id')
		->select();
		//p(M()->getLastSql());die;
		if(empty($arr)){
			$this->error('没有数据');
		}else{
			$this->assign('excel' , $excel);
			$title = array('基层公司','照片上传数量'); //设置要导出excel的表头
			exportExcel($arr, '媒资系统2017照片上传数量统计', $title);
		}
	}
	//导出2018年数据
	public function excel2018(){
		//2016年时间段
		$stime6 = date('2018-01-01 00:00:00',time());
		$etime6 = date('2018-12-31 23:59:59',time());
		$excel=4;
		//2016
		$where['sort_date'] = array('between',"$stime6,$etime6");
		
		//根据用户查询发布的文章数
		$data = $this->content->alias('a')
		->field(array("count(a.content_id)"=>"countCom",'a.sort_date','b.group_id','b.username'))
		->join('left join __USER__ b on b.user_id=a.user_id')
		->where($where)
		->group('a.user_id')->buildSql();
		//根据公司查全部数据
		$arr = $this->group->alias('c')
		->field(array('g.group_name',"sum(c.countCom)"=>"conn"))
		->table($data)
		->join('left join __GROUP__ g on g.group_id=c.group_id')
		->group('c.group_id')
		->select();
		//p(M()->getLastSql());die;
		if(empty($arr)){
			$this->error('没有数据');
		}else{
			$this->assign('excel' , $excel);
			$title = array('基层公司','照片上传数量'); //设置要导出excel的表头
			exportExcel($arr, '媒资系统2018照片上传数量统计', $title);
		}
	}
	//导出2019年数据
	public function excel2019(){
		//2016年时间段
		$stime6 = date('2019-01-01 00:00:00',time());
		$etime6 = date('2019-12-31 23:59:59',time());
		$excel=5;
		//2016
		$where['sort_date'] = array('between',"$stime6,$etime6");
		
		//根据用户查询发布的文章数
		$data = $this->content->alias('a')
		->field(array("count(a.content_id)"=>"countCom",'a.sort_date','b.group_id','b.username'))
		->join('left join __USER__ b on b.user_id=a.user_id')
		->where($where)
		->group('a.user_id')->buildSql();
		//根据公司查全部数据
		$arr = $this->group->alias('c')
		->field(array('g.group_name',"sum(c.countCom)"=>"conn"))
		->table($data)
		->join('left join __GROUP__ g on g.group_id=c.group_id')
		->group('c.group_id')
		->select();
		//p(M()->getLastSql());die;
		if(empty($arr)){
			$this->error('没有数据');
		}else{
			$this->assign('excel' , $excel);
			$title = array('基层公司','照片上传数量'); //设置要导出excel的表头
			exportExcel($arr, '媒资系统2019照片上传数量统计', $title);
		}
	}
	//导出2020年数据
	public function excel2020(){
		//2016年时间段
		$stime6 = date('2020-01-01 00:00:00',time());
		$etime6 = date('2020-12-31 23:59:59',time());
		$excel=6;
		//2016
		$where['sort_date'] = array('between',"$stime6,$etime6");
		
		//根据用户查询发布的文章数
		$data = $this->content->alias('a')
		->field(array("count(a.content_id)"=>"countCom",'a.sort_date','b.group_id','b.username'))
		->join('left join __USER__ b on b.user_id=a.user_id')
		->where($where)
		->group('a.user_id')->buildSql();
		//根据公司查全部数据
		$arr = $this->group->alias('c')
		->field(array('g.group_name',"sum(c.countCom)"=>"conn"))
		->table($data)
		->join('left join __GROUP__ g on g.group_id=c.group_id')
		->group('c.group_id')
		->select();
		//p(M()->getLastSql());die;
		if(empty($arr)){
			$this->error('没有数据');
		}else{
			$this->assign('excel' , $excel);
			$title = array('基层公司','照片上传数量'); //设置要导出excel的表头
			exportExcel($arr, '媒资系统2020照片上传数量统计', $title);
		}
	}
	//导出2021年数据
	public function excel2021(){
		//2016年时间段
		$stime6 = date('2021-01-01 00:00:00',time());
		$etime6 = date('2021-12-31 23:59:59',time());
		$excel=7;
		//2016
		$where['sort_date'] = array('between',"$stime6,$etime6");
		
		//根据用户查询发布的文章数
		$data = $this->content->alias('a')
		->field(array("count(a.content_id)"=>"countCom",'a.sort_date','b.group_id','b.username'))
		->join('left join __USER__ b on b.user_id=a.user_id')
		->where($where)
		->group('a.user_id')->buildSql();
		//根据公司查全部数据
		$arr = $this->group->alias('c')
		->field(array('g.group_name',"sum(c.countCom)"=>"conn"))
		->table($data)
		->join('left join __GROUP__ g on g.group_id=c.group_id')
		->group('c.group_id')
		->select();
		//p(M()->getLastSql());die;
		if(empty($arr)){
			$this->error('没有数据');
		}else{
			$this->assign('excel' , $excel);
			$title = array('基层公司','照片上传数量'); //设置要导出excel的表头
			exportExcel($arr, '媒资系统2021照片上传数量统计', $title);
		}
	}
	//导出2022年数据
	public function excel2022(){
		//2016年时间段
		$stime6 = date('2022-01-01 00:00:00',time());
		$etime6 = date('2022-12-31 23:59:59',time());
		$excel=8;
		//2016
		$where['sort_date'] = array('between',"$stime6,$etime6");
		
		//根据用户查询发布的文章数
		$data = $this->content->alias('a')
		->field(array("count(a.content_id)"=>"countCom",'a.sort_date','b.group_id','b.username'))
		->join('left join __USER__ b on b.user_id=a.user_id')
		->where($where)
		->group('a.user_id')->buildSql();
		//根据公司查全部数据
		$arr = $this->group->alias('c')
		->field(array('g.group_name',"sum(c.countCom)"=>"conn"))
		->table($data)
		->join('left join __GROUP__ g on g.group_id=c.group_id')
		->group('c.group_id')
		->select();
		//p(M()->getLastSql());die;
		if(empty($arr)){
			$this->error('没有数据');
		}else{
			$this->assign('excel' , $excel);
			$title = array('基层公司','照片上传数量'); //设置要导出excel的表头
			exportExcel($arr, '媒资系统2022照片上传数量统计', $title);
		}
	}
	//导出全部数据表格
	public function excelLastYear(){
		$excel = 0;
		//根据用户查询发布的文章数
		$data = $this->content->alias('a')
		->field(array("count(a.content_id)"=>"countCom",'a.sort_date','b.group_id','b.username'))
		->join('left join __USER__ b on b.user_id=a.user_id')
		->where()
		->group('a.user_id')->buildSql();
		//根据公司查全部数据
		$arr = $this->group->alias('c')
		->field(array('g.group_name',"sum(c.countCom)"=>"conn"))
		->table($data)
		->join('left join __GROUP__ g on g.group_id=c.group_id')
		->group('c.group_id')
		->select();
		if(empty($arr)){
			$this->error('没有数据');
		}else{
			$this->assign('excel' , $excel);
			$title = array('基层公司','照片上传数量'); //设置要导出excel的表头
			exportExcel($arr, '媒资系统全部照片上传数量统计', $title);
		}
		
	}
	
	//选择年份查询年份数据
	
    public function index(){
		//2015年时间段
		$stime5 = date('2015-01-01 00:00:00',time());
		$etime5 = date('2015-12-31 23:59:59',time());
		//2016年时间
		$stime6 = date('2016-01-01 00:00:00',time());
		$etime6 = date('2016-12-31 23:59:59',time());
		//2017年时间
		$stime7 = date('2017-01-01 00:00:00',time());
		$etime7 = date('2017-12-31 23:59:59',time());
		//2018年时间
		$stime8 = date('2018-01-01 00:00:00',time());
		$etime8 = date('2018-12-31 23:59:59',time());
		//2019年时间
		$stime9 = date('2019-01-01 00:00:00',time());
		$etime9 = date('2019-12-31 23:59:59',time());
		//2020年时间
		$stime20 = date('2020-01-01 00:00:00',time());
		$etime20 = date('2020-12-31 23:59:59',time());
		//2021年时间
		$stime21 = date('2021-01-01 00:00:00',time());
		$etime21 = date('2021-12-31 23:59:59',time());
		//2022年时间
		$stime22 = date('2022-01-01 00:00:00',time());
		$etime22 = date('2022-12-31 23:59:59',time());
		
		$where = '1 = 1';
		$excel = 0;
		if(IS_POST){		
			$excel = I('post.excel');
			$where = array();
			if($excel==1){
				//2015
				$where['sort_date'] = array('between',"$stime5,$etime5");
			}else if($excel==2){
				//2016
				$where['sort_date'] = array('between',"$stime6,$etime6");
			}else if($excel==3){
				//2017
				$where['sort_date'] = array('between',"$stime7,$etime7");
			}else if($excel==4){
				//2018
				$where['sort_date'] = array('between',"$stime8,$etime8");
			}else if($excel==5){
				//2019
				$where['sort_date'] = array('between',"$stime9,$etime9");
			}else if($excel==6){
				//2020
				$where['sort_date'] = array('between',"$stime20,$etime20");
			}else if($excel==7){
				//2021
				$where['sort_date'] = array('between',"$stime21,$etime21");
			}else if($excel==8){
				//2022
				$where['sort_date'] = array('between',"$stime22,$etime22");
			}
		}

		//根据用户查询发布的文章数

		$data = $this->content->alias('a')
		->field(array("count(a.content_id)"=>"countCom",'a.sort_date','b.group_id','b.username'))
		->join('left join __USER__ b on b.user_id=a.user_id')
		->where($where)
		->group('a.user_id')->buildSql();
		
		//根据公司查全部数据
		$arr = $this->group->alias('c')
		->field(array("sum(c.countCom)"=>"conn",'g.group_name','g.group_id'))
		->table($data)
		->join('left join __GROUP__ g on g.group_id=c.group_id')
		->group('c.group_id')
		->select(); 
		

		$this->assign('data' , $arr);
		$this->assign('excel' , $excel);
		$this->display();
		

	}
	
	
	//图表柱状图数据
	public function chatData(){
		//2015年时间段
		$stime5 = date('2015-01-01 00:00:00',time());
		$etime5 = date('2015-12-31 23:59:59',time());
		//2016年时间
		$stime6 = date('2016-01-01 00:00:00',time());
		$etime6 = date('2016-12-31 23:59:59',time());
		//2017年时间
		$stime7 = date('2017-01-01 00:00:00',time());
		$etime7 = date('2017-12-31 23:59:59',time());
		//2018年时间
		$stime8 = date('2018-01-01 00:00:00',time());
		$etime8 = date('2018-12-31 23:59:59',time());
		//2019年时间
		$stime9 = date('2019-01-01 00:00:00',time());
		$etime9 = date('2019-12-31 23:59:59',time());
		//2020年时间
		$stime20 = date('2020-01-01 00:00:00',time());
		$etime20 = date('2020-12-31 23:59:59',time());
		//2021年时间
		$stime21 = date('2021-01-01 00:00:00',time());
		$etime21 = date('2021-12-31 23:59:59',time());
		//2022年时间
		$stime22 = date('2022-01-01 00:00:00',time());
		$etime22 = date('2022-12-31 23:59:59',time());
		
		$where = '1 = 1';
		$excel = 0;
		if(IS_POST){		
			$excel = I('post.excel');
			$where = array();
			if($excel==1){
				//2015
				$where['sort_date'] = array('between',"$stime5,$etime5");
			}else if($excel==2){
				//2016
				$where['sort_date'] = array('between',"$stime6,$etime6");
			}else if($excel==3){
				//2017
				$where['sort_date'] = array('between',"$stime7,$etime7");
			}else if($excel==4){
				//2018
				$where['sort_date'] = array('between',"$stime8,$etime8");
			}else if($excel==5){
				//2019
				$where['sort_date'] = array('between',"$stime9,$etime9");
			}else if($excel==6){
				//2020
				$where['sort_date'] = array('between',"$stime20,$etime20");
			}else if($excel==7){
				//2021
				$where['sort_date'] = array('between',"$stime21,$etime21");
			}else if($excel==8){
				//2022
				$where['sort_date'] = array('between',"$stime22,$etime22");
			}
		}

		//根据用户查询发布的文章数

		$data = $this->content->alias('a')
		->field(array("count(a.content_id)"=>"countCom",'a.sort_date','b.group_id','b.username'))
		->join('left join __USER__ b on b.user_id=a.user_id')
		->where($where)
		->group('a.user_id')->buildSql();
		
		//根据公司查全部数据
		$arr = $this->group->alias('c')
		->field(array("sum(c.countCom)"=>"conn",'g.group_name','g.group_id'))
		->table($data)
		->join('left join __GROUP__ g on g.group_id=c.group_id')
		->group('c.group_id')
		->select(); 
		

		$this->assign('data' , $arr);
		$this->assign('excel' , $excel);
		$this->display();
	}
	
	
	
}