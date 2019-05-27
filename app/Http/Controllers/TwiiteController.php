<?php

namespace App\Http\Controllers;

use App\Twiite;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwiiteController extends Controller
{
    protected $twiite;
    protected $tag;

    public function __construct(Twiite $twiite){
        $this->middleware('auth');//ユーザ認証
        $this->twiite = $twiite;//twiiteクラスのインスタンス化
        $this->tag = new Tag();
    }

    public function index(Request $request)
    {
        $userId = Auth::id();//ログイン中のid

        if(!empty($request->tag)){//タグ情報がクエリで来ている場合。（検索）
          $oneTagRecorde = $this->tag->where('name', $request->tag)
            ->first();//タグを押してここに入るので、一意で一つしかないと予想される。
          $twiiteList = $oneTagRecorde->twiites()
            ->orderby('twiite_id')
            ->get();//リレーションからタグに対応するツイートを全取得。
        }
        else{
          $twiiteList = $this->twiite->where('user_id',$userId)
            ->orderby('created_at','desc')
            ->get();//ツイート全件取得
        }

        foreach($twiiteList as $twiiteRecord){
          $tags = $twiiteRecord->tags()->orderby('tag_id')->get();//中間テーブル経由でタグのrecordを取得
          $tagName = [];
          $exchangeArray = 0;//先頭になるタグ名の番号
          foreach($tags as $tagRecord){//タグも複数あるので、繰り返す。
            $tagName[] = $tagRecord->name;//取得してきたレコードのid

            if($request->tag === $tagRecord->name)//タグ名が選択タグと一致
              $exchangeArray = count($tagName) - 1;
          }

          if($exchangeArray != 0){//先頭入れ替え
            $name = $tagName[0];
            $tagName[0] = $tagName[$exchangeArray];
            $tagName[$exchangeArray] = $name;
          }

          $twiiteRecord['tags'] = $tagName;//送るデータに追加（同foreachで回すため）
        }
        return view('index', compact('twiiteList', 'userId'));//index view
    }

    public function store(Request $request)
    {
      $userId = Auth::id();//ログイン中のid
      $inputs = $request->all();//リクエスト全て

      if(!empty($inputs['writelineTags'])){
        $tags = $this->setTagDivide($inputs['writelineTags']);//文字列を配列に分割「,」
        $tag_ids = $this->getIds($tags);//分割したタグを作り（またはカウントを追加し、）、そのidを取得
      }

      $this->twiite->contents = $inputs['contents'];//contentsデータを
      $twiite = $this->twiite->create($inputs);//twiiteデータ一件を作成＆一件のデータを持つmodelのオブジェクト取得
      $twiite->tags()->attach($tag_ids);//中間テーブルに格納

      return redirect()->to('twiite');//indexへリダイレクト
    }

    public function edit(Twiite $twiite,$id)
    {
        // return view("create", compact('twiite','id'));
    }

    public function update(Request $request, Twiite $twiite)
    {
        //
    }

    public function destroy(Twiite $twiite)
    {
        //
    }

    public function setTagDivide($tagstring){
      $tags = explode(',',$tagstring);//文字列から特定の文字に応じて区切り、配列として格納。
      return $tags;//Is Array.
    }

    public function getIds($tags){
      $recodes = [];//帰り値の初期化
      $count = 5;
      foreach($tags as $tag){
        $count--;//カウント
        if($count <= 0) exit;//上限を超える場合は強制退場

        $aleadyTag = $this->tag->firstOrCreate(['name' => $tag]);//あれば取得、なければ作成。
        $aleadyTag->increment('counts');
        $recodes[] = $aleadyTag->id;
      }
         // dd($recodes);//tag_id,tag_id,tag_id..
        return $recodes;
    }
}
