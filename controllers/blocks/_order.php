<a href="#"
   data-request="onMoveFieldUp"
   data-request-data="field_id:<?= $record->id ?>"
   data-toggle="tooltip" title="<?= e(trans('xitara.voodooblocks::lang.models.all.sort_order.up')) ?>">
    <i class="icon-caret-up"></i>
</a>

&nbsp; <span class="text-muted">/</span> &nbsp;

<a href="#"
   data-request="onMoveFieldDown"
   data-request-data="field_id:<?= $record->id ?>"
   data-toggle="tooltip" title="<?= e(trans('xitara.voodooblocks::lang.models.all.sort_order.down')) ?>">
    <i class="icon-caret-down"></i>
</a>
