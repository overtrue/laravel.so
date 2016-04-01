<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Link;

class LinkController extends Controller
{
    protected $model;

    public function __construct(Link $link)
    {
        $this->model = $link;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $links = $this->model->latest()->where(function () {

        })->paginate(10);

        return admin_view('link.index', compact('links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return admin_view('link.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:links',
            'url' => 'required|url',
        ];

        $this->validate($request, $rules);

        $link = $this->model->create($request->all());

        return redirect()->back()->withMessage('创建成功！');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $link = $this->model->findOrFail($id);

        return admin_view('link.form', compact('link'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|unique:links,name,'.$id,
            'url' => 'required|url',
        ];

        $this->validate($request, $rules);

        $this->model->findOrFail($id)->fill($request->all())->save();

        return redirect()->back()->withMessage('更新成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $this->model->findOrFail($id)->delete();

        if ($request->ajax()) {
            return response()->json(['status' => 1]);
        }

        return redirect()->back()->withMessage('删除成功！');
    }
}
