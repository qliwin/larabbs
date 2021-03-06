<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 保存回复
	public function store(ReplyRequest $request, Reply $reply)
	{
        // ini_set('max_execution_time','1000');
        $reply->content = $request->content;
        $reply->topic_id = $request->topic_id;
        $reply->user_id = \Auth::id();
        $reply->save();
		return redirect()->to($reply->topic->link())->with('success', '创建回复成功');
	}

	public function destroy(Reply $reply)
	{
		$this->authorize('destroy', $reply);
		$reply->delete();

		return redirect()->route('replies.index')->with('message', 'Deleted successfully.');
	}
}
