<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function build($csvQuestions)
    {
        $tags = self::getTags($csvQuestions);
        $root = new Menu('root');

        foreach ($tags as $subTags) {
            $menu = self::menuBuild($root, $subTags);
            $root->setSubmenu($menu);
        }

        return json_encode($root->build());
    }


    public static function getTags($csvQuestions)
    {
        $tags = array();
        foreach ($csvQuestions as $csvQuestion) {
            if (!in_array($csvQuestion["tags"], $tags)) {
                array_push($tags, $csvQuestion["tags"]);
            }
        }

        return $tags;
    }


    public static function menuBuild($root, $tags)
    {

        if (count($tags) > 0 && is_array($tags)) {

            $removeTag = $tags[0];

            $result = array_splice($tags, 1);
        }


        if (count($result) > 0) {
            return $root->setSubmenu(self::menuBuild($root, $result));
        }

        $menu = new Menu($removeTag);
        return $menu;
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
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        //
    }
}
