<?php Block::put('breadcrumb') ?>
    <ul>
        <li><a href="<?= Backend::url('xitara/voodooblocks/blocklists') ?>">Block Lists</a></li>
        <li><?= e($this->pageTitle) ?></li>
    </ul>
<?php Block::endPut() ?>

<?php if (!$this->fatalError): ?>

    <div class="form-preview">
        <?= $this->formRenderPreview() ?>
    </div>

<?php else: ?>

    <p class="flash-message static error"><?= e($this->fatalError) ?></p>
    <p><a href="<?= Backend::url('xitara/voodooblocks/blocklists') ?>" class="btn btn-default">Return to block lists list</a></p>

<?php endif ?>
