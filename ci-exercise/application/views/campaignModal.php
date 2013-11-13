    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?= $modalTitle ?></h4>
                <?php if (empty($formError) !== true):
                    echo "<h5>$formError</h5>";
                endif; ?>
            </div>
            <div class="modal-body">
                <?= form_open('modal/add', ['id' => 'modal-form', 'class' => 'form-horizontal', 'role' => 'form']) ?>
                    <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <?= form_input([
                                'name' => 'name',
                                'class' => "data-a form-control",
                                'id' => 'inputName',
                                'placeholder' => 'Name',
                                'value' => set_value('name', $name)
                            ]);
                            ?>
                        </div>
                    </div>
                    <input type="hidden" name="modalClient" value="<?= set_value('modalClient', $modalClient) ?>" />
                    <input type="hidden" name="modalType" value="<?= set_value('modalType', $modalType) ?>" />
                    <input type="hidden" name="modalTitle" value="<?= set_value('modalTitle', $modalTitle) ?>" />
                <?= form_close() ?>
            </div>
            <div class="dialog-footer modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="triggerSave" type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->