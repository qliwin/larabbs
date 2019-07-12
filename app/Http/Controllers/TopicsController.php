<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use Auth;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        // $topics = Topic::with('user', 'category')->paginate();
        $topics = Topic::withOrder(request('order'))->paginate();

        return view('topics.index', compact('topics'));
    }

    public function show(Topic $topic)
    {
        // 如果话题的 Slug 字段不为空；并且话题 Slug 不等于请求的路由参数 Slug；301 永久重定向到正确的 URL 上
        if (!empty($topic->slug) && request('slug') != $topic->slug) {
            return redirect($topic->link(), 301);
        }

        return view('topics.show', compact('topic'));
    }

    // 话题创建表单
    public function create(Topic $topic)
    {
        $categories = Category::all();

        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    // 话题存储
    public function store(TopicRequest $request, Topic $topic)
    {

        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();

        // return redirect()->route('topics.show', $topic->id)->with('success', '帖子创建成功');
        return redirect()->to($topic->link())->with('success', '帖子创建成功');

        /*
        因为要使用到 Auth 类，所以需在文件顶部进行加载；
        store() 方法的第二个参数，会创建一个空白的 $topic 实例；
        $request->all() 获取所有用户的请求数据数组，如 ['title' => '标题', 'body' => '内容', ... ] ；
        $topic->fill($request->all()); fill 方法会将传参的键值数组填充到模型的属性中，如以上数组， $topic-
        >title 的值为 标题 ；
        Auth::id() 获取到的是当前登录的 ID；
        $topic->save() 保存到数据库中
        */
    }

    public function edit(Topic $topic)
    {
        $this->authorize('update', $topic);
        $categories = Category::all();

        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());

        // return redirect()->route('topics.show', $topic->id)->with('message', 'Updated successfully.');
        return redirect()->to($topic->link())->with('message', 'Updated successfully.');
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);
        $topic->delete();

        return redirect()->route('topics.index')->with('message', '删除成功');
    }

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据， 默认是失败的
        $data = [
            'success' => false,
            'msg' => '上传失败',
            'file_path' => '',
        ];

        // 判断是否有上传文件，并赋值给$file
        // upload_file是上传附件的字段名（自定义），$file是UploadedFile类对象
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($file, 'topic', \Auth::id(), 1024);

            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg'] = '上传成功';
                $data['success'] = true;
            }
        }

        return $data;
    }
}
