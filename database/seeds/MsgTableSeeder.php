<?php


use Illuminate\Database\Seeder;
use App\Models\Msg;
class  MsgTableSeeder extends  Seeder{
	
	public function run(){
		
		DB::table('msgs')->insert([
		'title' =>'hello word',
		'author' =>'test1',
		'body' =>'仅仅为了测试数据使用的',
		]);
	}
}