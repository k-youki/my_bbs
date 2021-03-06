<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="post-table">こたに掲示板</a>
        </div>
    </div>
</nav>

<div class="col-md-3">
    <?= $this->Form->create($postEntity, [
        'type' => 'file',
        'url' => ['action' => 'add'],
        'onsubmit'=>'return confirm("投稿します。よろしいですか？")',
        ]) ?>
        <fieldset>
            <?php
            echo $this->Form->input('name');
            echo "<p class='help-block'>※20文字以内で書いてください</p>";
            echo $this->Form->input('contents');
            echo "<p class='help-block'>※140文字以内で書いてください</p>";
            echo $this->Form->input('upload', [
                'type' => 'file',
                'label' => 'Image',
            ]);
            echo "<p class='help-block'>※jpg,png,gif形式に対応しています</p>";
            echo $this->Form->button('投稿', [
                'class' => 'btn btn-primary',
            ]);
            ?>
        </fieldset>
        <?= $this->Form->end(); ?>
    </div>

    <div class="col-md-9">
        <div class="table-responsive">
            <table cellpadding="0" cellspacing="0" class="table table-striped">
                <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('name') ?></th>
                        <th><?= $this->Paginator->sort('contents') ?></th>
                        <th><?= $this->Paginator->sort('date') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($postTable as $postTable): ?>
                        <tr>
                            <td><?= h($postTable->name) ?></td>
                            <td><?= h($postTable->contents) ?>
                                <?php
                                $image_path = glob("img/uploads/{$postTable->id}.*");
                                if ($image_path):
                                    $image_file = explode("/",$image_path[0]);
                                    print "<br>";
                                    //print_r($image_file);
                                    print "<a href='img/uploads/{$image_file[2]}' data-lightbox='test'>";
                                    print "<img src='img/uploads/thumbnails/{$image_file[2]}' border='0'></a>";
                                endif;
                                ?></td>
                                <td><?= h($postTable->date) ?></td>
                                <td class="actions">
                                    <!-- $this->Form->postLink(__('Delete'), ['action' => 'delete', $postTable->id], ['confirm' => __('Are you sure you want to delete ?')]) -->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="paginator">
                    <ul class="pagination">
                        <?= $this->Paginator->prev('< ' . __('previous')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('next') . ' >') ?>
                    </ul>
                    <p><?= $this->Paginator->counter() ?></p>
                </div>
            </div>
        </div>
