<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="post-table">こたに掲示板</a>
        </div>

    </div>
</nav>

<div class="col-md-3" >
    <?= $this->Form->create($postEntity, [
        'type' => 'file',
        'url' => [
            'action' => 'add'
        ]
        ]) ?>
        <fieldset>
            <?php
            echo $this->Form->input('name');
            echo $this->Form->input('contents');
            echo $this->Form->input('upload', [
                'type' => 'file',
                'label' => 'Image'
            ]);
            echo $this->Form->button('投稿', [
                'class' => 'btn btn-primary'
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
                                if ($postTable->image) {
                                    print "<br><a href='img/uploads/$postTable->image'><img src='img/uploads/t_{$postTable->image}' border='0'></a>";
                                }
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
