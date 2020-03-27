<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Requests\BlogCategoryUpdateRequest;


class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = BlogCategory::paginate(15);
        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new BlogCategory();
        $categoryList = BlogCategory::all();
        return view('blog.admin.categories.edit', compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();// получаем  проверенные данные из формы
        if (empty($data['slug'])) { // сели  slug  пустой то генерируем из тайтла
            $data['slug'] = str_slug($data['title']);
        }

        // создаем объект
//        $item = new BlogCategory($data);
//        $item->save();
        $item=(new BlogCategory())->create($data);

        if ($item) {
            return redirect()->route('blog.admin.categories.edit', $item->id)
                ->with(['success' => 'Успешное сохраненно!']);
        } else {
            return back()
                // если есть ошибка выдай и отправь назад на исходную точку с сохранением данных в инпуте
                ->withErrors(['msg' => 'Ошибка сохранения!',])
                ->withInput();
        }


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $item = BlogCategory::find($id);
//       dd($item);
        $categoryList = BlogCategory::all();
        return view('blog.admin.categories.edit', compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {

        $item = BlogCategory::find($id);

        if (empty($item)) {
            return back()
                // если есть ошибка выдай и отправь назад на исходную точку с сохранением данных в инпуте
                ->withErrors(['msg' => "запись id=[{$id}] не найдена",])
                ->withInput();
        }
        $data = $request->all();
        if (empty($data['slug'])) { // сели  slug  пустой то генерируем из тайтла
            $data['slug'] = str_slug($data['title']);
        }
        $result = $item
            ->fill($data)
            ->save();

        if ($result) {
            return redirect()->route('blog.admin.categories.edit', $item->id)
                ->with(['success' => 'Успешное сохраненно!']);
        } else {
            return back()
                // если есть ошибка выдай и отправь назад на исходную точку с сохранением данных в инпуте
                ->withErrors(['msg' => 'Ошибка сохранения!',])
                ->withInput();
        }
    }

}
