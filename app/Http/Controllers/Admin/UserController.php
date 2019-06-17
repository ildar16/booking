<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\UsersRepository;
use Illuminate\Http\Request;

class UserController extends AdminController
{
    public function __construct(UsersRepository $u_rep)
    {
        $this->template = config('settings.theme') . '.admin.index';

        $this->u_rep = $u_rep;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->title = "Users";

        $users = $this->u_rep->get();

        $content = view(config('settings.theme').'.admin.user')->with('users', $users)->render();
        $this->vars = array_add($this->vars,'content',$content);

        return $this->renderOutput();
    }

    public function updateStatus(Request $request)
    {
        $data = $request->except('_token');

        $user = $this->u_rep->one($data['user_id']);

        $user->apartments()->update(['status' => $data['status']]);

        $user->update(['status' => $data['status']]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }
}
