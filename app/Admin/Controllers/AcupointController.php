<?php

namespace App\Admin\Controllers;

use App\Acupoint;
use Encore\Admin\Admin;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AcupointController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '穴位';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */

    protected function grid()
    {
        Admin::style('
            #greenhouse {
                position: relative;
                width: 100%;
                vertical-align: middle;
                margin: 0;
                overflow: hidden;
            }
            #greenhouse svg {
                display: inline-block;
                position: absolute;
                top: 0;
                left: 0;
            }
            #ear_svg {
                width: 200px;
                margin-left: 40%
            }
            #body_image {
                width: 300px;
                height: 600px;
                margin-left: 30%
            }
        }');
        $grid = new Grid(new Acupoint());
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->like('name', '穴名');
        });
        $grid->column('id', __('編號'))->sortable();
        $grid->column('name', __('穴名'))->modal('穴位圖', function ($model) {
            $image = "
                <div id='greenhouse'>
                    <svg viewBox='0 0 300 600' preserveAspectRatio='xMinYMin meet' id='body_image'>
                    <circle cx='" . $model->body_x . "' cy='" . $model->body_y . "' r='3' stroke='black' id='body' stroke-width='1' fill='red'/>
                        <img style='width: 300px;margin-left: 30%;' src='" . asset('uploads/images/body.jpeg') . "' alt='body'>
                    </svg>
                </div>";

            if ($model->parts == 'ear') {
                $image = "
                    <div id='greenhouse'>
                        <svg viewBox='0 0 200 200' preserveAspectRatio='xMinYMin meet' id='ear_svg'>
                            <circle cx='" . $model->ear_x . "' cy='" . $model->ear_y . "' r='5' stroke='black' id='ear' stroke-width='2' fill='red'/>
                            <img style='width: 200px;margin-left: 40%;' src='" . asset('uploads/images/ear.svg') . "' alt='ear'>
                        </svg>
                    </div>";
            }
            return $image;
        });
        $grid->column('body_x', __('Body x'))->hide();
        $grid->column('body_y', __('Body y'))->hide();
        $grid->column('ear_x', __('Ear x'))->hide();
        $grid->column('ear_y', __('Ear y'))->hide();

        $grid->column('parts', __('部位'))->display(function ($title) {
            return ($title === 'ear') ? "耳朵" : "身體";
        })->sortable();
        $grid->column('is_enabled', __('啟用'))->display(function ($title) {
            return ($title === 1) ? "是" : "否";
        })->sortable();
        $grid->column('created_at', __('建立時間'))->sortable()->width(200);
        $grid->column('updated_at', __('更新時間'))->sortable()->width(200);

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Acupoint::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('body_x', __('Body x'));
        $show->field('body_y', __('Body y'));
        $show->field('ear_x', __('Ear x'));
        $show->field('ear_y', __('Ear y'));
        $show->field('parts', __('Parts'));
        $show->field('is_enabled', __('Is enabled'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id = null)
    {
        /* form script*/
        Admin::js(asset('js/acupoint.js'));
        Admin::style('
            #greenhouse {
                position: relative;
                width: 100%;
                vertical-align: middle;
                margin: 0;
                overflow: hidden;
            }
            #greenhouse svg {
                display: inline-block;
                position: absolute;
                top: 0;
                left: 0;
            }
            #ear_svg {
                width: 200px;
            }

            #body_image {
                width: 300px;
                height: 600px;
            }
        ');
        $form = new Form(new Acupoint());
        $ear_x = 0;
        $ear_y = 0;
        $body_x = 0;
        $body_y = 0;

        if ($form->isEditing()) {
            $id = request()->route()->parameters();
            $model = $form->model()->find($id);
            $ear_x = $model[0]->ear_x;
            $ear_y = $model[0]->ear_y;
            $body_x = $model[0]->body_x;
            $body_y = $model[0]->body_y;
        }
        $form->text('name', __('名稱'));
        $form->radio('parts', __('部位'))
            ->options(['body' => '身體', 'ear' => '耳朵'])
            ->when('body', function (Form $form) use ($body_x, $body_y) {
                $form->slider('body_x', __('身體穴位 x'))
                    ->options([
                        'max' => 300,
                        'min' => 10,
                        'step' => 1,
                    ]);
                $form->slider('body_y', __('身體穴位 y'))
                    ->options([
                        'max' => 600,
                        'min' => 1,
                        'step' => 1,
                    ]);
                $form->html("
                    <div id='greenhouse'>
                        <svg viewBox='0 0 300 600' preserveAspectRatio='xMinYMin meet' id='body_image'>
                        <circle cx='" . $body_x . "' cy='" . $body_y . "' r='3' stroke='black' id='body' stroke-width='1' fill='red'/>
                            <img src='" . asset('uploads/images/body.jpeg') . "' alt='body' width='300px'>
                        </svg>
                    </div>
                ");
            })
            ->when('ear', function (Form $form) use ($ear_x, $ear_y) {
                $form->slider('ear_x', __('耳朵穴位 x'))
                    ->options([
                        'max' => 160,
                        'min' => 30,
                        'step' => 1,
                    ]);
                $form->slider('ear_y', __('耳朵穴位 y'))
                    ->options([
                        'max' => 200,
                        'min' => 1,
                        'step' => 1,
                    ]);
                $form->html("
                    <div id='greenhouse'>
                        <svg viewBox='0 0 200 200' preserveAspectRatio='xMinYMin meet' id='ear_svg'>
                        <circle cx='" . $ear_x . "' cy='" . $ear_y . "' r='5' stroke='black' id='ear' stroke-width='2' fill='red'/>
                            <img src='" . asset('uploads/images/ear.svg') . "' alt='ear' width='200px'>
                        </svg>
                    </div>
                ");
            });
        //->default('body');
        $form->switch('is_enabled', __('啟用'))->default(1);

        return $form;
    }
}
