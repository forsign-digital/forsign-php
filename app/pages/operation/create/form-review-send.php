<h2 class="h4 fw-normal">Preferências da operação</h2>

<div class="col-xs-12 col-md-4">
    <div class="form-group">
        <label for="inputOperationLanguage">Idioma de preferência</label>
        <select class="form-select" name="operation-language" id="inputOperationLanguage">
            <option value="pt-br" <?= $operation_language === 'pt-br' ? 'selected' : '' ?>>Português</option>
            <option value="en" <?= $operation_language === 'en' ? 'selected' : '' ?>>Inglês</option>
        </select>
    </div>
</div>

<div class="col-xs-12">
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" name="operation-member-movement-warning" value="true" role="switch" id="operationMemberMovementWarning" <?= $operation_member_movement_warning === 'true' ? 'checked' : '' ?>>
        <label class="form-check-label" for="operationMemberMovementWarning">Receber avisos sobre a movimentação dos participantes</label>
    </div>
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" name="operation-display-cover" value="true" role="switch" id="operationDisplayCover" <?= $operation_display_cover === 'true' ? 'checked' : '' ?>>
        <label class="form-check-label" for="operationDisplayCover">Exibir capa e mensagem antes do início da operação</label>
    </div>
</div>

<div class="col-xs-12">
    <div class="form-group">
        <label for="inputOptionalMessage">Mensagem personalizada</label>
        <textarea class="form-control" name="operation-optional-message" id="inputOperationOptionalMessage" maxlength="140"><?= $operation_optional_message ?></textarea>
    </div>
</div>

<h2 class="h4 fw-normal">Resumo da operação</h2>

<div class="col-xs-12">
    <dl class="row">
        <dt class="col-sm-3">Nome da operação</dt>
        <dd class="col-sm-9"><?= $operation_name ?></dd>

        <dt class="col-sm-3">Arquivos</dt>
        <dd class="col-sm-9">
            <?php
            foreach ($operation_files as $key => $file) {
                $size = round($file->size / 1024, 1);
                echo $file->name . ' <small class="form-text">(' . $size . 'KB)</small>';
                if ($key + 1 < count($operation_files)) {
                    echo ', ';
                }
            }
            ?></dd>

        <dt class="col-sm-3">Participantes</dt>
        <dd class="col-sm-9">
            <?php
            echo $operation_members->name;
            ?>
        </dd>

    </dl>
</div>

<div class="col-xs-12 text-sm-end">
    <button type="submit" name="step" value="create" class="btn btn-secondary">Criar operação</button>
</div>