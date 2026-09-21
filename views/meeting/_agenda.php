<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\widgets\Pjax;

app\assets\SortableAsset::register($this);
app\assets\NestableAsset::register($this);

$allAgendas = $meeting->getMeetingAgendas()
        ->isDeleted(false)
        ->notCOIMeeting()
        ->with([
            'agenda',
            'submission.project',
        ])
        ->orderBy(['parent_id' => SORT_ASC, 'sort' => SORT_ASC])
        ->all();

// build tree
function buildTree($elements, $parentId = null) {
    $branch = [];

    foreach ($elements as $el) {
        if ($el->parent_id == $parentId) {

            $children = buildTree($elements, $el->id);

            $branch[] = [
                'model' => $el,
                'children' => $children
            ];
        }
    }

    return $branch;
}

$agendaTree = buildTree($allAgendas);
?>
<?php

function renderAgenda($agendas, $maId) {
    foreach ($agendas as $item):

        $agenda = $item['model']; // 🔥 สำคัญมาก
        $children = $item['children'];

        // 🔹 sort_label
        $sortLabel = '';
        if (isset($agenda->sort_label)) {
            $rawSort = $agenda->sort_label;
            $sortLabel = is_scalar($rawSort) ? $rawSort : implode('.', (array) $rawSort);
        }

        // 🔹 short_title
        $shortTitle = '';
        if (!empty($agenda->agenda) && isset($agenda->title)) {
            $rawTitle = $agenda->title;
            $shortTitle = is_scalar($rawTitle) ? $rawTitle : implode(', ', (array) $rawTitle);
        }
        ?>
        <li class="dd-item <?= ($agenda->id == $maId ? 'active' : '') ?>"
            data-id="<?= (int) ($agenda->id ?? 0) ?>"
            data-sortable="<?= is_scalar($agenda->sortable) ? $agenda->sortable : 0 ?>"
            data-parent="<?= (int) ($agenda->parent_id ?? 0) ?>">

            <div class="dd-handle agenda-item <?= $agenda->need_resolution ? "agenda-clickable" : "" ?>">

                <?php if (!empty($agenda->agenda)): ?>

                    <?php if ($agenda->agenda->is_submission == 1): ?>

                        <div style="width: calc(100% - 65px);">
                            <?= $sortLabel ?>. <?= $shortTitle ?>
                        </div>
                        <?php if (!isset($agenda->submission_id)) { ?>
                            <div class="agenda-actions">
                                <span class="label label-primary">
                                    <?= count($children) ?> <?= Yii::t('app', 'โครงการ') ?>
                                </span>
                            </div>
                        <?php } ?>

                    <?php else: ?>
                        <?= $agenda->fullTitle ?? '' ?>
                    <?php endif; ?>

                <?php else: ?>
                    <?= $agenda->fullTitle ?? '' ?>
                <?php endif; ?>

                <?php if (!empty($agenda->submission_id) && isset($agenda->submission)): ?>
                    <div class="agenda-actions">

                        <?php if (isset($agenda->submission->project) && $agenda->submission->project->is_child_project == 1): ?>
                            <button class="btn btn-icon btn-danger btn-round btn-xs" title="โครงการเด็ก">
                                <i class="icon md-face"></i>
                            </button>
                        <?php endif; ?>

                        <?php if (!empty($agenda->coiPeople)): ?>
                            <button class="btn btn-icon btn-warning btn-round btn-xs" title="COI">
                                <i class="icon md-alert-triangle"></i>
                            </button>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>

            </div>

            <?php if (!empty($children)): ?>
                <ol class="dd-list" data-container="<?= $agenda->id ?>">
                    <?php renderAgenda($children, $maId); ?>
                </ol>
            <?php endif; ?>

        </li>
        <?php
    endforeach;
}
?>
<div class="row">
    <?php Pjax::begin(['id' => 'agenda-list-pjax', 'timeout' => FALSE, 'enablePushState' => FALSE, 'enableReplaceState' => FALSE]); ?>
    <div class="col-md-3">

        <div class="dd">
            <ol class="dd-list" data-container="0">
                <?php renderAgenda($agendaTree, $maId); ?>
            </ol>
        </div>

        <?php
        $sortUrl = yii\helpers\Url::to(['meeting-agenda/update-sort']);
        $agendaInfoUrl = yii\helpers\Url::to(['meeting-agenda/update-info']);
        $meetingUrl = Url::to(['meeting/update', 'id' => $meeting->id]);
        $js = <<<js
    function loadInfo(id) {
    //    console.log(el);
//        $.pjax.reload('#agenda-info-pjax', {url: '{$agendaInfoUrl}&id=' + id, timeout: false, push: false, replace: true});
        $.ajax({
            url: '{$agendaInfoUrl}',
            data: {id: id},
            method: 'GET',
//            dataType: 'JSON',
            success: function(res, textStatus, jqXHR) {
                $('.agenda-info').html(res);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                dlgError.dialog(textStatus + ': ' + jqXHR.status + ' ' + errorThrown + '</br>' + jqXHR.responseText, function(){});
            }
        });
    }
    $('.dd').nestable({
        callback: function(l,e){
            // l is the main container
            // e is the element that was moved
        //    console.log(e);
            var parentId = $(e).data('parent');
            var data = $('.dd').nestable('serialize');
            console.log(data)
            var filter = data.filter((d) => {
                return d.id == parentId;
            });
        //    console.log(filter);
            var _childFilter = [];
            if (filter.length == 0) {
                data.filter((d) => {
                    
                    if (!d.children) {
//                        console.log(d);
                        return false;
                    }
                    var childFilter = d.children.filter((c) => {
                        return c.id == parentId;
                    });
                    //console.log(childFilter);
                    if (childFilter.length > 0) {
                        _childFilter = childFilter;
                    }
                });
                filter = _childFilter;
            }

            if (filter.length == 0) {
                data.filter((d) => {
                    
                    if (!d.children) {
//                        console.log(d);
                        return false;
                    }
                    d.children.filter((c) => {
                        if (!c.children) {
                            return false;
                        }
                        
                        var childFilter = c.children.filter((e) => {
                            return e.id == parentId;
                        });
                        
                        if (childFilter.length > 0) {
                            _childFilter = childFilter;
                        }
                    });
                    filter = _childFilter;
                });
            }
            
        //    console.log(filter);
//            console.log(filter[0].children);
            $.ajax({
                url: '{$sortUrl}',
                data: {meetingAgendas: filter[0].children},
                method: 'POST',
                dataType: 'JSON',
                success: function(res, textStatus, jqXHR) {
                    $.pjax.reload('#agenda-list-pjax', {push: false, replace: false, url: '{$meetingUrl}&maId=' + $(e).data('id')});

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    dlgError.dialog(textStatus + ': ' + jqXHR.status + ' ' + errorThrown + '</br>' + jqXHR.responseText, function(){});
                }
            });
            loadInfo($(e).data('id'));
            console.log($(e));
            $('.dd-item').removeClass('active');
            $(e).addClass('active');
            console.log($(e).hasClass('active'));
//            $(e).click();
//            return true;
        },
        onDragStart: function (l, e) {
            var sortable = $(e).data('sortable');
            if (sortable == 0) {
                return false;
            }
        },
        beforeDragStop: function (l, e, p) {
            var srcParent = $(e).data('parent');
            var dstParent = $(p).data('container');
//            console.log(l);
//            console.log(e);
//            console.log(p);
            if (srcParent != dstParent) {
                return false;
            }
        }
    });
                
    $('li[data-sortable="0"] > .agenda-clickable').click(function() {
//        console.log(this);
        loadInfo($(this).parent().data('id'));
        $('.dd-item').removeClass('active');
        $(this).parent().addClass('active');
        console.log($(this));
    });
                
js;
        $this->registerJs($js);
        ?>
        <?php Pjax::end(); ?>
    </div>
    <div class="col-md-9">
        <div class="panel">
            <div class="panel-body agenda-info">
            </div>
        </div>
    </div>
</div>

