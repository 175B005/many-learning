@extends('layouts.app')

@section('content')

<html>
<head>
    <meta charset="utf-8">
    <title>多:多</title>
</head>
<body>
    <form method="post">
        {{ csrf_field() }}
        <input style="width:400px; height:100px" name="contents">
	<input style="width:300px; height:30px" name="writelineTags"
		placeholder="「,」で区切って、タグ付けする(上限5コ)">
    <input type="hidden" value=<?= $userId; ?> name="user_id">
        <button>投稿</button>
    </form>
    <h1>ーーーあなたのツイート一覧ーーー</h1>

      @foreach ($twiiteList as $twiite)
      <div style="border: 1px solid #000; display: block; width: 400px; margin-top: 2px">
        <p style="display: inline-block">{{ $twiite->contents }}</p>
      </div>
        @foreach($twiite->tags as $tag)
          <p style="display: inline-block; margin-left: 10px; border: 1px solid #5fa; width: 100px">{{ $tag }}</p>
        @endforeach

      @endforeach
</body>
</html>
@endsection
