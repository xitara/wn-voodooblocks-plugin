<div data-control="toolbar">
    <a
        href="<?= Backend::url('xitara/voodooblocks/blocklists/create') ?>"
        class="btn btn-primary oc-icon-plus">
        New Block List
    </a>

    <button
        class="btn btn-danger oc-icon-trash-o"
        disabled="disabled"
        onclick="$(this).data('request-data', { checked: $('.control-list').listWidget('getChecked') })"
        data-request="onDelete"
        data-request-confirm="Are you sure you want to delete the selected Block Lists?"
        data-trigger-action="enable"
        data-trigger=".control-list input[type=checkbox]"
        data-trigger-condition="checked"
        data-request-success="$(this).prop('disabled', 'disabled')"
        data-stripe-load-indicator>
        Delete selected
    </button>
</div>